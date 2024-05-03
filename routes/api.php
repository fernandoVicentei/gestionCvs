<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobseekerController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\SkillController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getListJobsekers', [JobseekerController::class, 'getListJobSeekers']);
Route::post('/jobseeker', [JobseekerController::class, 'store']);
Route::get('/jobseeker/{id}', [JobseekerController::class, 'show']);
Route::put('/jobseeker/{id}', [JobseekerController::class, 'update']);
Route::delete('/jobseeker/{id}', [JobseekerController::class, 'destroy']);
Route::get('/searchjobseeker', [JobseekerController::class, 'filterJobseekers']);

Route::get('/jobseekercvs/{id}', [CvController::class, 'getCvJobseeker']);
Route::post('/jobseekercv', [CvController::class, 'store']);
Route::put('/jobseekercv/{id}', [CvController::class, 'update']);
Route::delete('/jobseekercv/{id}', [CvController::class, 'destroy']);
Route::get('/getcv/{id}', [CvController::class, 'getCv']);

Route::get('/getcvskills/{id}', [SkillController::class, 'getSkillCvs']);
Route::post('/skillcv', [SkillController::class, 'store']);
Route::put('/skillcv/{id}', [SkillController::class, 'update']);
Route::delete('/skillcv/{id}', [SkillController::class, 'destroy']);
