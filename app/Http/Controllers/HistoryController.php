<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    //
    public function index($id)
    {
        $orders = DB::table('order')
            ->join('users', 'order.user_id', '=', 'users.id')
            ->select('order.*', 'users.name as fullname')
            ->where('user_id', $id)
            ->get();

        return view('frontend.history', compact('orders'));
    }
}
