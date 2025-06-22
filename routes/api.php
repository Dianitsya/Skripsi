<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/notifications', function (Request $request) {
    $notifications = Auth::user()->unreadNotifications->map(function ($notification) {
        return [
            'id' => $notification->id,
            'title' => $notification->data['body'] ?? 'Notifikasi baru',
            'url' => $notification->data['url'] ?? '#',
            'time' => $notification->created_at->diffForHumans(),
        ];
    });

    return response()->json(['notifications' => $notifications]);
});
