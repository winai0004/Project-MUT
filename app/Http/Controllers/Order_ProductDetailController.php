<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Order_ProductDetailController extends Controller
{
    public function index()
    {

        $orders = DB::table('order_shop_detail')
            ->select('user_id', 'fullname', 'created_at', 'status')
            ->groupBy('user_id', 'fullname', 'created_at', 'status') // รวมแถวตาม user_id
            ->get();
    
        return view('admin/tables/order_shopping', compact('orders'));
    }
    
    public function orderview($id)
    {
        $orders = DB::table('order_shop_detail')
            ->where('user_id', $id)
            ->get();
    
        // ส่งข้อมูลไปยัง view
        return view('admin/view/order_view', compact('orders'));
    }
    

    public function updateStatus(Request $request)
        {
            $order_id = $request->input('order_detail_id ');
            $status = $request->input('status');

            DB::table('order_shop_detail')
                ->where('order_detail_id', $order_id)
                ->update(['status' => $status]);

            return response()->json(['success' => true]);
        }
    
        public function delete($id){
            DB::table('order_shopping')->where('order_detail_id',$id)->delete();
            return response()->json(['success' => true]);
        }
    
    
}
