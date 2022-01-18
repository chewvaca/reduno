<?php

use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\GraylogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
    return view('welcome');
});
Route::get('upload_file', function () {
    return view('home');
});
Route::get('get_file/{fileName}', [ArchivoController::class, 'get']);
Route::post('store_file', [ArchivoController::class, 'store']);

Route::get('get_cliente',[MailController::class,'get']);
Route::post('send_mail', [MailController::class, 'store']);

Route::get("messages", [GraylogController::class, "index"]);
Route::get("get_message", [GraylogController::class, "show"]);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
