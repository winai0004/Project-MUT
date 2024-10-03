<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportSalesController extends Controller
{
    //
    public function index(){
        // $sales = DB::table('sales')->get();

        return view('admin/tables/report');
    }

    //ดึงตาราง order_shopping  มาแล้ว map เอาชื่อสินค้า ราคา จำนวน ของวันนั้นมารวมกัน 
}
