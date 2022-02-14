<?php

use App\Http\Controllers\ArticleCommentController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleLikeController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('articles', ArticleController::class)
    ->scoped(['article' => 'slug']);

Route::resource('articles.likes', ArticleLikeController::class)->only('index', 'store', 'destroy')
    ->scoped(['article' => 'slug']);

Route::resource('articles.comments', ArticleCommentController::class)->only('store', 'edit', 'update', 'destroy')
    ->scoped(['article' => 'slug']);
