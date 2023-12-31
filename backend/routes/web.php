<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemController;

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
  if($request->path() === "/")
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

// UserRegister
Route::group(['prefix' => 'user'],  function () {
  Route::get('register', [UserController::class, 'index']);
  Route::post('check', [UserController::class, 'check']);
  Route::post('create', [UserController::class, 'create']);
});


Route::group(['middleware' => ['auth:sanctum']],  function () {
  // dashboard
  Route::group(['prefix' => 'dashboard'],  function () {
    Route::get('/',  [DashboardController::class, 'index'])->name('dashboard');
  });

  // Certification
  Route::group(['prefix' => 'certification'],  function () {
    Route::get('/',  [CertificationController::class, 'index'])->name('certification');
    Route::post('create',  [CertificationController::class, 'create']);
    Route::post('add',  [CertificationController::class, 'add']);
    Route::post('update',  [CertificationController::class, 'update']);
    Route::post('change',  [CertificationController::class, 'change']);
    Route::get('delete/{id}',  [CertificationController::class, 'delete']);
  });

  // Experience
  Route::group(['prefix' => 'experience'],  function () {
    Route::get('/',  [ExperienceController::class, 'index'])->name('experience');
    Route::post('create',  [ExperienceController::class, 'create']);
    Route::post('update',  [ExperienceController::class, 'update']);
    Route::get('delete/{id}',  [ExperienceController::class, 'delete']);
  });

  // System
  Route::group(['prefix' => 'admin/system', 'as' => 'admin.'],  function () {
    Route::get('/', [SystemController::class, 'index'])->name('system');
    Route::group(['prefix' => 'skill'], function () {
      Route::post('create',  [SystemController::class, 'createSkill']);
      Route::post('update',  [SystemController::class, 'updateSkill']);
  });
  });
});
