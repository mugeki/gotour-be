<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PlaceController;
use App\Http\Controllers\API\WishlistController;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/place', [PlaceController::class, 'get']);
Route::get('/place/{id}', [PlaceController::class, 'get_by_id']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/place', [PlaceController::class, 'post']);
    Route::put('/place/{id}', [PlaceController::class, 'update']);
    Route::put('/place/{id}/rate', [PlaceController::class, 'rate']);
    Route::delete('/place/{id}', [PlaceController::class, 'delete']);
    Route::get('/my-places', [PlaceController::class, 'get_by_user']);

    Route::get('/wishlist', [WishlistController::class, 'get']);
    Route::post('/wishlist/{place_id}', [WishlistController::class, 'post']);
    Route::delete('/wishlist/{place_id}', [WishlistController::class, 'delete']);
});