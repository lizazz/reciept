<?php

use Illuminate\Support\Facades\Route;
use App\Components\CommonConstants;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// ----------- AUTH -----------

Route::get('/login', 'Admin\AdminLoginController@login')->name('adminLogin');
Route::post('/login', 'Admin\AdminLoginController@loginSubmit')->name('adminloginsubmit');
Route::get('/', 'Admin\AdminLoginController@login')->name('adminLogin');
Route::get('/info', 'Admin\AdminLoginController@notLoginInfoPage')->name('notlogininfopage');
Route::get('/receipts', 'ReceiptController@index')->name('receipts.index');
Route::get('/info', 'Admin\AdminLoginController@notLoginInfoPage')->name('notlogininfopage');
Route::get('receipts/data', 'ReceiptController@getData')->name('receipts.data');

Route::group(['middleware'=>['adminaccess']], function () {
    Route::resource('/receipts', 'ReceiptController')
        ->names('receipts')
        ->except('index');
    Route::get('ingredients/data', 'IngredientController@getData')->name('ingredients.data');
    Route::resource('/ingredients', 'IngredientController')->names('ingredients');
    Route::post('/logout', 'Admin\AdminLoginController@logout')->name('adminLogout');

       // ----------- USERS -----------

    Route::get('users/data', 'UserController@getData')->name('users.data');
    Route::post('/users/deleteavatar', 'UserController@deleteAvatar')->name('remove.avatar');

    Route::resource('users', 'UserController')
        ->names('user')
        ->except(['show'])
        ->middleware('adminlte:users');
});
