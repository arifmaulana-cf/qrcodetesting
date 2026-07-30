<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrCodeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $totalQrCodes = \App\Models\QrCode::where('user_id', auth()->id())->count();
    $totalScans = \App\Models\QrCode::where('user_id', auth()->id())->sum('scan_count');
    $recentQrCodes = \App\Models\QrCode::where('user_id', auth()->id())
        ->where('created_at', '>=', now()->subWeek())
        ->count();

    return view('dashboard', compact('totalQrCodes', 'totalScans', 'recentQrCodes'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('qrcode', QrCodeController::class);
    Route::get('/qrcode/{qrCode}/download', [QrCodeController::class, 'download'])->name('qrcode.download');
});

require __DIR__.'/auth.php';
