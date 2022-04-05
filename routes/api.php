<?php

use App\Http\Controllers\BedOccupancyReportController;
use App\Http\Controllers\GetAuditController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ItemDailyReportController;
use App\Http\Controllers\OxygenTankReportController;
use App\Http\Controllers\TestKitReportController;
use App\Http\Controllers\TokenController;
use App\Models\OxygenTankReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', [TokenController::class, 'store'])->name('login');

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::post('logout', [TokenController::class, 'destroy'])->name('logout');

        Route::get('user', function () {
            return auth()->user();
        });
        Route::apiResource('items', ItemController::class)->except(['store', 'show']);

        Route::prefix('item/report')
            ->as('item-report.')
            ->group(function () {
                Route::post('first', [ItemDailyReportController::class, 'first_entry'])->name('first-entry');
                Route::post('', [ItemDailyReportController::class, 'store'])->name('store');
            });

        Route::prefix('oxygen-tank/report')
            ->as('oxygen-tank-report.')
            ->group(function () {
                Route::post('first', [OxygenTankReportController::class, 'first_entry'])->name('first-entry');
                Route::post('', [OxygenTankReportController::class, 'store'])->name('store');
            });

        Route::prefix('test-kit/report')
            ->as('test-kit-report.')
            ->group(function () {
                Route::post('first', [TestKitReportController::class, 'first_entry'])->name('first-entry');
                Route::post('', [TestKitReportController::class, 'store'])->name('store');
            });

        Route::prefix('bed-occupancy/report')
            ->as('bed-occupancy-report.')
            ->group(function () {
                Route::post('first', [BedOccupancyReportController::class, 'first_entry'])->name('first-entry');
                Route::post('', [BedOccupancyReportController::class, 'store'])->name('store');
            });

        Route::get('audits/{date}', GetAuditController::class)->name('audits');
    });


Route::middleware('check.accessToken')->group(function () {
    Route::get('item/report/{date}', [ItemDailyReportController::class, 'show'])->name('show');
    Route::get('oxygen-tank/report/{date}', [OxygenTankReportController::class, 'show'])->name('show');
    Route::get('test-kit/report/{date}', [TestKitReportController::class, 'show'])->name('show');
    Route::get('bed-occupancy/report/{date}', [BedOccupancyReportController::class, 'show'])->name('show');
});
