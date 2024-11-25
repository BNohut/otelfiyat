<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix("/v1")->group(function () {
    Route::any(
        '{tech}/{controller}/{action}/{id?}',
        function ($tech, $controller, $action, Request $request, $id = null) {
            $controllerClass = "App\\Http\\Controllers\\" . ucfirst($tech) . "\\" . ucfirst($controller) . "Controller";
            return (new $controllerClass)->{$action}($request, $id);
        }
    );
});
