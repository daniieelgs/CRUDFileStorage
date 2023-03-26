<?php

use App\Http\Controllers\FormController;
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

Route::get('/', [FormController::class, 'index']);
Route::post('form', [FormController::class, 'saveForm']);
Route::get('recap', [FormController::class, 'recap']);
Route::get('seeJSON', [FormController::class, 'loadJSON']);
Route::get('seeXML', [FormController::class, 'loadXML']);
Route::get('download/{disk}/{file}', [FormController::class, 'download']);
Route::get('edit', [FormController::class, 'edit']);
Route::post('edit', [FormController::class, 'editUser']);
Route::get('delete/{nif}', [FormController::class, 'delete']);
Route::get('getData', [FormController::class, 'getData']);