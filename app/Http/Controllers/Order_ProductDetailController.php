<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Order_ProductDetailController extends Controller
{
    public function index()
    {
        $orders = DB::table('order_shopping')->get();

        return view('admin/tables/order_shopping',compact('orders'));
    }

    public function orderview($id)
    {
        $order = DB::table('order_shopping')->where('order_id', $id)->first();

        return view('admin/view/order_view', compact('order'));
    }

    public function updateStatus(Request $request)
        {
            $order_id = $request->input('order_id');
            $status = $request->input('status');

            DB::table('order_shopping')
                ->where('order_id', $order_id)
                ->update(['status' => $status]);

            return response()->json(['success' => true]);
        }
    
        public function delete($id){
            DB::table('order_shopping')->where('order_id',$id)->delete();
            return response()->json(['success' => true]);
        }
    
    
}
