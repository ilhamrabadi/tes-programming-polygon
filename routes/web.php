<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return route('/transactions');
});

Route::get('/verify', function () {
    return view('anak.index');
});

Route::resource("transactions", "TransactionController");
Route::post("transactiondelete", "TransactionController@delete")->name('transactions.delete');
Route::get("history/{year?}", "TransactionController@history")->name('transactions.history');
Route::get("verify", "TransactionController@verify")->name("transactions.verify");
Route::put("confirm", "TransactionController@confirm")->name("transactions.confirm");
Route::resource("categories", "CategoryController");