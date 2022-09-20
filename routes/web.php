<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\BaseController;

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MypageController;

// Homepage Route
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Authentication Routes

Route::get('/signup/{role?}', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/loginview', [LoginController::class, 'loginview']);
Route::get('/get_city', [BaseController::class, 'get_city_by_prefecture'])->name('get_city');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Routes
Route::group(['prefix' => 'dashboard','middleware' => ['auth']], function() {
    Route::get('/',[DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    // Review template routes
    Route::resource('review_templates', ReviewTemplateController::class);
    Route::delete('review_templates/destroy', [ReviewTemplateController::class, 'destroy'])->name('delete_template');
    Route::get('/producer/{producer_id}/detail', [ProducerController::class, 'detail_view'])->name('producer_detail_view');

});
Route::group(['middleware' => ['auth']], function() {
    //All routes for MyPage
    Route::get('mypage', [MypageController::class, 'index'])->name('mypage');
    Route::get('goatpage', [MypageController::class, 'goatpage'])->name('goatpage');
    Route::get('louipage', [MypageController::class, 'louipage'])->name('louipage');
    Route::get('burberry', [MypageController::class, 'burberry'])->name('burberry');
    Route::get('dior', [MypageController::class, 'dior'])->name('dior');


    Route::get('changepass', [MypageController::class, 'changepass'])->name('changepass');
    Route::get('exhibitsettings', [MypageController::class, 'exhibitsettings'])->name('exhibitsettings');
    Route::get('changepass_check', [MypageController::class, 'changepass_check'])->name('changepass_check');

    Route::get('csv_down', [MypageController::class, 'csv_down'])->name('csv_down');
    Route::get('count', [MypageController::class, 'count'])->name('count');
    //MyPage    
});

Route::middleware(['cors'])->group(function () {
    Route::get('http://localhost:32768/');
});