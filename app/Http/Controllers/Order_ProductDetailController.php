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


    // public function orderview($orderId, $orderDetailId, $status)
    // {
    //     $orders = DB::table('item_orders')
    //     ->join('products', 'item_orders.product_id', '=', 'products.product_id')
    //     ->join('shirt_color', 'products.color_id', '=', 'shirt_color.color_id')
    //     ->join('shirt_size_data', 'products.size_id', '=', 'shirt_size_data.size_id')
    //     ->where('item_orders.order_id', $orderId)
    //     ->select('item_orders.*', 'products.*', 'shirt_color.*', 'shirt_size_data.*') // เลือกทุกคอลัมน์จากทั้งสี่ตาราง
    //     ->get();

    //     $orderDetails = DB::table('order_shop_detail')
    //         ->where('order_detail_id', $orderDetailId)
    //         ->first();

    //     $status = $status;

    //     // ส่งข้อมูลไปยัง view
    //     return view('admin.view.order_view', compact('orders', 'orderDetails', 'status'));
    // }

        public function orderview($orderId, $orderDetailId, $status)
    {
        // ดึงข้อมูลคำสั่งซื้อ
        $orders = DB::table('item_orders')
            ->join('products', 'item_orders.product_id', '=', 'products.product_id')
            ->join('shirt_color', 'products.color_id', '=', 'shirt_color.color_id')
            ->join('shirt_size_data', 'products.size_id', '=', 'shirt_size_data.size_id')
            ->where('item_orders.order_id', $orderId)
            ->select('item_orders.*', 'products.*', 'shirt_color.*', 'shirt_size_data.*') // เลือกทุกคอลัมน์จากทั้งสี่ตาราง
            ->get();

        // ดึงข้อมูลรายละเอียดคำสั่งซื้อ
        $orderDetails = DB::table('order_shop_detail')
            ->where('order_detail_id', $orderDetailId)
            ->first();

        // ส่งข้อมูลไปยัง view
        return view('admin.view.order_view', compact('orders', 'orderDetails', 'status'));
    }


    // public function updateStatus(Request $request)
    // {
    //     $order_id = $request->input('order_detail_id ');
    //     $status = $request->input('status');

    //     DB::table('order_shop_detail')
    //         ->where('order_detail_id', $order_id)
    //         ->update(['status' => $status]);

    //     return response()->json(['success' => true]);
    // }

        public function updateStatus(Request $request)
    {
        $order_id = $request->input('order_detail_id'); // รับค่าจาก request
        $status = $request->input('status'); // รับสถานะที่ต้องการอัพเดต

        // อัพเดตสถานะใน order_shop_detail
        DB::table('order_shop_detail')
            ->where('order_detail_id', $order_id)
            ->update(['status' => $status]);

        // ถ้าสถานะเป็น 'success', ลดสต็อกสินค้า
        if ($status == 'success') {
            $orderDetail = DB::table('order_shop_detail')
                ->where('order_detail_id', $order_id)
                ->first();

            $productId = $orderDetail->product_id;  // รับ product_id
            $quantity = $orderDetail->quantity;  // รับจำนวนสินค้า

            // ลดสต็อกสินค้าใน stock_items
            DB::table('stock_items')
                ->where('product_id', $productId)
                ->decrement('quantity', $quantity); // ลดจำนวนสต็อก
        }

        return response()->json(['success' => true]);
    }


    public function delete($id)
    {
        DB::table('order')->where('order_id', $id)->delete();

        DB::table('item_orders')->where('order_id', $id)->delete();

        return response()->json(['success' => true]);
    }
}
