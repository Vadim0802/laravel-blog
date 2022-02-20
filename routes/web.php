<?php

use App\Http\Controllers\ArticleCommentController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleLikeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('users', UserController::class)->only('show', 'edit', 'update');

Route::resource('articles', ArticleController::class)
    ->scoped(['article' => 'slug'])
    ->middleware('slugify');

Route::resource('articles.likes', ArticleLikeController::class)->only('index', 'store', 'destroy')
    ->scoped(['article' => 'slug']);

Route::resource('articles.comments', ArticleCommentController::class)->only('store', 'edit', 'update', 'destroy')
    ->scoped(['article' => 'slug']);
