<?php

use App\Http\Controllers\Users\AuthenticationController;
use App\Http\Controllers\Users\CarsController;
use App\Http\Controllers\Users\CommentsController;
use App\Http\Controllers\Users\OrdersController;
use App\Http\Controllers\Users\PasswordResetsController;
use App\Http\Controllers\Users\QuestionsController;
use App\Http\Controllers\Users\PartsOrdersController;
use App\Http\Controllers\Users\PartsController;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/faq', [QuestionsController::class, 'get']);

Route::get('/comments', [CommentsController::class, 'get']);

Route::get('/cars', [CarsController::class, 'get']);
Route::get('/cars/{car}', [CarsController::class, 'show']);

Route::get('/parts', [PartsController::class, 'get']);
Route::get('/parts/{part}', [PartsController::class, 'show']);

Route::middleware('auth:sanctum')->post('/orders', [OrdersController::class, 'store']);

Route::middleware('auth:sanctum')->post('/parts_orders', [PartsOrdersController::class, 'store']);

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthenticationController::class, 'login']);
    Route::post('/register', [AuthenticationController::class, 'register']);
    Route::post('/register/verify', [AuthenticationController::class, 'verify']);

    Route::post('/forget-password', [PasswordResetsController::class, 'sendResetLinkEmail']);
    Route::post('/reset', [PasswordResetsController::class, 'reset']);
});

require __DIR__ . '/admin.php';