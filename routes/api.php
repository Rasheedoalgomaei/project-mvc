<?php

use SallaProducts\Http\Route;
use App\Controllers\Api\CategoriesController;
use App\Controllers\Api\ProductApiController;
use App\Controllers\HomeController;
use App\Controllers\Webhook\ProductController;

   Route::get('/',[HomeController::class,'index']);
   
Route::get('/register/:name', function($param) {
    echo 'Welcome ' . $param['name'];
});

Route::post('/product/product-created',[ProductController::class,'createProduct']);
Route::post('/product/product-updated',[ProductController::class,'updateProduct']);
Route::post('/product/product-deleted',[ProductController::class,'deleteProduct']);
Route::post('/product/product-available',[ProductController::class,'productAvailable']);
Route::post('/product/product-quantity-low',[ProductController::class,' productLowQuantity']);
Route::post('/check-product',[ProductController::class,'productCheck']);

Route::post('/api/categories',[CategoriesController::class,'index']);


Route::post('/api/products',[ProductApiController::class,'index']);



// $router->get('/', function() {
//     echo 'Welcome ';
// });



?>