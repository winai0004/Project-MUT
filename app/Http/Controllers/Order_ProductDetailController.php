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

        $order_id = $orderId;
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
        return view('admin.view.order_view', compact('orders', 'orderDetails', 'status', 'order_id'));
    }


    public function updateStatus(Request $request)
    {
        $order_id = $request->input('order_id');
        $status = $request->input('status');

        // อัปเดตสถานะคำสั่งซื้อ
        DB::table('order')
            ->where('order_id', $order_id)
            ->update(['status' => $status]);

        return response()->json(['success' => true, 'message' => 'Order status updated.']);
    }


    public function delete($id)
    {
        // ตรวจสอบว่ามีคำสั่งซื้อหรือไม่
        $itemOrder = DB::table('item_orders')->where('order_id', $id)->first();

        if (!$itemOrder) {
            return response()->json(['success' => false, 'message' => 'Order not found.']);
        }

        // รับข้อมูล product_id และ quantity
        $productId = $itemOrder->product_id;
        $quantity = $itemOrder->total_quantity;

        // ตรวจสอบว่ามีข้อมูลสต็อกสินค้าที่ต้องการลดหรือไม่
        $stockItem = DB::table('stock_items')->where('product_id', $productId)->first();

        if (!$stockItem || $stockItem->quantity < $quantity) {
            return response()->json(['success' => false, 'message' => 'Not enough stock or stock item not found.']);
        }

        // ลดจำนวนสินค้าในสต็อก
        DB::table('stock_items')
            ->where('product_id', $productId)
            ->decrement('quantity', $quantity);

        // ลบคำสั่งซื้อและรายการคำสั่งซื้อที่เกี่ยวข้อง
        DB::table('order')->where('order_id', $id)->delete();
        DB::table('item_orders')->where('order_id', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Order and related items deleted, stock updated.']);
    }
}
