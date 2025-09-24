<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CarakerjaPostController;
use App\Models\Blog;
use App\Models\CarakerjaPost;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/carakerja_posts', function () {
    return view('views.index');
});

Route::get('/blog', function () {
    return view('blogs.index');
});

Route::get('/blog/create', function () {
    return view('blogs.create');
});

Route::get('/blogs', [BlogController::class, 'index'])->name ('blogs.index');
Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create');
Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store');


Route::get('/blogs/{id}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
Route::put('/blogs/{id}', [BlogController::class, 'update'])->name('blogs.update');
Route::delete('/blogs/{id}', [BlogController::class, 'destroy'])->name('blogs.destroy');

Route::get('/', [CarakerjaPostController::class, 'index'])->name ('index');


Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::get('/booking/success/{booking_code}', [BookingController::class, 'success'])->name('booking.success');
Route::get('/booking/check/{booking_code}', [BookingController::class, 'check'])->name('booking.check');


// Tambahkan routes ini
Route::get('/payment/{booking_code}', [PaymentController::class, 'pay'])->name('payment.pay');
Route::get('/payment/finish/{booking_code}', [PaymentController::class, 'finish'])->name('payment.finish');
Route::post('/payment/webhook', [PaymentController::class, 'webhook'])->name('payment.webhook');
Route::get('/payment/status/{booking_code}', [PaymentController::class, 'checkStatus'])->name('payment.status');