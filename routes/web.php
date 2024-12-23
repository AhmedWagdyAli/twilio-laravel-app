<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\WhatsAppController;

Route::post('/send-whatsapp', [WhatsAppController::class, 'sendMessage'])->name('send.whatsapp');
Route::get('/send-whatsapp', [WhatsAppController::class, 'sendMessagePage']);
