<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->route("filament.auth.login");
});
Route::get("visit/departure/{visit}",[\App\Http\Controllers\VisitController::class,"departure"])
    ->name("visit.departure")
    //->can("out","visit")
;
