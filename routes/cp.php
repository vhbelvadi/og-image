<?php
use Illuminate\Support\Facades\Route;
use State\OgGenerator\Http\Controllers\SettingsController;

Route::name('og-generator.')->prefix('og-generator')->group(function () {
    Route::get('/settings', [SettingsController::class, 'edit'])->name('edit');
    Route::post('/settings', [SettingsController::class, 'update'])->name('update');
    Route::get('/preview', [SettingsController::class, 'preview'])->name('preview');
});

Route::statamic('og-generator', [OgGeneratorController::class, 'edit'])
    ->name('og-generator.edit');
