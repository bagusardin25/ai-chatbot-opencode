<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ConversationController;

Route::get('/', function () {
    return redirect()->route('chat');
});

Route::get('/chat', function () {
    return view('chat');
})->name('chat');

Route::prefix('api')->group(function () {
    Route::prefix('conversations')->group(function () {
        Route::get('/', [ConversationController::class, 'index']);
        Route::get('/{id}', [ConversationController::class, 'show']);
        Route::post('/', [ConversationController::class, 'store']);
        Route::put('/{id}', [ConversationController::class, 'update']);
        Route::delete('/{id}', [ConversationController::class, 'destroy']);
        Route::post('/{id}/rename', [ConversationController::class, 'rename']);
    });

    Route::prefix('chat')->group(function () {
        Route::post('/send/{conversationId?}', [ChatController::class, 'sendMessage']);
        Route::post('/stream/{conversationId?}', [ChatController::class, 'streamMessage']);
    });
});
