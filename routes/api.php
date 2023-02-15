<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\SizeController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProductSizeController;
use App\Http\Controllers\API\FrontendController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('getCategory', [FrontendController::class, 'category']);
Route::get('fetchproducts/{name}', [FrontendController::class, 'product']);
Route::get('idproduct/{id}', [FrontendController::class, 'idproduct']);
Route::get('categogyproduct/{id}', [FrontendController::class, 'categogyproduct']);
Route::get('viewproductdetail/{category_slug}/{product_slug}', [FrontendController::class, 'viewproduct']);

Route::post('add-to-cart', [CartController::class, 'addtocart']);
Route::get('cart', [CartController::class, 'viewcart']);
Route::put('cart-updatequantity/{cart_id}/{scope}', [CartController::class, 'updatequantity']);
Route::delete('delete-cartitem/{cart_id}', [CartController::class, 'deleteCartitem']);

Route::get('user', [UserController::class, 'viewuser']);

Route::post('validate-order', [CheckoutController::class, 'validateOrder']);
Route::post('place-order', [CheckoutController::class, 'placeorder']);

Route::get('view-order/{id}', [OrderController::class, 'vieworder']);
Route::get('order', [OrderController::class, 'order']);
Route::delete('deleteorder/{id}', [OrderController::class, 'deleteorder']);
Route::post('update/{id}', [OrderController::class, 'received']);
Route::put('updatestatus/{order_id}/{status}', [OrderController::class, 'updatestatus']);

Route::get('allsize', [FrontendController::class, 'allsize']);
Route::get('searchByName/{name}', [FrontendController::class, 'searchByName']);
Route::get('paging-product', [ProductController::class, 'paging']);
Route::get('hasMany-product', [ProductController::class, 'hasMany']);

Route::middleware(['auth:sanctum', 'isAPIAdmin'])->group(function () {

    Route::get('/checkingAuthenticated', function () {
        return response()->json(['message' => 'You are in', 'status' => 200], 200);
    });

    // Category
    Route::get('view-category', [CategoryController::class, 'index']);
    Route::post('store-category', [CategoryController::class, 'store']);
    Route::get('edit-category/{id}', [CategoryController::class, 'edit']);
    Route::post('update-category/{id}', [CategoryController::class, 'update']);
    Route::delete('delete-category/{id}', [CategoryController::class, 'destroy']);
    Route::get('all-category', [CategoryController::class, 'allcategory']);
    Route::get('search-category/{id}', [CategoryController::class, 'search']);

    // Products

    Route::post('store-product', [ProductController::class, 'store']);
    Route::get('view-product', [ProductController::class, 'index']);
    Route::get('show-product/{id}', [ProductController::class, 'show']);
    Route::get('edit-product/{id}', [ProductController::class, 'edit']);
    Route::post('update-product/{id}', [ProductController::class, 'update']);
    Route::delete('delete-product/{id}', [ProductController::class, 'destroy']);

    // ProductSize
    Route::post('store-productsize', [ProductSizeController::class, 'store']);
    Route::post('stores-productsize/{product_id}/{size_id}', [ProductSizeController::class, 'stores']);
    Route::get('view-productsize', [ProductSizeController::class, 'index']);
    Route::get('show-productsize/{id}', [ProductSizeController::class, 'show']);
    Route::get('edit-productsize/{id}', [ProductSizeController::class, 'edit']);
    Route::post('update-productsize/{id}', [ProductSizeController::class, 'update']);
    Route::delete('delete-productsize/{id}', [ProductSizeController::class, 'destroy']);


    // Size
    Route::get('view-size', [SizeController::class, 'index']);
    Route::post('store-size', [SizeController::class, 'store']);
    Route::get('edit-size/{id}', [SizeController::class, 'edit']);
    Route::post('update-size/{id}', [SizeController::class, 'update']);
    Route::delete('delete-size/{id}', [SizeController::class, 'destroy']);
    Route::get('all-size', [SizeController::class, 'allsize']);

    // Orders
    Route::get('admin/orders', [OrderController::class, 'index']);
    Route::get('admin/orderdetail/{id}', [OrderController::class, 'orderdetail']);
    Route::post('admin/update/{id}', [OrderController::class, 'update']);
    Route::delete('delete-orders/{id}', [OrderController::class, 'destroy']);


    //User
    Route::get('user/index', [UserController::class, 'index']);
    Route::get('edit-user/{id}', [UserController::class, 'edit']);
    Route::post('update-user/{id}', [UserController::class, 'update']);
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
