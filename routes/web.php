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
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('users', UserController::class)->only('show', 'edit', 'update');
Route::resource('articles', ArticleController::class)->middleware('slugify');
Route::resource('articles.likes', ArticleLikeController::class)->only('index', 'store', 'destroy');
Route::resource('articles.comments', ArticleCommentController::class)->only('store', 'edit', 'update', 'destroy');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::prefix('manage')->group(function () {
        Route::controller(AdminManageArticleController::class)->group(function () {
            Route::get('articles', 'index')->name('admin_manage_articles_index');
            Route::delete('articles/{article}', 'destroy')->name('admin_manage_articles_destroy');
        });

        Route::controller(AdminManageTagsController::class)->group(function () {
            Route::get('tags', 'index')->name('admin_manage_tags_index');
            Route::post('tags', 'store')->name('admin_manage_tags_store');
            Route::delete('tags/{tag}', 'destroy')->name('admin_manage_tags_destroy');
        });
    });
});
