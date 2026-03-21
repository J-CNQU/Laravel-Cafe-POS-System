<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('pos.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('pos.index');
})->name('dashboard');

Route::prefix('pos')->group(function () {
    Route::get('/', [PosController::class, 'index'])->name('pos.index');
    Route::post('/store', [PosController::class, 'store'])->name('pos.store');
});

Route::get('/history', [PosController::class, 'history'])->name('history');
Route::delete('/history/clear/all', [PosController::class, 'clearAll'])->name('history.clearAll');
Route::delete('/history/{id}', [PosController::class, 'destroy'])->name('history.destroy');

Route::get('/analytics', [PosController::class, 'analytics'])->name('analytics');

Route::get('/settings', function () {
    return view('settings');
})->name('settings');

Route::resource('products', ProductController::class);

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');