<?php

use App\Http\Controllers\Student\AnnouncementController;
use App\Http\Controllers\Student\AttendanceController;
use App\Http\Controllers\Student\Auth\LoginController;
use App\Http\Controllers\Student\Auth\RegisterController;
use App\Http\Controllers\Student\ClassroomController;
use App\Http\Controllers\Student\TaskController;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::post('/login', [LoginController::class, 'store']);
Route::post('/register', [RegisterController::class, 'store']);




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response([
        'user' => $request->user()
    ]);
});

Route::middleware(['auth:sanctum', 'role:student'])->group(function (){
    Route::post('/logout', function(Request $request){

        $request->user()->tokens()->delete();

        return response([
            'message' => 'Logout Success'
        ]);
    });



    Route::prefix('classrooms')->group(function(){
        Route::get('', [ClassroomController::class, 'index']);
        Route::post('/attendance', [AttendanceController::class, 'log']);
        Route::get('/{classroom}/attendances', [ClassroomController::class, 'attendances']);
        Route::post('/join', [ClassroomController::class, 'join']);
        Route::get('/{classroom}', [ClassroomController::class, 'show']);
        Route::get('/{classroom}/task', [TaskController::class, 'index']);
        Route::get('/task/{studentTask}', [TaskController::class,'show']);
        Route::post('/task/{studentTask}', [TaskController::class,'submitTask']);
        Route::get('/announcement/{announcement}', [AnnouncementController::class, 'show']);
    });
});
