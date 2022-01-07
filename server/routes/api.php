<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\OrdersController;

//PRODUCTS
Route::post('/add-product', [ProductsController::class, 'store']);
Route::get('/view-products', [ProductsController::class, 'view']);
Route::delete('/delete-product/{id}', [ProductsController::class, 'destroy']);
Route::put('/edit-product/{id}', [ProductsController::class, 'edit']);
Route::put('/toggle-product-status/{id}', [ProductsController::class, 'toggleStatus']);

//USERS
Route::post('/user-create', [UsersController::class, 'store']);
Route::post('/login', [UsersController::class, 'login']);

//ORDERS
Route::post('/archive-orders', [OrdersController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
