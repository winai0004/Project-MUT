<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $user_id = Auth::user()->id;
        $product_id = $request->input('product_id');
        $color = $request->input('color');
        $size = $request->input('size');
        $quantity = $request->input('quantity', 1);
    
        $productItem = DB::table('products')->where('product_id', $product_id)->first();
    
        if (!$productItem) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        $existingCartItem = DB::table('cart_shopping')
            ->where(compact('user_id', 'product_id', 'color', 'size'))
            ->first();

        
    
        if ($existingCartItem) {
            DB::table('cart_shopping')
                ->where('cart_id', $existingCartItem->cart_id)
                ->update([
                    'quantity' => $existingCartItem->quantity + $quantity,
                    'total_price' => ($existingCartItem->quantity + $quantity) * $productItem->selling_price,
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('cart_shopping')->insert([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'quantity' => $quantity,
                'name' => $productItem->product_name,
                'price' => $productItem->selling_price,
                'color' => $color,
                'size' => $size,
                'total_price' => $productItem->selling_price * $quantity,
                'image' => $productItem->product_img,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    
        return redirect()->route('cartview')->with('success', 'Product added to cart!');
    }
    
    public function cartview()
    {
        $user_id = Auth::user()->id;
    
        $cartItems = DB::table('cart_shopping')
            ->where('user_id', $user_id)
            ->get(); // ใช้ get() เพื่อดึงหลายรายการ
    
        $cartTotals = DB::table('cart_shopping')
        ->selectRaw('SUM(quantity) as total_quantity')
        ->selectRaw('SUM(total_price) as total_price')
        ->where('user_id', Auth::user()->id)
        ->first();

    
        // ส่งตัวแปร $cartItems ไปยังหน้า UI (frontend.cart)
        return view('frontend.cart', ['cartItems' => $cartItems ,'totalQuantity' => $cartTotals->total_quantity,
            'totalPrice' => $cartTotals->total_price]);
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $cartId = $request->input('cart_id');
        $quantity = $request->input('quantity');

        DB::table('cart_shopping')
            ->where('cart_id', $cartId)
            ->update([
                'quantity' => $quantity,
                'total_price' => DB::raw('price * ' . $quantity), // อัปเดตราคาทั้งหมดตามจำนวนสินค้าใหม่
                'updated_at' => now(),
            ]);

        return response()->json(['success' => 'Cart item updated successfully.']);
    }


    public function delete($cartId)
    {
        $cartItem = DB::table('cart_shopping')->where('cart_id', $cartId)->first();
    
        if ($cartItem && $cartItem->user_id == Auth::user()->id) {
            DB::table('cart_shopping')->where('cart_id', $cartId)->delete();
            return response()->json(['success' => 'Item deleted successfully.']);
        } else {
            return response()->json(['error' => 'Item not found or you do not have permission to delete this item.'], 403);
        }
    }

    public function getCartTotals() {
        $cartTotals = DB::table('cart_shopping')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->selectRaw('SUM(total_price) as total_price')
            ->where('user_id', Auth::user()->id)
            ->first();
    
        return response()->json([
            'totalQuantity' => $cartTotals->total_quantity,
            'totalPrice' => $cartTotals->total_price
        ]);
    }
    
    
    public function checkoutView()
    {
        return view('frontend.checkout');
    }

    public function checkoutAdd(Request $request)
        {
            try {
                $item = json_decode($request->input('item'), true);
                if (!$item) {
                    throw new \Exception('Invalid item data.');
                }

                $formFile = $request->file('formFile');
                if (!$formFile) {
                    throw new \Exception('File not uploaded.');
                }

                // การจัดเก็บไฟล์
                $filePath = $formFile->store('uploads', 'public');

                // การจัดเก็บข้อมูลในฐานข้อมูล
                DB::table('order_shopping')->insert([
                    'user_id' => Auth::id(),
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'order_items' => json_encode($item['cartItems']),
                    'fullname' => $item['name'],
                    'telephone' => $item['telephone'],
                    'address' => $item['address'],
                    'payment_method' => $item['paymentMethod'],
                    'slip' => $filePath,
                    'total_price' => (float)$item['totalPrice'], 
                    'total_quantity' => (int)$item['totalQuantity'], 
                    'status' => 0,
                    'created_at' => now(),
                ]);

                // ลบข้อมูลในตะกร้า
                DB::table('cart_shopping')->where('user_id', Auth::id())->delete();

                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }   
    
}

