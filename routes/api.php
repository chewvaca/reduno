<?php

use App\Http\Controllers\GraylogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('cliente', [MailController::class, 'get']);

// Http::get('http://192.168.7.120:9000/api/search/universal/absolute?query={ip}%20AND%20{port}&from={from}&to={to}&fields=message&decorate=true', [GraylogController::class, 'get']);


// 'http://192.168.7.120:9000/api/search/universal/absolute?query='.'200.69.18.161%20AND%2044230&from=2021-11-08%2000%3A00%3A00&to=2021-11-09%2000%3A01%3A00&fields=message&decorate=true'
