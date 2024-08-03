<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Order_itemController extends Controller
{
    public function index()
    {
        $saleproduct = DB::table('sale_product')->get();

        return view('admin/tables/sale_products', compact('saleproduct'));
    }
}

