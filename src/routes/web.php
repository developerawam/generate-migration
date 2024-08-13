<?php

use Illuminate\Support\Facades\Route;
use Developerawam\GenerateMigration\Http\Controllers\GenerateMigrationController;

Route::middleware(['web'])->group(function () {
    Route::get('generate-migration/generate-ui', function () {
        return view('generate-ui::generate-ui');
    })->name('generate-migration.form');

    Route::post('generate-migration/submit', [GenerateMigrationController::class, 'store'])->name('generate-migration.submit');
});
