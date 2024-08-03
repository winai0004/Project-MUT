<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index() {
        $products = DB::table('products')
            ->leftJoin('shirt_color', 'products.color_id', '=', 'shirt_color.color_id')
            ->leftJoin('shirt_size_data', 'products.size_id', '=', 'shirt_size_data.size_id')
            ->leftJoin('product_category_data', 'products.category_id', '=', 'product_category_data.category_id')
            ->select('products.*', 'shirt_color.color_name', 'shirt_size_data.size_name', 'product_category_data.category_name')
            ->get();

        return view('admin/tables/products', compact('products'))
            ->with('products', $products->map(function($item) {
                $item->selling_price = number_format($item->selling_price, 2);
                return $item;
            }));
    }

    public function create() {
        $sizes = DB::table('shirt_size_data')->get();
        $colors = DB::table('shirt_color')->get();
        $categories = DB::table('product_category_data')->get();
        return view('admin/form/productsForm', compact('sizes', 'colors', 'categories'));
    }

    public function view() {
        $products = DB::table('products')
            ->leftJoin('shirt_color', 'products.color_id', '=', 'shirt_color.color_id')
            ->leftJoin('shirt_size_data', 'products.size_id', '=', 'shirt_size_data.size_id')
            ->leftJoin('product_category_data', 'products.category_id', '=', 'product_category_data.category_id')
            ->select('products.*', 'shirt_color.color_name', 'shirt_size_data.size_name', 'product_category_data.category_name')
            ->paginate(8);

        return view('frontend/welcomeuser', compact('products'));
    }

    public function Detailview($id) {
        $product = DB::table('products')
            ->leftJoin('shirt_color', 'products.color_id', '=', 'shirt_color.color_id')
            ->leftJoin('shirt_size_data', 'products.size_id', '=', 'shirt_size_data.size_id')
            ->leftJoin('product_category_data', 'products.category_id', '=', 'product_category_data.category_id')
            ->select('products.*', 'shirt_color.color_name', 'shirt_size_data.size_name', 'product_category_data.category_name')
            ->where('product_id', $id)
            ->first();

        $sizes = DB::table('shirt_size_data')->get();
        $colors = DB::table('shirt_color')->get();

        return view('frontend/product_detail', compact('product', 'sizes', 'colors'));
    }

    public function insert(Request $request) {
        $request->validate([
            'product_name' => 'required',
            'product_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cost_price' => 'required',
            'selling_price' => 'required',
            'category_id' => 'required',
            'color_id' => 'required',
            'size_id' => 'required'
        ], [
            'product_name.required' => 'กรุณากรอกชื่อสินค้า',
            'product_img.required' => 'กรุณาเลือกรูปภาพสินค้า',
            'product_img.image' => 'กรุณาเลือกไฟล์ภาพ',
            'cost_price.required' => 'กรุณากรอกราคาทุน',
            'selling_price.required' => 'กรุณากรอกราคาขาย',
            'category_id.required' => 'กรุณาเลือกประเภท',
            'color_id.required' => 'กรุณาเลือกสี',
            'size_id.required' => 'กรุณาเลือกไซส์'
        ]);

        $imageName = time() . '.' . $request->product_img->extension();

        $data = [
            'product_name' => $request->product_name,
            'product_img' => $imageName,
            'category_id' => $request->category_id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
            'cost_price' => $request->cost_price,
            'selling_price' => $request->selling_price
        ];

        $request->product_img->move(public_path('images'), $imageName);

        DB::table('products')->insert($data);

        return redirect('admin/tables/products');
    }

    public function delete($id) {
        DB::table('products')->where('product_id', $id)->delete();
        return redirect('admin/tables/products');
    }

    public function edit($id) {
        $products = DB::table('products')->where('product_id', $id)->first();
        $productCategoryID = $products->category_id;
        $sizeId = $products->size_id;
        $colorId = $products->color_id;
        $categories = DB::table('product_category_data')->get();
        $sizes = DB::table('shirt_size_data')->get();
        $colors = DB::table('shirt_color')->get();
        return view('admin/form/productsEdit', compact('products', 'categories', 'sizes', 'colors', 'productCategoryID', 'sizeId', 'colorId'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'product_name' => 'required',
            'cost_price' => 'required',
            'selling_price' => 'required',
            'category_id' => 'required',
            'color_id' => 'required',
            'size_id' => 'required'
        ], [
            'product_name.required' => 'กรุณากรอกชื่อสินค้า',
            'cost_price.required' => 'กรุณากรอกราคาทุน',
            'selling_price.required' => 'กรุณากรอกราคาขาย',
            'category_id.required' => 'กรุณาเลือกประเภท',
            'color_id.required' => 'กรุณาเลือกสี',
            'size_id.required' => 'กรุณาเลือกไซส์'
        ]);

        $data = [
            'product_name' => $request->product_name,
            'category_id' => $request->category_id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
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
}
