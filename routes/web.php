<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShirtTypeNameController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShirtcolorController;
use App\Http\Controllers\ShirtSizeController;
use App\Http\Controllers\MembershiplevelController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\employeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\permissionController;
use App\Http\Controllers\reportsalesController;
use App\Http\Controllers\promotionController;
use App\Http\Controllers\advertController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Sale_ProductController;
use App\Http\Controllers\Order_ProductDetailController;
use App\Http\Controllers\Order_itemController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ReportStockController;
use App\Http\Controllers\UnsoldProductsReportController;
use App\Http\Controllers\PromotionsReportController;
use App\Http\Controllers\ReportCostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('dashboard', [CustomAuthController::class, 'dashboard'])->name('dashboard');
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login/{status}', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('register', [CustomAuthController::class, 'registration'])->name('register');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

//products
Route::get('admin/tables/products', [ProductController::class, 'index'])->name('products');
Route::get('admin/form/productsForm', [ProductController::class, 'create'])->name('form_products');
Route::post('admin/form/productsForm', [ProductController::class, 'insert'])->name('insert_products');
Route::get('admin/products/edit/{id}', [ProductController::class, 'edit'])->name('edit_products');
Route::get('admin/products/delete/{id}', [ProductController::class, 'delete'])->name('delete_products');
Route::post('admin/products/update/{id}', [ProductController::class, 'update'])->name('update_products');
Route::get('/get-product-price/{id}', [ProductController::class, 'getProductPrice']);


//shirtTypeName
Route::get('admin/tables/shirtTypeName', [ShirtTypeNameController::class, 'index'])->name('shirt');
Route::get('admin/form/shirtTypeNameForm', [ShirtTypeNameController::class, 'create'])->name('form_shirt');
Route::post('admin/form/shirtTypeNameForm', [ShirtTypeNameController::class, 'insert'])->name('insert_shirt');
Route::get('admin/shirtTypeName/edit/{id}', [ShirtTypeNameController::class, 'edit'])->name('edit_shirt');
Route::get('admin/shirtTypeName/delete/{id}', [ShirtTypeNameController::class, 'delete'])->name('delete_shirt');
Route::post('admin/shirtTypeName/update/{id}', [ShirtTypeNameController::class, 'update'])->name('update_shirt');


//shirtcolor
Route::get('admin/tables/shirtcolor', [ShirtcolorController::class, 'index'])->name('shirtcolor');
Route::get('admin/form/shirtColorForm', [ShirtcolorController::class, 'create'])->name('form_shirtcolor');
Route::post('admin/form/shirtColorForm', [ShirtcolorController::class, 'insert'])->name('insert_shirtcolor');
Route::get('admin/shirtcolor/edit/{id}', [ShirtcolorController::class, 'edit'])->name('edit_shirtcolor');
Route::get('admin/shirtcolor/delete/{id}', [ShirtcolorController::class, 'delete'])->name('delete_shirtcolor');
Route::post('admin/shirtcolor/update/{id}', [ShirtcolorController::class, 'update'])->name('update_shirtcolor');


//shirtsize
Route::get('admin/tables/shirtsize', [ShirtSizeController::class, 'index'])->name('shirtsize');
Route::get('admin/form/shirtSizeForm', [ShirtSizeController::class, 'create'])->name('form_shirtsize');
Route::post('admin/form/shirtSizeForm', [ShirtSizeController::class, 'insert'])->name('insert_shirtsize');
Route::get('admin/shirtsize/edit/{id}', [ShirtSizeController::class, 'edit'])->name('edit_shirtsize');
Route::get('admin/shirtsize/delete/{id}', [ShirtSizeController::class, 'delete'])->name('delete_shirtsize');
Route::post('admin/shirtsize/update/{id}', [ShirtSizeController::class, 'update'])->name('update_shirtsize');

//employee
Route::get('admin/tables/employee', [employeeController::class, 'index'])->name('employee');
Route::get('admin/form/employeeForm', [employeeController::class, 'create'])->name('form_employee');
Route::post('admin/form/employeeForm', [employeeController::class, 'insert'])->name('insert_employee');
Route::get('admin/employee/edit/{id}', [employeeController::class, 'edit'])->name('edit_employee');
Route::get('admin/employee/delete/{id}', [employeeController::class, 'delete'])->name('delete_employee');
Route::post('admin/employee/update/{id}', [employeeController::class, 'update'])->name('update_employee');

//Department
Route::get('admin/tables/department', [DepartmentController::class, 'index'])->name('department');
Route::get('admin/form/departmentForm', [DepartmentController::class, 'create'])->name('form_department');
Route::post('admin/form/departmentForm', [DepartmentController::class, 'insert'])->name('insert_department');
Route::get('admin/department/edit/{id}', [DepartmentController::class, 'edit'])->name('edit_department');
Route::get('admin/department/delete/{id}', [DepartmentController::class, 'delete'])->name('delete_department');
Route::post('admin/department/update/{id}', [DepartmentController::class, 'update'])->name('update_department');

//Membership Level
Route::get('admin/tables/membershiplevel', [MembershiplevelController::class, 'index'])->name('membershiplevel');
Route::get('admin/form/membershiplevelForm', [MembershiplevelController::class, 'create'])->name('form_membershiplevel');
Route::post('admin/form/membershiplevelForm', [MembershiplevelController::class, 'insert'])->name('insert_membershiplevel');
Route::get('admin/membershiplevel/edit/{id}', [MembershiplevelController::class, 'edit'])->name('edit_membershiplevel');
Route::get('admin/membershiplevel/delete/{id}', [MembershiplevelController::class, 'delete'])->name('delete_membershiplevel');
Route::post('admin/membershiplevel/update/{id}', [MembershiplevelController::class, 'update'])->name('update_membershiplevel');

//permission
Route::get('admin/tables/permission', [permissionController::class, 'index'])->name('permission');
Route::get('admin/form/permissionForm', [permissionController::class, 'create'])->name('form_permission');
Route::post('admin/form/permissionForm', [permissionController::class, 'insert'])->name('insert_permission');
Route::get('admin/permission/edit/{id}', [permissionController::class, 'edit'])->name('edit_permission');
Route::get('admin/permission/delete/{id}', [permissionController::class, 'delete'])->name('delete_permission');
Route::post('admin/permission/update/{id}', [permissionController::class, 'update'])->name('update_permission');


//promotion
Route::get('admin/tables/promotion', [promotionController::class, 'index'])->name('promotion');
Route::get('admin/form/promotionForm', [promotionController::class, 'create'])->name('form_promotion');
Route::post('admin/form/promotionForm', [promotionController::class, 'insert'])->name('insert_promotion');
Route::get('admin/promotion/edit/{id}', [promotionController::class, 'edit'])->name('edit_promotion');
Route::get('admin/promotion/delete/{id}', [promotionController::class, 'delete'])->name('delete_promotion');
Route::put('admin/promotion/update/{id}', [promotionController::class, 'update'])->name('update_promotion');


//advert
Route::get('admin/tables/advert', [advertController::class, 'index'])->name('advert');
Route::get('admin/form/advertrForm', [advertController::class, 'create'])->name('form_advert');
Route::post('admin/form/advertForm', [advertController::class, 'insert'])->name('insert_advert');
Route::get('admin/advert/edit/{id}', [advertController::class, 'edit'])->name('edit_advert');
Route::get('admin/advert/delete/{id}', [advertController::class, 'delete'])->name('delete_advert');
Route::post('admin/advert/update/{id}', [advertController::class, 'update'])->name('update_advert');

//Order Product
Route::get('admin/tables/order_products', [Order_itemController::class, 'index'])->name('order_products');
Route::get('admin/form/order_productsForm', [Order_itemController::class, 'create'])->name('form_order_products');
Route::post('admin/form/order_productsForm', [Order_itemController::class, 'insert'])->name('insert_order_products');
Route::get('admin/order_products/edit/{id}', [Order_itemController::class, 'edit'])->name('edit_order_products');
Route::get('admin/order_products/delete/{id}', [Order_itemController::class, 'delete'])->name('delete_order_products');
Route::post('admin/order_products/update/{id}', [Order_itemController::class, 'update'])->name('update_order_products');

//Order Product
Route::get('admin/tables/order_shopping', [Order_ProductDetailController::class, 'index'])->name('order_shopping');
Route::get('admin/view/order_view/{id}', [Order_ProductDetailController::class, 'orderview'])->name('order_view');
Route::post('/order/update-status', [Order_ProductDetailController::class, 'updateStatus'])->name('order.updateStatus');
Route::delete('/order/delete/{id}', [Order_ProductDetailController::class, 'delete'])->name('order.delete');
Route::get('admin/form/order_products_detailForm', [Order_ProductDetailController::class, 'create'])->name('form_order_products_detail');
Route::post('admin/form/order_products_detailForm', [Order_ProductDetailController::class, 'insert'])->name('insert_order_products_detail');
Route::get('admin/order_products_detail/edit/{id}', [Order_ProductDetailController::class, 'edit'])->name('edit_order_products_detail');
Route::get('admin/order_products_detail/delete/{id}', [Order_ProductDetailController::class, 'delete'])->name('delete_order_products_detail');
Route::post('admin/order_products_detail/update/{id}', [Order_ProductDetailController::class, 'update'])->name('update_order_products_detail');



//Sale Product
Route::get('admin/tables/sale_products', [Sale_ProductController::class, 'index'])->name('sale_products');
Route::get('admin/form/sale_productsForm', [Sale_ProductController::class, 'create'])->name('form_sale_products');
Route::post('admin/form/sale_productsForm', [Sale_ProductController::class, 'insert'])->name('insert_sale_products');
Route::get('admin/sale_products/edit/{id}', [Sale_ProductController::class, 'edit'])->name('edit_sale_products');
Route::get('admin/sale_products/delete/{id}', [Sale_ProductController::class, 'delete'])->name('delete_sale_products');
Route::post('admin/sale_products/update/{id}', [Sale_ProductController::class, 'update'])->name('update_sale_products');


//reportsales
Route::get('admin/tables/reportsales', [reportsalesController::class, 'index'])->name('reportsales');

//reportstock
Route::get('admin/tables/reportstock', [ReportStockController::class, 'index'])->name('reportstock');

//report unsale
Route::get('admin/tables/reportunsold', [UnsoldProductsReportController::class, 'index'])->name('reportunsold');

//report promotion
Route::get('admin/tables/promotionsreport', [PromotionsReportController::class, 'index'])->name('promotionsreport');

//report Cost
Route::get('admin/tables/costreport', [ReportCostController::class, 'index'])->name('costreport');

//stock
Route::get('admin/tables/stock', [stockController::class, 'index'])->name('stock_items');
Route::get('admin/form/stockForm', [stockController::class, 'create'])->name('stock_form');
Route::post('admin/form/stockForm', [stockController::class, 'store'])->name('stock_add');
Route::get('admin/form/stockEdit/{id}', [stockController::class, 'edit'])->name('stock_edit');
Route::put('admin/stock/update/{id}', [stockController::class, 'update'])->name('stock_update');
Route::delete('admin/stock/delete/{id}', [stockController::class, 'destroy'])->name('stock_delete');


//reports
Route::get('admin/tables/report', [ReportSalesController::class, 'index'])->name('report');


// //Cart
// Route สำหรับเพิ่มสินค้าในตะกร้า
// Route::get('cart', [CartController::class, 'show'])->name('cart.show');
// Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
Route::middleware(['auth'])->group(function () {
    Route::get('frontend/product_detail/{id}', [ProductController::class, 'Detailview'])->name('detail');
    Route::get('/cart', [CartController::class, 'cartview'])->name('cartview');
    Route::get('/checkout', [CartController::class, 'checkoutView'])->name('checkout-view');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/delete/{cartId}',  [CartController::class, 'delete'])->name('cart.delete');
    Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::put('/cart/update/stock/quantity/{id}', [CartController::class, 'updateQuantity'])->name('cart.update_quantity');
    Route::get('/cart/totals', [CartController::class, 'getCartTotals']);
    Route::post('/cart/checkout-add', [CartController::class, 'checkoutAdd'])->name('checkout-add');
    



});



// Route อื่นๆ
Route::get('/', [ProductController::class, 'view']);
Route::get('admin', function () {
    return view('admin/index');
})->name('admin');

Route::fallback(function () {
    return "<h1>ไม่พบหน้า</h1>";
});




//หน้าแสดงสินค้า
Route::get('/', [ProductController::class, 'view']);
Route::get('frontend/product_detail/{id}', [ProductController::class, 'Detailview'])->name('detail');
Route::get('admin', function () {
    return view('admin/index');
})->name('admin');