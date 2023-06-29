<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\ExperienceController;

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

// Auth
Route::group(['prefix' => 'login'],  function () {
  Route::get('/', [LoginController::class, 'index'])->name('login');
  Route::get('check', [LoginController::class, 'check']);
  Route::post('in', [LoginController::class, 'login']);
  Route::post('out', [LoginController::class, 'logout']);
});


Route::group(['middleware' => ['auth:sanctum', 'auth.authority']],  function () {
  // certification
  Route::group(['prefix' => 'certification'],  function () {
    Route::get('/',  [CertificationController::class, 'index'])->name('certification');
    Route::post('create',  [CertificationController::class, 'create']);
    Route::post('add',  [CertificationController::class, 'add']);
    Route::post('update',  [CertificationController::class, 'update']);
    Route::post('change',  [CertificationController::class, 'change']);
    Route::get('delete/{id}',  [CertificationController::class, 'delete']);
  });

  // experience
  Route::group(['prefix' => 'experience'],  function () {
    Route::get('/',  [ExperienceController::class, 'index'])->name('experience');
    Route::post('create',  [ExperienceController::class, 'create']);
    Route::post('add',  [ExperienceController::class, 'add']);
    Route::post('update',  [ExperienceController::class, 'update']);
    Route::post('change',  [ExperienceController::class, 'change']);
    Route::get('delete/{id}',  [ExperienceController::class, 'delete']);
  });
});
