<?php

use App\Http\Controllers\day1Controller;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get("/", IndexController::class)->name("index");
Route::get("/day1", day1Controller::class)->name("day1");
