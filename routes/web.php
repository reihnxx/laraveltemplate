<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataTableController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('ajax-crud-datatable', [DataTableController::class, 'index']);
Route::post('store-company', [DataTableController::class, 'store']);
Route::post('edit-company', [DataTableController::class, 'edit']);
Route::post('delete-company', [DataTableController::class, 'destroy']);

