<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/agendar-demonstracao', 'agendar-demonstracao')->name('agendar-demonstracao');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/chat', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat');
    Route::post('/chat/send', [\App\Http\Controllers\ChatController::class, 'store'])->name('chat.send');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('lang/{locale}', function ($locale) {
    $supportedLocales = [
        'en', 'pt', 'fr', 'zh', 'hi', 'es', 'ar', 'bn', 'ru', 'ur', 'id', 'de', 
        'ja', 'pcm', 'mr', 'te', 'tr', 'ta', 'yue', 'vi', 'tl', 'wuu', 'ko'
    ];
    if (in_array($locale, $supportedLocales)) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('locale.switch');

require __DIR__.'/auth.php';
