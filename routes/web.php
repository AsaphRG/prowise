<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/agendar-demonstracao', 'agendar-demonstracao')->name('agendar-demonstracao');
Route::view('/sobre', 'sobre')->name('sobre');

Route::get('/dashboard', function () {
    return redirect()->route('chat');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/chat/{conversation?}', [\App\Http\Controllers\ChatController::class, 'index'])->name('chat');
    Route::post('/chat/new', [\App\Http\Controllers\ChatController::class, 'create'])->name('chat.new');
    Route::put('/chat/{conversation}/rename', [\App\Http\Controllers\ChatController::class, 'rename'])->name('chat.rename');
    Route::delete('/chat/{conversation}', [\App\Http\Controllers\ChatController::class, 'destroy'])->name('chat.destroy');
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
