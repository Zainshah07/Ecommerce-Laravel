<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\admin\BrandController;
use App\Http\Controllers\front\OrderController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\TempImgController;
use App\Http\Controllers\front\AccountController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\front\ProductController as FrontProductController;
use App\Http\Controllers\admin\OrderController as AdminOrderController;

Route::post('/admin/login',[AuthController::class,'authenticate']);
Route::post('/login',[AccountController::class,'authenticate']);
Route::get('/get-latest-products',[FrontProductController::class,'latestProducts']);
Route::get('/get-featured-products',[FrontProductController::class,'featuredProducts']);
Route::get('/get-categories',[FrontProductController::class,'getCategories']);
Route::get('/get-brands',[FrontProductController::class,'getBrands']);
Route::get('/get-products',[FrontProductController::class,'getProducts']);
Route::get('/get-product/{id}',[FrontProductController::class,'getProduct']);
Route::post('/register',[AccountController::class,'register']);
Route::get('/get-shipping',[ShippingController::class,'getShippingCharges']);


Route::group(['middleware'=>['auth:sanctum', 'checkUserRole']],function(){
Route::post('/save-order',[OrderController::class,'saveOrder']);
Route::get('/get-order-detail/{id}',[AccountController::class,'getOrderDetail']);
Route::get('/get-orders',[AccountController::class,'getOrders']);
Route::post('/update-profile',[AccountController::class,'updateProfile']);
Route::get('/get-user-details',[AccountController::class,'getUserDetails']); 
Route::post('/create-payment-intent',[OrderController::class,'createPayemntIntent']);   
});


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['middleware'=>['auth:sanctum', 'checkAdminRole']],function(){
    Route::get('/categories',[CategoryController::class,'index']);
    Route::get('/categories/{id}',[CategoryController::class,'show']);
    Route::put('/categories/{id}',[CategoryController::class,'update']);
    Route::post('/categories',[CategoryController::class,'store']);
    Route::delete('/categories/{id}',[CategoryController::class,'destroy']);
    Route::get('/orders',[AdminOrderController::class,'index']);
    Route::get('/orders/{id}',[AdminOrderController::class,'detail']);
    Route::put('/orders/{id}',[AdminOrderController::class,'update']);
    Route::get('/shipping-charges',[ShippingController::class,'getShippingCharges']);
    Route::post('/shipping-charges',[ShippingController::class,'updateShippingCharges']);

});
Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::get('/brands',[BrandController::class,'index']);
    Route::get('/brands/{id}',[BrandController::class,'show']);
    Route::put('/brands/{id}',[BrandController::class,'update']);
    Route::post('/brands',[BrandController::class,'store']);
    Route::delete('/brands/{id}',[BrandController::class,'destroy']);
});
Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::get('/sizes',[SizeController::class,'index']);
    // Route::get('/brands/{id}',[BrandController::class,'show']);
    // Route::put('/brands/{id}',[BrandController::class,'update']);
    // Route::post('/brands',[BrandController::class,'store']);
    // Route::delete('/brands/{id}',[BrandController::class,'destroy']);
});
Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::post('/tempImage',[TempImgController::class,'store']);
    // Route::get('/brands/{id}',[BrandController::class,'show']);
    // Route::put('/brands/{id}',[BrandController::class,'update']);
     Route::get('/tempImage',[TempImgController::class,'index']);
    // Route::delete('/brands/{id}',[BrandController::class,'destroy']);
});
Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::get('/products',[ProductController::class,'index']);
    Route::get('/products/{id}',[ProductController::class,'show']);
    Route::put('/products/{id}',[ProductController::class,'update']);
    Route::post('/save-product-image',[ProductController::class,'storeImage']);
    Route::get('/change-product-image',[ProductController::class,'updateDefaultImage']);
    Route::delete('/delete-product-image/{product_id}',[ProductController::class,'deleteImage']);
    Route::post('/products',[ProductController::class,'store']);
    Route::delete('/products/{id}',[ProductController::class,'destroy']);
});

Route::post('/temp-images', [TempImgController::class, 'store']);
