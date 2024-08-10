<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Auth;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,product_id',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'color' => 'required|string',
            'size' => 'required|string',
        ]);
    
        $user = Auth::user();
    
        $cart = Cart::where('member_id', $user->id) // แก้ไขจาก user_id เป็น member_id
                    ->where('product_id', $request->product_id)
                    ->where('color', $request->color)
                    ->where('size', $request->size)
                    ->first();
    
        if ($cart) {
            $cart->quantity += 1;
            $cart->save();
        } else {
            Cart::create([
                'member_id' => $user->id, // แก้ไขจาก user_id เป็น member_id
                'product_id' => $request->product_id,
                'name' => $request->name,
                'price' => $request->price,
                'color' => $request->color,
                'size' => $request->size,
                'quantity' => 1
            ]);
        }
    
        return redirect()->route('cart.show')->with('success', 'Product added to cart');
    }

    public function show()
    {
        $user = Auth::user();
        $cartItems = Cart::where('member_id', $user->id)->get(); // แก้ไขจาก user_id เป็น member_id

        return view('frontend.cart', compact('cartItems'));
    }

    public function remove($id)
    {
        $user = Auth::user();
        $cartItem = Cart::where('member_id', $user->id)->where('cart_id', $id)->first(); // แก้ไขจาก user_id เป็น member_id

        if ($cartItem) {
            $cartItem->delete();
            return redirect()->route('cart.show')->with('success', 'Product removed from cart');
        } else {
            return redirect()->route('cart.show')->with('error', 'Product not found in cart');
        }
    }

    public function checkout()
    {
        // $user = Auth::user();
        // $cartItems = Cart::where('member_id', $user->id)->get(); // แก้ไขจา�� user_id เป็น member_id

        return view('frontend.checkout');
    }
}

