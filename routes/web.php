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

    
    //MyPage
    Route::get('/mypage/exhibit', [MypageController::class, 'exhibit'])->name('exhibit');
    Route::get('/mypage/external_setting', [MypageController::class, 'external_setting'])->name('external_setting');
    Route::get('/mypage/price_setting', [MypageController::class, 'price_setting'])->name('price_setting');
    Route::get('/mypage/benefit_setting', [MypageController::class, 'benefit_setting'])->name('benefit_setting');
    Route::get('/mypage/exclusion_setting', [MypageController::class, 'exclusion_setting'])->name('exclusion_setting');
    Route::get('/mypage/account_setting', [MypageController::class, 'account_setting'])->name('account_setting');
    Route::post('/mypage/shop_register', [Mypagecontroller::class, 'shop_register'])->name('shop_register');
    //save
    Route::post('/mypage/common_save', [MypageController::class, 'commonSave'])->name('common_save');
    Route::post('/mypage/item/edit/common_save', [MypageController::class, 'commonSave'])->name('common_save');
    Route::post('/mypage/price_save', [MypageController::class, 'priceSave'])->name('price_save');
    Route::post('/mypage/item_save', [MypageController::class, 'itemSave'])->name('item_save');
    Route::post('/mypage/price/pattern/save', [MypageController::class, 'savePattern'])->name('save_pattern');
    Route::post('/mypage/price/time_pattern/save', [MypageController::class, 'saveTimePattern']);
    Route::post('/mypage/price/pattern/set', [MypageController::class, 'setPattern']);

    Route::get('/mypage/item_add', [MypageController::class, 'itemAdd'])->name('item_add');
    Route::get('/mypage/item_list', [MypageController::class, 'itemConfirm'])->name('item_list');
    Route::get('/mypage/shop_list', [MypageController::class, 'shopList'])->name('shop_list');

    Route::get('/mypage/send_msg', [MypageController::class, 'sendMsg'])->name('send_msg');
    // Route::post('/mypage/shop_list', [MypageController::class, 'shopList'])->name('shop_list');
    Route::post('/mypage/csv_data_load', [MypageController::class, 'csvDataLoad'])->name('csv_data_load');
    //UserInfo
    Route::post('/mypage/external_save/{path}', [MypageController::class, 'external_save'])->name('external_save');
    Route::post('/mypage/ecinfo_save', [MypageController::class, 'ecinfo_save'])->name('ecinfo_save');
    Route::get('/mypage/yahoo_token', [MypageController::class, 'yahoo_token'])->name('yahoo_token');
    Route::post('/mypage/yahoo_access', [MypageController::class, 'yahoo_access'])->name('yahoo_access');
    Route::get('/mypage/yahoo_access', [MypageController::class, 'yahoo_access'])->name('yahoo_access');

    Route::post('/mypage/save/profit', [MypageController::class, 'profit_save']);
    Route::post('/mypage/del/profit', [MypageController::class, 'profit_del']);

    Route::post('/mypage/save/delivery', [MypageController::class, 'delivery_save']);
    Route::post('/mypage/del/delivery', [MypageController::class, 'delivery_del']);

    Route::post('/mypage/getasincode', [MypageController::class, 'getAsinCode']);
    Route::get('/mypage/item/edit/{id}', [MypageController::class, 'itemEdit']);

    Route::get('/mypage/pattern_setting', [MypageController::class, 'getPattern']);
    Route::post('/mypage/price_pattern/custom_save', [MypageController::class, 'custom_price_save']);
    Route::post('/mypage/time_pattern/custom_save', [MypageController::class, 'custom_time_save']);
});

Route::middleware(['cors'])->group(function () {
    Route::get('http://localhost:32768/');
});