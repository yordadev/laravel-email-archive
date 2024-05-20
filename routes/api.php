<?php

use App\Http\Controllers\HandleEmailGetAllAction;
use App\Http\Controllers\HandleEmailUploadAction;
use App\Http\Controllers\HandleFindEmailByIdAction;
use Illuminate\Support\Facades\Route;

Route::prefix('email')->group(function () {
    Route::post('upload', HandleEmailUploadAction::class)->name('post.email.upload');
    Route::get('all', HandleEmailGetAllAction::class)->name('get.email.all');
    Route::get('find', HandleFindEmailByIdAction::class)->name('get.email.find');
});
