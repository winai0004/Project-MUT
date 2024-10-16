<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    public function index() {
        $products = DB::table('products')
        ->leftJoin('product_category_data', 'products.category_id', '=', 'product_category_data.category_id')
        ->leftJoin('stock_items', 'products.stock_id', '=', 'stock_items.stock_id') 
        ->select(
            'products.*',
            'product_category_data.category_name',
            'stock_items.name as stock_name'
        )
        ->get();
    


        return view('admin/tables/products', compact('products'))
        ->with('products', $products->map(function($item) {
            $item->selling_price = number_format((float)$item->selling_price, 2, '.', ',');
            return $item;
        }));
    
    }

    public function create() {
        $stocks = DB::table('stock_items')->get();
        $categories = DB::table('product_category_data')->get();
        return view('admin/form/productsForm', compact('categories','stocks'));
    }

    public function view() {
        $products = DB::table('products')
            ->leftJoin('product_category_data', 'products.category_id', '=', 'product_category_data.category_id')
            ->leftJoin('stock_items', 'products.stock_id', '=', 'stock_items.stock_id') 
            ->select('products.*', 'product_category_data.category_name',  'stock_items.name as stock_name')
            ->paginate(8);

        return view('frontend/welcomeuser', compact('products'));
    }

    public function Detailview($id) {

        $promotion_valid = false;

        if (Auth::check()) {
            $product = DB::table('products')
           
            ->leftJoin('product_category_data', 'products.category_id', '=', 'product_category_data.category_id')
            ->leftJoin('stock_items', 'products.stock_id', '=', 'stock_items.stock_id')
            ->select(
                'products.*', 
                'product_category_data.category_name',
                'stock_items.name as stock_name'
            )
            ->where('products.product_id', $id)
            ->first();
            if ($product) {
                $promotion = DB::table('promotion_data')
                    ->where('stock_id', $product->stock_id)
                    ->first();
            
                if ($promotion && $promotion->discount != null) {
                    $promotion_valid = true;
                } else {
                    $promotion_valid = false;
                }
            } else {
                $promotion = null; 
                $promotion_valid = false; 
            }
            
           
        
        
        $sizes = DB::table('shirt_size_data')->get();
        $colors = DB::table('shirt_color')->get();

        return view('frontend/product_detail', compact('product', 'sizes', 'colors','promotion','promotion_valid'));
        } else {
            return redirect()->route('login');
        }
       
    }

    public function insert(Request $request) {
        $request->validate([
            'stock_id' => 'required',
            'product_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cost_price' => 'required',
            'selling_price' => 'required',
            'category_id' => 'required',
          
        ], [
            'stock_id.required' => 'กรุณากรอกชื่อสินค้า',
            'product_img.required' => 'กรุณาเลือกรูปภาพสินค้า',
            'product_img.image' => 'กรุณาเลือกไฟล์ภาพ',
            'cost_price.required' => 'กรุณากรอกราคาทุน',
            'selling_price.required' => 'กรุณากรอกราคาขาย',
            'category_id.required' => 'กรุณาเลือกประเภท',
          
        ]);

        $imageName = time() . '.' . $request->product_img->extension();

        $data = [
            'stock_id' => $request->stock_id,
            'product_img' => $imageName,
            'category_id' => $request->category_id,
          
            'cost_price' => $request->cost_price,
            'selling_price' => $request->selling_price,
        ];

        $request->product_img->move(public_path('images'), $imageName);

        DB::table('products')->insert($data);

        return redirect('admin/tables/products');
    }

    public function delete($id)
    {
        DB::beginTransaction();
    
        try {
            DB::table('carts')->where('product_id', $id)->delete();
            DB::table('products')->where('product_id', $id)->delete();

            DB::commit();
            return redirect('admin/tables/products')->with('success', 'Product and related carts deleted successfully.');
        
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('admin/tables/products')->with('error', 'An error occurred while deleting the product.');
        }
    }
    

    public function edit($id) {
        $products = DB::table('products')->where('product_id', $id)->first();
        $productCategoryID = $products->category_id;
        $sizeId = $products->size_id;
        $colorId = $products->color_id;
        $stockId = $products->stock_id;
        $categories = DB::table('product_category_data')->get();
   
        $stocks = DB::table('stock_items')->get();
        return view('admin/form/productsEdit', compact('products', 'categories', 'productCategoryID', 'sizeId', 'colorId','stocks','stockId'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'stock_id' => 'nullable',
            'cost_price' => 'nullable',
            'selling_price' => 'nullable',
            'category_id' => 'nullable',
        ]);

        $data = [
            'stock_id' => $request->stock_id,
            'category_id' => $request->category_id,
            'cost_price' => $request->cost_price,
            'selling_price' => $request->selling_price
        ];

        if ($request->hasFile('product_img')) {
            $request->validate([
                'product_img' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ], [
                'product_img.image' => 'กรุณาเลือกไฟล์ภาพ',
            ]);

            $product = DB::table('products')->where('product_id', $id)->first();
            if ($product && $product->product_img) {
                $oldImagePath = public_path('images/' . $product->product_img);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $imageName = time() . '.' . $request->product_img->extension();
            $request->product_img->move(public_path('images'), $imageName);

            $data['product_img'] = $imageName;
        }

        DB::table('products')->where('product_id', $id)->update($data);

        return redirect('admin/tables/products');
    }


    public function getProductPrice($id)
    {
        $stock = DB::table('stock_items')->where('stock_id', $id)->first();
            if ($stock) {
            return response()->json([
                'price' => $stock->price, 
            ]);
        } else {
            return response()->json([
                'error' => 'Product not found'
            ], 404);
        }
    }

}
