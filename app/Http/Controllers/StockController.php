<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class StockController extends Controller
{
    public function index()
    {
       $data =  DB::table('stock_items')->get() ->map(function($item) {
        $item->date_receiving = Carbon::parse($item->date_receiving)->format('d/m/Y');
        $item->time_receiving = Carbon::parse($item->time_receiving)->format('H:i:s');
        return $item;
    });;
        return view('admin/tables/stock', compact('data'));
    }

    public function create()
    {
        return view('admin/form/stockForm');
    }

   public function store(Request $request)
    {
        // Validate ข้อมูลที่รับจากฟอร์ม
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'employee_name' => 'required|string|max:255',
            'date_receiving' => 'required|date',
            'time_receiving' => 'required',
            'status' => 'required|integer',
        ]);

        DB::table('stock_items')->insert([
            'stock_order' =>  strtoupper(uniqid()),
            'name' => $validated['name'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'employee_name' => $validated['employee_name'],
            'date_receiving' => $validated['date_receiving'],
            'time_receiving' => $validated['time_receiving'],
            'status' => $validated['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('stock_items')->with('success', 'Stock item added successfully.');
    }

    public function edit($id)
    {
        $stockItem = DB::table('stock_items')->where('stock_id', $id)->first();

        if (!$stockItem) {
            return redirect()->route('stock_items')->with('error', 'ไม่พบรายการสต็อกที่ต้องการแก้ไข');
        }

        return view('admin/form/stockEdit', compact('stockItem'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'employee_name' => 'required|string|max:255',
            'status' => 'required|integer',
        ]);

        DB::table('stock_items')
            ->where('stock_id', $id)
            ->update($validatedData);

        return redirect()->route('stock_items')->with('success', 'รายการสต็อกถูกอัปเดตเรียบร้อยแล้ว');
    }


    public function destroy($id)
    {
        DB::table('stock_items')->where('stock_id', $id)->delete();

        return redirect('admin/tables/stock')->with('success', 'รายการสต็อกถูกลบเรียบร้อยแล้ว');
    }
}
