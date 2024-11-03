<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportSalesController extends Controller
{
    public function index(Request $request)
    {
        $selectedDate = $request->input('day', Carbon::now()->toDateString()); 
    
        $topSellingItems = DB::table('item_orders')
            ->select('name', DB::raw('SUM(total_quantity) as total_quantity'), DB::raw('MIN(image) as image')) // ดึงรูปภาพด้วย
            ->whereDate('created_at', $selectedDate) 
            ->groupBy('name') 
            ->orderBy('total_quantity', 'desc') 
            ->take(5) 
            ->get();
    
        return view('admin.tables.report', compact('topSellingItems', 'selectedDate'));
    }
    
    

}

