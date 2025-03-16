// routes/api.php
Route::middleware('auth:api')->group(function () {
    Route::get('/user', [UserController::class, 'show']);
});
