<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Auth;

class CartController extends Controller
{
    

    public function cartview()
    {
       
        return view('frontend.cart');
    }


    public function checkout()
    {
        // $user = Auth::user();
        // $cartItems = Cart::where('member_id', $user->id)->get(); // แก้ไขจา�� user_id เป็น member_id

        return view('frontend.checkout');
    }
}

