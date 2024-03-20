<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

Route::get('/translations/{locale}', function ($locale) {
    $path = resource_path("lang/{$locale}.json");
    return response()->file($path);
});

Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware(['auth']);


Auth::routes();

Route::prefix('home')->middleware(['auth'])->group(function(){
    // Dashboard
    Route::get('', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Settings
    Route::prefix('settings')->name('settings.')->group(function(){
        Route::get('', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\Admin\SettingController::class, 'store'])->name('store');
    });

    // Users
    Route::prefix('users')->name('users.')->group(function(){
        Route::get('', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
        Route::get('data', [App\Http\Controllers\Admin\UserController::class, 'data'])->name('data');
        Route::post('delete={id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
        Route::get('edit={id}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('edit');
        Route::post('edit={id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
        Route::post('edit={id}/personal-info', [App\Http\Controllers\Admin\UserController::class, 'updatePersonalInfo'])->name('update_personal_info');
        Route::post('edit={id}/change-password', [App\Http\Controllers\Admin\UserController::class, 'updatePassword'])->name('update_password');
        Route::get('profile={id}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('show');

        Route::post('import', [App\Http\Controllers\Admin\UserController::class, 'import'])->name('import');
        Route::get('export', [App\Http\Controllers\Admin\UserController::class, 'export'])->name('export');
    });

    // Warehouses
    Route::prefix('warehouses')->name('warehouses.')->group(function(){
        Route::get('', [App\Http\Controllers\Admin\WarehouseController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\Admin\WarehouseController::class, 'store'])->name('store');
        Route::get('data', [App\Http\Controllers\Admin\WarehouseController::class, 'data'])->name('data');
        Route::post('delete={id}', [App\Http\Controllers\Admin\WarehouseController::class, 'destroy'])->name('destroy');
        Route::get('edit={id}', [App\Http\Controllers\Admin\WarehouseController::class, 'edit'])->name('edit');
        Route::post('edit={id}', [App\Http\Controllers\Admin\WarehouseController::class, 'update'])->name('update');
        Route::post('edit={id}/info', [App\Http\Controllers\Admin\WarehouseController::class, 'updateInfo'])->name('update_info');
        Route::get('profile={id}', [App\Http\Controllers\Admin\WarehouseController::class, 'show'])->name('show');
        Route::get('profile={id}/products', [App\Http\Controllers\Admin\WarehouseController::class, 'getProducts'])->name('get_products');
        Route::post('profile={id}/add-products', [App\Http\Controllers\Admin\WarehouseController::class, 'addProductsToWarehouse'])->name('add_products_to_warehouse');
        Route::get('profile={id}/products={product_id}/product-quantity', [App\Http\Controllers\Admin\WarehouseController::class, 'getQuantityProduct']);
        Route::post('profile={id}/products={product_id}/increase-quantity', [App\Http\Controllers\Admin\WarehouseController::class, 'increaseQuantity'])->name('increase_quantity');
        Route::get('profile={id}/get-validations', [App\Http\Controllers\Admin\WarehouseController::class, 'getValidationStock'])->name('get_validation_stock');
        Route::post('profile={id}/process-validation', [App\Http\Controllers\Admin\WarehouseController::class, 'processValidation'])->name('process_validation');
        Route::post('import', [App\Http\Controllers\Admin\WarehouseController::class, 'import'])->name('import');
        Route::get('export', [App\Http\Controllers\Admin\WarehouseController::class, 'export'])->name('export');
    });

    // Categories
    Route::prefix('categories')->name('categories.')->group(function(){
        Route::get('', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('store');
        Route::get('data', [App\Http\Controllers\Admin\CategoryController::class, 'data'])->name('data');
        Route::post('delete={id}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('destroy');
        Route::get('edit={id}', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('edit');
        Route::post('edit={id}', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('update');
        Route::get('profile={id}', [App\Http\Controllers\Admin\CategoryController::class, 'show'])->name('show');
    });

    // Brands
    Route::prefix('brands')->name('brands.')->group(function(){
        Route::get('', [App\Http\Controllers\Admin\BrandController::class, 'index'])->name('index');
        Route::post('', [App\Http\Controllers\Admin\BrandController::class, 'store'])->name('store');
        Route::get('data', [App\Http\Controllers\Admin\BrandController::class, 'data'])->name('data');
        Route::post('delete={id}', [App\Http\Controllers\Admin\BrandController::class, 'destroy'])->name('destroy');
        Route::get('edit={id}', [App\Http\Controllers\Admin\BrandController::class, 'edit'])->name('edit');
        Route::post('edit={id}', [App\Http\Controllers\Admin\BrandController::class, 'update'])->name('update');
        Route::get('profile={id}', [App\Http\Controllers\Admin\BrandController::class, 'show'])->name('show');
    });

    // Suppliers
    Route::prefix('suppliers')->name('suppliers.')->group(function(){
        Route::get('', [App\Http\Controllers\Admin\SupplierController::class, 'index'])->name('index');
        Route::get('data', [App\Http\Controllers\Admin\SupplierController::class, 'data'])->name('data');
        Route::get('edit={id}', [App\Http\Controllers\Admin\SupplierController::class, 'edit'])->name('edit');
        Route::post('', [App\Http\Controllers\Admin\SupplierController::class, 'store'])->name('store');
        Route::post('delete={id}', [App\Http\Controllers\Admin\SupplierController::class, 'destroy'])->name('destroy');
        Route::post('edit={id}', [App\Http\Controllers\Admin\SupplierController::class, 'update'])->name('update');
    });

    // Clients
    Route::prefix('clients')->name('clients.')->group(function(){
        Route::get('', [App\Http\Controllers\Admin\ClientController::class, 'index'])->name('index');
        Route::get('data', [App\Http\Controllers\Admin\ClientController::class, 'data'])->name('data');
        Route::get('edit={id}', [App\Http\Controllers\Admin\ClientController::class, 'edit'])->name('edit');
        Route::post('', [App\Http\Controllers\Admin\ClientController::class, 'store'])->name('store');
        Route::post('delete={id}', [App\Http\Controllers\Admin\ClientController::class, 'destroy'])->name('destroy');
        Route::post('edit={id}', [App\Http\Controllers\Admin\ClientController::class, 'update'])->name('update');
    });

    // Products
    Route::prefix('products')->name('products.')->group(function(){
        Route::get('', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('index');
        Route::get('data', [App\Http\Controllers\Admin\ProductController::class, 'data'])->name('data');
        Route::post('create', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('store');
        Route::get('edit={id}', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('edit');
        Route::post('edit={id}', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('update');

        Route::post('{id}/increase-quantity', [App\Http\Controllers\Admin\ProductController::class, 'increaseQuantity'])->name('increase_quantity');
        Route::post('product-increase-prices', [App\Http\Controllers\Admin\ProductController::class, 'increaseProductPrice'])->name('increase_product_price');

        Route::post('import', [App\Http\Controllers\Admin\ProductController::class, 'import'])->name('import');
        Route::get('export', [App\Http\Controllers\Admin\ProductController::class, 'export'])->name('export');
        Route::post('delete={id}', [App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('destroy');
        Route::get('/get-products', [App\Http\Controllers\Admin\ProductController::class, 'searchProducts'])->name('search_products');
    });

});
