<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubServiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryServiceController;
use App\Http\Controllers\DigitalMarketingController;
use App\Http\Controllers\SoftwareDevelopmentController;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });



Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });


    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Manajemen Users
    Route::resource('users', UsersController::class)->except('craate', 'edit');

    // Manajemen Users
    Route::resource('sub_service', SubServiceController::class)->except('craate', 'edit');
    // CategoryService
    Route::resource('category_service', CategoryServiceController::class)->except('craate', 'edit');
    // CategoryService
    Route::resource('service', ServiceController::class)->except('craate', 'edit');

    // CategoryService
    Route::resource('cart', CartController::class);
    Route::resource('cartItem', CartItemController::class);

    // Template
    Route::resource('software_development', SoftwareDevelopmentController::class);
    Route::resource('digital_marketing', DigitalMarketingController::class);

    //Transaction
    Route::resource('transactions', TransactionController::class);
    Route::get('/transactions/{transaction}/pdf', [TransactionController::class, 'generatePDF'])->name('transactions.generatePDF');
    Route::get('cetak_laporan', [TransactionController::class, 'generateLaporan']);
});

require __DIR__.'/auth.php';
