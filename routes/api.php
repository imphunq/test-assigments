<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ThreadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'posts'
], function ($router) {
    Route::post('create', [PostController::class, 'create']);
    Route::put('/{post}', [PostController::class, 'update']);
    Route::delete('/{post}', [PostController::class, 'delete']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'courses'
], function ($router) {
    Route::post('create', [CourseController::class, 'create']);
    Route::post('/{course}/join', [CourseController::class, 'join']);
    Route::delete('/{course}', [CourseController::class, 'delete']);
    Route::post('/{course}/threads/create', [ThreadController::class, 'create']);
    Route::get('/{course}/threads', [ThreadController::class, 'index']);
    Route::post('/{course}/threads/{thread}/comment', [ThreadController::class, 'comment']);
    Route::delete('/{course}/threads/{thread}/comment-threads/{commentThread}', [ThreadController::class, 'deleteCommentThread']);
});
