<?php

use App\Http\Controllers\Api\CRUD\TaskController;
use App\Http\Middleware\BearerTokenMiddleware;
use Illuminate\Support\Facades\Route;


Route::middleware(BearerTokenMiddleware::class)->apiResource('tasks', TaskController::class);
