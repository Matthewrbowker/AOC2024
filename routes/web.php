<?php

use App\Http\Controllers\day1Controller;
use App\Http\Controllers\day2Controller;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get("/", IndexController::class)->name("index");
Route::get("/day1", day1Controller::class)->name("day1");
Route::get("/day2", day2Controller::class)->name("day2");
