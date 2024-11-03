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
        $price = $request->input('price');
        $discount_promotion = $request->input('discount_promotion');



        $productItem = DB::table('products')
            ->leftJoin('stock_items', 'products.product_id', '=', 'stock_items.product_id')
            ->select('products.*', 'stock_items.quantity as stock_quantity', 'stock_items.stock_id as stock_stock_id')
            ->where('products.product_id', $product_id)
            ->first();

        if (!$productItem) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        if ($productItem->stock_quantity == 0) {
            return redirect()->back()->with('error', 'Out of stock');
        } else {

            $existingCartItem = DB::table('cart_shopping')
                ->where(compact('user_id', 'product_id', 'color', 'size'))
                ->first();

            $existingCartDetail = DB::table('order_shop_detail')
                ->where(compact('user_id', 'color', 'size'))
                ->first();


            if ($existingCartItem &&  $existingCartDetail) {
                DB::table('cart_shopping')
                    ->where('cart_id', $existingCartItem->cart_id)
                    ->update([
                        'quantity' => $existingCartItem->quantity + $quantity,
                        'total_price' => ($existingCartItem->quantity + $quantity) *  $price,
                        'updated_at' => now(),
                    ]);


                DB::table('order_shop_detail')
                    ->where('order_detail_id',  $existingCartDetail->order_detail_id)
                    ->update([
                        'total_quantity' => $existingCartItem->quantity + $quantity,
                        'total_price' => ($existingCartItem->quantity + $quantity) *  $price,
                        'created_at' => now(),
                    ]);

                DB::table('stock_items')
                    ->where('stock_id', $productItem->stock_stock_id)
                    ->update([
                        'quantity' => DB::raw('quantity - 1'),
                    ]);
            } else {

                // เพิ่มข้อมูลในตาราง order_shop_detail และรับ order_detail_id
                $orderDetailId = DB::table('order_shop_detail')->insertGetId([
                    'order_number' => 'ORD-' . strtoupper(uniqid()),
                    'user_id' => $user_id,
                    'name' => $productItem->product_name,
                    'image' =>  $productItem->product_img,
                    'color' => $color,
                    'size' => $size,
                    'total_quantity' => $quantity,
                    'total_price' => $price * $quantity,
                    'status' => 0,
                    'created_at' => now(),
                ]);

                // ใช้ order_detail_id ที่ได้มาเพื่อเพิ่มข้อมูลในตาราง cart_shopping
                DB::table('cart_shopping')->insert([
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'order_detail_id' => $orderDetailId, // ใช้ order_detail_id ที่ได้
                    'quantity' => $quantity,
                    'name' => $productItem->product_name,
                    'price' =>  $price,
                    'color' => $color,
                    'size' => $size,
                    'total_price' =>  $price * $quantity,
                    'image' => $productItem->product_img,
                    'discount_promotion' => $request->discount_promotion != null ? $request->discount_promotion : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);



               

                DB::table('stock_items')
                    ->where('stock_id', $productItem->stock_stock_id)
                    ->update([
                        'quantity' => DB::raw('quantity - 1'),
                    ]);
            }
        }

        return redirect()->route('cartview')->with('success', 'Product added to cart!');
    }

    public function cartview()
    {
        $user_id = Auth::user()->id;

        $cartItems = DB::table('cart_shopping')
            ->where('user_id', $user_id)
            ->get();



        $orderDetail = DB::table('order_shop_detail')
            ->where('user_id', $user_id)
            ->first();

        $orderDetailId = $orderDetail->order_detail_id ?? null;




        $cartTotals = DB::table('cart_shopping')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->selectRaw('SUM(total_price) as total_price')
            ->where('user_id', Auth::user()->id)
            ->first();


        // ส่งตัวแปร $cartItems ไปยังหน้า UI (frontend.cart)
        return view('frontend.cart', [
            'cartItems' => $cartItems,
            'totalQuantity' => $cartTotals->total_quantity,
            'totalPrice' => $cartTotals->total_price,
            'orderDetailId' =>  $orderDetailId
        ]);
    }

    public function update(Request $request)
    {
        $cartId = $request->input('cart_id');
        $orderDetailId = $request->input('orderDetailId');

        $quantity = $request->input('quantity');
        $checkMark = filter_var($request->input('checkMark'), FILTER_VALIDATE_BOOLEAN);


        // ดึงข้อมูลจาก cart_shopping โดยใช้ cart_id
        $cartItem = DB::table('cart_shopping')->where('cart_id', $cartId)->first();


        $orderDetail = DB::table('order_shop_detail')->where('order_detail_id', $orderDetailId)->first();

        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found.'], 404);
        }


        if (!$cartItem->product_id) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        // อัปเดตจำนวนสินค้าในตะกร้าและราคาทั้งหมด
        DB::table('cart_shopping')
            ->where('product_id', $cartItem->product_id)
            ->update([
                'quantity' => $quantity,
                'total_price' => DB::raw('price * ' . $quantity), // อัปเดตราคาตามจำนวน
                'updated_at' => now(),
            ]);


        // อัปเดตจำนวนสินค้าในรายละเอียดสินค้า
        DB::table('order_shop_detail')
            ->where('order_detail_id', $orderDetail->order_detail_id)
            ->update([
                'total_quantity' => $quantity,
                'total_price' => DB::raw('total_price * ' . $quantity), // อัปเดตราคาตามจำนวน
                'created_at' => now(),
            ]);


        if ($checkMark) {
            DB::table('stock_items')
                ->where('product_id', $cartItem->product_id)
                ->update([
                    'quantity' => DB::raw('quantity - 1'),
                ]);
        } else {
            DB::table('stock_items')
                ->where('product_id', $cartItem->product_id)
                ->update([
                    'quantity' => DB::raw('quantity + 1'),
                ]);
        }

        return response()->json(['success' => 'Cart item updated successfully.']);
    }


    public function delete(Request $request)
    {
        $cartId = $request->input('cartId');
        $orderDetailId = $request->input('orderDetailId');

    
        $cartItem = DB::table('cart_shopping')->where('cart_id', $cartId)->first();
    
        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found.'], 404);
        }
    
        if ($cartItem->user_id != Auth::id()) {
            return response()->json(['error' => 'You do not have permission to delete this item.'], 403);
        }
    
        $orderDetail = DB::table('order_shop_detail')->where('order_detail_id', $orderDetailId)->first();
    
        if (!$orderDetail) {
            return response()->json(['error' => 'Order detail not found.'], 404);
        }
    
        if (!$cartItem->product_id) {
            return response()->json(['error' => 'Product not found.'], 404);
        }
    
        DB::table('cart_shopping')->where('cart_id', $cartId)->delete();

        DB::table('order_shop_detail')->where('order_detail_id', $orderDetailId)->delete();
    
        // คืนจำนวนสินค้าใน stock_items
        $total_quantity = $cartItem->quantity;
    
        DB::table('stock_items')
            ->where('product_id', $cartItem->product_id)
            ->update([
                'quantity' => DB::raw('quantity + ' . $total_quantity),
            ]);
    
        return response()->json(['success' => 'Item deleted successfully.']);
    }
    

    public function getCartTotals()
    {
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
                //updaate code 10/31/2024
                $newOrderShopDetailId = 1;
                $orderShopDetailId = DB::table('order_shop_detail')
                ->max('order_shop_detail_id');

                if (is_null($orderShopDetailId)) {
                    $newOrderShopDetailId = 1;
                } else {
                    $newOrderShopDetailId = $orderShopDetailId + 1;
                }

                $item = json_decode($request->input('item'), true);
                if (!$item) {
                    throw new \Exception('Invalid item data.');
                }
               
                $formFile = $request->file('formFile');
                if (!$formFile) {
                    throw new \Exception('File not uploaded.');
                }
    public function updateDetailsCart(Request $request)
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
                    // 'order_items' => $newOrderShopDetailId,
                    'order_items' => json_encode($item['cartItems']),
                    'fullname' => $item['name'],
                    'telephone' => $item['telephone'],
                    'address' => $item['address'],
            $filePath = $formFile->store('uploads', 'public');

            $user_id = Auth::user()->id;

            // ดึง order_detail_id จาก cart_shopping ตาม user_id
            $orderDetailIds = DB::table('cart_shopping')
            ->where('user_id', $user_id)
            ->pluck('order_detail_id') // ดึง order_detail_id
            ->toArray(); // แปลงเป็นอาเรย์
        
        if (!empty($orderDetailIds)) {
            // เตรียมข้อมูลสำหรับการอัพเดท
            DB::table('order_shop_detail')
                ->whereIn('order_detail_id', $orderDetailIds) // ใช้ whereIn เพื่อลดการ query
                ->update([
                    'fullname' => $item['name'], // ค่าจากข้อมูลที่ส่งมา
                    'payment_method' => $item['paymentMethod'],
                    'slip' => $filePath,
                    'address' => $item['address'],
                    'telephone' => $item['telephone'],
                    'status' => 1, // successful
                    'created_at' => now(),
                ]);
        }
        

            DB::table('cart_shopping')->where('user_id', Auth::id())->delete();


            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


   
    public function updateQuantity($id)
    {
        $stock = DB::table('products')
            ->leftJoin('stock_items', 'products.product_id', '=', 'stock_items.product_id')
            ->select('stock_items.quantity')
            ->where('products.product_id', $id)
            ->first();

        if ($stock) {
            if ($stock->quantity == 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'สินค้าหมดสต็อกแล้ว.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'สินค้ายังมีสต็อกอยู่.',
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'ไม่พบข้อมูลสินค้านี้ในระบบ.',
            ], 404);
        }
    }
}
