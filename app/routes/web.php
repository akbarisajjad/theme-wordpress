// routes/web.php
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
