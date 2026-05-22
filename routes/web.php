<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get("/",[LoginController::class,"userLogin"])->name('login');
/* Start User CRUD Routing */

Route::middleware('auth')->group(function (){
    Route::get("/user-list",[UserController::class,'getUserList'])->name('users.user-list');

    Route::get("/add-user",[UserController::class,'addUser'])->name('users.add-user');

    Route::post("/add-user",[UserController::class,'addUserDetails'])->name('users.add-user-details');

    Route::get("/users/{id}/user-fetch-details",[UserController::class,'fetchUserDetails'])->name('users.fetch-details');

    Route::put("users/{id}/update-user-details",[UserController::class,'updateUserDetails'])->name('users.update-details');

    Route::get("/download-user-data",[UserController::class,'downloadUserData'])->name('users.download-user-data');

    Route::post("/update-user-status",[UserController::class,'updateUserStatus'])->name('users.update-user-status');

    Route::get("/fetch-user-profile",[UserController::class,'fetchUserProfile'])->name('users.fetch-user-profile');
});

/* End User CRUD Routing */

/* Start Login Routing */

Route::get("/user-login",[LoginController::class,"userLogin"])->name('login');

Route::post("/validate-user-login",[LoginController::class,"validateUserLogin"])->name('login.validate-user-login');

Route::get("/user-logout",[LoginController::class,"userLogout"])->name('login.user-logout');

/* End Login Routing */



// Route::get("/test-500",function (){ abort(500); });
