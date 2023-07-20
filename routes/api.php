<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FreshbbController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('uploadprod', [FreshbbController::class, 'uploadprod'])->name('uploadprod');
Route::post('faq', [FreshbbController::class, 'faq'])->name('faq');
Route::post('review', [FreshbbController::class, 'review'])->name('review');
Route::post('payment', [FreshbbController::class, 'payment'])->name('payment');

Route::get('viewprod', [FreshbbController::class, 'viewprod'])->name('viewprod');
Route::get('viewreview/{id}', [FreshbbController::class, 'viewreview'])->name('viewreview');
Route::get('viewfaq', [FreshbbController::class, 'viewfaq'])->name('viewfaq');

Route::get('/payment', [PaymentController::class, 'payment'])->name('payment');
Route::post('/createPayment', [PaymentController::class, 'createPayment'])->name('createPayment');
