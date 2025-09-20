<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return redirect()->route('surats.index');
});

Route::get('/about', function () {
    return view('about', [
        'name' => env('ABOUT_NAME', 'Nama Anda'),
        'nim' => env('ABOUT_NIM', '123456789'),
        'photo' => asset(env('ABOUT_PHOTO', 'images/profile.jpg')),
        'date' => \Carbon\Carbon::parse(env('ABOUT_DATE', now()->toDateString()))->translatedFormat('d F Y'),
        'prodi' => env('ABOUT_PRODI', 'D3-MANAJEMEN INFORMATIKA'),
    ]);
})->name('about');

Route::resource('surats', SuratController::class);
Route::get('surats/{surat}/download', [SuratController::class, 'download'])->name('surats.download');

Route::resource('categories', CategoryController::class)->except(['show']);
