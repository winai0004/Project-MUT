<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Order_ProductDetailController extends Controller
{
    public function index()
    {
        $orders = DB::table('order')
            ->join('users', 'order.user_id', '=', 'users.id') 
            ->select('order.*', 'users.name as fullname') 
            ->get();
    
        return view('admin.tables.order_shopping', compact('orders'));
    }
    
    
    public function orderview($orderId, $orderDetailId ,$status)
    {
        // ดึงข้อมูลรายการสินค้าตาม order_id
        $orders = DB::table('item_orders')
            ->where('order_id', $orderId) // กรองตาม order_id
            ->get();
        
        // หากต้องการดึงรายละเอียดของ order_detail_id สามารถทำได้ที่นี่
        // เช่น
        $orderDetails = DB::table('order_shop_detail')
            ->where('order_detail_id', $orderDetailId) // หรือชื่อคอลัมน์ที่ถูกต้อง
            ->first();

        $status = $status;
    
        // ส่งข้อมูลไปยัง view
        return view('admin.view.order_view', compact('orders', 'orderDetails','status'));
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
    
        public function delete($id)
        {
            DB::table('order')->where('order_id', $id)->delete();
            
            DB::table('item_orders')->where('order_id', $id)->delete();
            
            return response()->json(['success' => true]);
        }
        
    
    
}
