<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\FollowingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Auth(Login & Register)
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    //Create Page By Person
    Route::post('/page/create', [PageController::class, 'store']);

    //Follow a Person & Page
    Route::post('/follow/person/{personId}', [FollowingController::class, 'follow_person']);
    Route::post('/follow/page/{pageId}', [FollowingController::class, 'follow_page']);

    //Post Submit As a User & Page Individually
    Route::post('/person/attach-post', [PostController::class, 'person_post']);
    Route::post('/page/{pageId}/attach-post', [PostController::class, 'page_post']);

    //View Feed Post (Post Submitted By Persons & Pages) Following by User
    Route::get('/person/feed', [PostController::class, 'index']);

    //Logout Route
    Route::post('logout', [AuthController::class, 'logout']);
});



