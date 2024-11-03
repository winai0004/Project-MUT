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
        ->select('products.*', 'stock_items.product_id as stock_name' , 'stock_items.quantity as stock_quantity' , 'stock_items.stock_id as stock_stock_id') 
        ->where('products.product_id', $product_id) 
        ->first();
        
        if (!$productItem) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        if ($productItem->stock_quantity == 0) {
            return redirect()->back()->with('error', 'Out of stock');
        }else{
            
        $existingCartItem = DB::table('cart_shopping')
            ->where(compact('user_id', 'product_id', 'color', 'size'))
            ->first();
        

        if ($existingCartItem) {
            DB::table('cart_shopping')
            ->where('cart_id', $existingCartItem->cart_id)
            ->update([
                'quantity' => $existingCartItem->quantity + $quantity,
                'total_price' => ($existingCartItem->quantity + $quantity) *  $price,
                'updated_at' => now(),
            ]);

            DB::table('stock_items')
                ->where('stock_id', $productItem->stock_stock_id)  
                ->update([
                'quantity' => DB::raw('quantity - 1'),
            ]); 

            } else {
                DB::table('cart_shopping')->insert([
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'name' => $productItem->stock_name,
                    'price' =>  $price,
                    'color' => $color,
                    'size' => $size,
                    'total_price' =>  $price * $quantity,
                    'image' => $productItem->product_img,
                    'discount_promotion' => $request->discount_promotion != null ? $request->discount_promotion : null ,
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

    
        $cartTotals = DB::table('cart_shopping')
        ->selectRaw('SUM(quantity) as total_quantity')
        ->selectRaw('SUM(total_price) as total_price')
        ->where('user_id', Auth::user()->id)
        ->first();


        // $cartTotals = DB::table('cart_shopping')
        // ->selectRaw('SUM(quantity) as total_quantity, SUM(total_price) as total_price')
        // ->where('user_id', Auth::user()->id)
        // ->first();
    
        // ส่งตัวแปร $cartItems ไปยังหน้า UI (frontend.cart)
        return view('frontend.cart', ['cartItems' => $cartItems ,'totalQuantity' => $cartTotals->total_quantity,
            'totalPrice' => $cartTotals->total_price]);
    }

    public function update(Request $request)
    {
        $cartId = $request->input('cart_id');
        $quantity = $request->input('quantity');
        $checkMark = filter_var($request->input('checkMark'), FILTER_VALIDATE_BOOLEAN); 
        
        
        // ดึงข้อมูลจาก cart_shopping โดยใช้ cart_id
        $cartItem = DB::table('cart_shopping')->where('cart_id', $cartId)->first();
    
        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found.'], 404);
        }
    
        // ดึงข้อมูลสินค้าจากตาราง products และ stock_items
        // $productItem = DB::table('products')
        //     ->leftJoin('stock_items', 'products.product_id', '=', 'stock_items.product_id')
        //     ->select('products.*', 'stock_items.product_id as product_id') 
        //     ->where('products.product_id', $cartItem->product_id) 
        //     ->first();
    
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
    

    public function delete($cartId)
    {
        $cartItem = DB::table('cart_shopping')->where('cart_id', $cartId)->first();
    
        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found.'], 404);
        }
    
        if ($cartItem->user_id != Auth::user()->id) {
            return response()->json(['error' => 'You do not have permission to delete this item.'], 403);
        }
    
  
        if (!$cartItem->product_id) {
            return response()->json(['error' => 'Product not found.'], 404);
        }
    
        DB::table('cart_shopping')->where('cart_id', $cartId)->delete();

        $total_quantity = $cartItem->quantity;

        DB::table('stock_items')
            ->where('product_id', $cartItem->product_id)
            ->update([
                'quantity' => DB::raw('quantity + ' . $total_quantity), 
            ]);
        
        return response()->json(['success' => 'Item deleted successfully.']);
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
                    'payment_method' => $item['paymentMethod'],
                    'slip' => $filePath,
                    'total_price' => (float)$item['totalPrice'], 
                    'total_quantity' => (int)$item['totalQuantity'], 
                    'status' => 0,
                    'created_at' => now(),
                ]);

                // แปลง JSON ของ cartItems เป็นอาร์เรย์
                $cartItems = $item['cartItems'];
                // print_r(json_encode($item['cartItems']));
                // ตรวจสอบว่าข้อมูลถูกแปลงเป็นอาร์เรย์เรียบร้อย
                // if (is_array($cartItems)) {
                //     DB::table('order_shop_detail')->insert([
                //         'order_shop_detail_id' => $newOrderShopDetailId, // ใช้ newOrderShopDetailId เป็นค่าในคอลัม order_shop_detail_id
                //         'cart_id' => $cartItems['cart_id'],
                //         'user_id' => $cartItems['user_id'],
                //         'product_id' => $cartItems['product_id'],
                //         'quantity' => $cartItems['quantity'],
                //         'name' => $cartItems['name'],
                //         'price' => $cartItems['price'],
                //         'color' => $cartItems['color'],
                //         'size' => $cartItems['size'],
                //         'total_price' => $cartItems['total_price'],
                //         'image' => $cartItems['image'],
                //         'discount_promotion' => $cartItems['discount_promotion'],
                //         'created_at' => $cartItems['created_at'],
                //         'updated_at' => $cartItems['updated_at'],
                //     ]);
                // } else {
                //     // แจ้งเตือนกรณี JSON ไม่ถูกต้อง
                //     throw new \Exception('Invalid JSON format in cartItems.');
                // }

                // ลบข้อมูลในตะกร้า
                DB::table('cart_shopping')->where('user_id', Auth::id())->delete();

                return response()->json(['success' => true]);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }   
    
        public function updateQuantity($id) {
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

