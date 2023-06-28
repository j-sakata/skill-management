<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CertificationController;

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

Route::get('/', function (Request $request) {
  if($request->root() === "http://localhost:8080")
  {
    return redirect("/login");
  };
});
Route::group(['prefix' => 'login'],  function () {
  Route::get('/', [LoginController::class, 'index'])->name('login');
  Route::get('check', [LoginController::class, 'check']);
  Route::post('in', [LoginController::class, 'login']);
  Route::post('out', [LoginController::class, 'logout']);
});

// Auth
Route::group(['middleware' => ['auth:sanctum', 'auth.authority']],  function () {

  Route::group(['prefix' => 'certification'],  function () {
    Route::get('/',  [CertificationController::class, 'index'])->name('user');
    Route::post('create',  [CertificationController::class, 'create']);
    Route::post('update',  [CertificationController::class, 'update']);
    Route::get('delete/{id}',  [CertificationController::class, 'delete']);
  });
});
