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
        $data = DB::table('stock_items')
            ->join('products', 'stock_items.product_id', '=', 'products.product_id')
            ->select(
                'stock_items.*',
                'products.product_name',
                'products.cost_price'
            )
            ->get()
            ->map(function ($item) {
                $item->date_receiving = Carbon::parse($item->date_receiving)->format('d/m/Y');
                $item->time_receiving = Carbon::parse($item->time_receiving)->format('H:i:s');
                return $item;
            });

        return view('admin/tables/stock', compact('data'));
    }

    public function create()

    {
        $products = DB::table('products')->get();

        return view('admin/form/stockForm', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required',
            'cost_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'date_receiving' => 'required|date',
            'time_receiving' => 'required|date_format:H:i',
        ]);

        DB::table('stock_items')->insert([
            'product_id' => $validated['product_id'],
            'cost_price' => $validated['cost_price'],
            'quantity' => $validated['quantity'],
            'date_receiving' => $validated['date_receiving'],
            'time_receiving' => $validated['time_receiving'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('stock_items')->with('success', 'Stock item added successfully.');
    }

    public function edit($id)
    {
        $stockItem = DB::table('stock_items')->where('stock_id', $id)->first();

        $products = DB::table('products')->get();


        if (!$stockItem) {
            return redirect()->route('stock_items')->with('error', 'ไม่พบรายการสต็อกที่ต้องการแก้ไข');
        }

        return view('admin/form/stockEdit', compact('stockItem','products'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_id' => 'required',
            'cost_price' => 'required|numeric',
            'quantity' => 'required|integer',
            
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
