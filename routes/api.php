<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['valid-content-type-header'])->group(function(){

    Route::get("/notes", [NoteController::class, "index"])->name("api.v1.notes.index");
    Route::get("/notes/{note}", [NoteController::class, "show"])->name("api.v1.notes.show");
    Route::post("/notes", [NoteController::class, "store"])->name("api.v1.notes.store");
    Route::get("notes/{note}/edit", [NoteController::class, "edit"])->name("api.v1.notes.edit");
    Route::patch("/notes/{note}", [NoteController::class, "update"])->name("api.v1.notes.update");
    Route::delete("/notes/{note}", [NoteController::class, "destroy"])->name("api.v1.notes.destroy");

});