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
        Route::post('test', function () {
            return User::factory()->create();
        });
    });
Route::apiResource('items', ItemController::class);

Route::prefix('item/report')
    ->as('item-report.')
    ->group(function () {
        Route::get('{date}', [ItemDailyReportController::class, 'show'])->name('show');
        Route::post('first', [ItemDailyReportController::class, 'first_entry'])->name('first-entry');
        Route::post('', [ItemDailyReportController::class, 'store'])->name('store');
        Route::get('{date}/download-pdf', [ItemDailyReportController::class, 'pdf'])->name('pdf');
    });

Route::prefix('oxygen-tank/report')
    ->as('oxygen-tank-report.')
    ->group(function () {
        Route::get('{date}', [OxygenTankReportController::class, 'show'])->name('show');
        Route::post('first', [OxygenTankReportController::class, 'first_entry'])->name('first-entry');
        Route::post('', [OxygenTankReportController::class, 'store'])->name('store');
    });

Route::prefix('test-kit/report')
    ->as('test-kit-report.')
    ->group(function () {
        Route::get('{date}', [TestKitReportController::class, 'show'])->name('show');
        Route::post('first', [TestKitReportController::class, 'first_entry'])->name('first-entry');
        Route::post('', [TestKitReportController::class, 'store'])->name('store');
    });

Route::prefix('bed-occupancy/report')
    ->as('bed-occupancy-report.')
    ->group(function () {
        Route::get('{date}', [BedOccupancyReportController::class, 'show'])->name('show');
        Route::post('first', [BedOccupancyReportController::class, 'first_entry'])->name('first-entry');
        Route::post('', [BedOccupancyReportController::class, 'store'])->name('store');
    });

Route::get('audits/{date}', GetAuditController::class)->name('audits');
