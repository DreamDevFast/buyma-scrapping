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
    Route::get('gucci', [MypageController::class, 'gucci'])->name('gucci');
    Route::get('chanel', [MypageController::class, 'chanel'])->name('chanel');
    Route::get('balenciaga', [MypageController::class, 'balenciaga'])->name('balenciaga');
    Route::get('givenchy', [MypageController::class, 'givenchy'])->name('givenchy');


    Route::get('findandsell', [MypageController::class, 'findandsell'])->name('findandsell');

    Route::get('changepass', [MypageController::class, 'changepass'])->name('changepass');
    Route::post('confirm_password', [MypageController::class, 'confirm_password'])->name('confirm_password');
    Route::post('change_password', [MypageController::class, 'change_password'])->name('change_password');
    Route::get('changeinfo', [MypageController::class, 'changeinfo'])->name('changeinfo');
    Route::post('change_userinfo', [MypageController::class, 'change_userinfo'])->name('change_userinfo');
    Route::get('changebuymainfo', [MypageController::class, 'changebuymainfo'])->name('changebuymainfo');
    Route::post('changebuymainfo', [MypageController::class, 'change_buyma_info'])->name('change_buyma_info');


    Route::get('exhibitsettings', [MypageController::class, 'exhibitsettings'])->name('exhibitsettings');
    Route::post('exhibitsettings', [MypageController::class, 'changeExhibitSettings'])->name('changeExhibitSettings');

    Route::get('changepass_check', [MypageController::class, 'changepass_check'])->name('changepass_check');

    Route::get('csv_down', [MypageController::class, 'csv_down'])->name('csv_down');
    Route::get('count', [MypageController::class, 'count'])->name('count');
    //MyPage    

    // Manage accounts information
    Route::get('admin_page', [MypageController::class, 'admin_page'])->name('admin_page');
    Route::get('delete_account', [MypageController::class, 'delete_account'])->name('delete_account');
    Route::get('permit_account', [MypageController::class, 'permit_account'])->name('permit_account');
});

Route::middleware(['cors'])->group(function () {
    Route::get('http://localhost:32768/');
});