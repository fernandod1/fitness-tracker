<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;


Route::get("/test", [ActivityController::class, "testBroadcast"])->name("test-broadcast");
Route::get("/", [ActivityController::class, "index"])->name("index");
/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::prefix("activity")->middleware(['auth', 'verified'])->group(function () {
    Route::get("dashboard", [ActivityController::class, "dashboard"])->name("dashboard");
    Route::get("filter", [ActivityController::class, "filterByActivityType"])->name("activity.filterbytype");
    Route::post("store", [ActivityController::class, "store"])->name("activity.store");
    Route::delete('{activity}', [ActivityController::class, 'destroy'])->name('activity.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
/*
Route::get("/", [ActivityController::class, "index"])->name("activity.index");
Route::get("/filter", [ActivityController::class, "filterByActivityType"])->name("activity.filterbytype");
Route::post("/store", [ActivityController::class, "store"])->name("activity.store");
*/
require __DIR__.'/auth.php';
