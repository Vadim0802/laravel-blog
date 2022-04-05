<?php

use App\Http\Controllers\AdminManageTagsController;
use App\Http\Controllers\ArticleCommentController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleLikeController;
use App\Http\Controllers\AdminManageArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Models\User;
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

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::prefix('manage')->group(function () {
        Route::get('articles', [AdminManageArticleController::class, 'index'])->name('admin_manage_articles_index');
        Route::delete('articles/{article}', [AdminManageArticleController::class, 'destroy'])->name('admin_manage_articles_destroy');

        Route::get('tags', [AdminManageTagsController::class, 'index'])->name('admin_manage_tags_index');
        Route::post('tags', [AdminManageTagsController::class, 'store'])->name('admin_manage_tags_store');
        Route::delete('tags/{tag}', [AdminManageTagsController::class, 'destroy'])->name('admin_manage_tags_destroy');
    });
});
