<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\WordController;

Route::get('/words', [WordController::class, 'index']);
Route::get('/words/{word_id}', [WordController::class, 'show']);
