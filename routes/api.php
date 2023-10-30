<?php
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\MappingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoutePlanController;
use App\Http\Controllers\SaleController;

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

/*
 *login and logout routes
 */
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

/*
 *Wrap with sanctum middleware to protect the routes
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/mappings', [MappingController::class, 'index']);
    Route::post('/mappings', [MappingController::class, 'store']);

    Route::get('/route-plans', [RoutePlanController::class, 'index']);
    Route::post('/route-plans', [RoutePlanController::class, 'store']);

    Route::get('/sales', [SaleController::class, 'index']);
    Route::post('/sales', [SaleController::class, 'store']);

    Route::get('/products', [ProductController::class, 'index']);

    Route::get('/visits', [VisitController::class, 'index']);
    Route::post('/visits', [VisitController::class, 'store']);

    Route::get('/deliveries', [DeliveryController::class, 'index']);

    Route::get('/appointments', [AppointmentController::class, 'index']);

    Route::get('/maintenances', [MaintenanceController::class, 'index']);

    Route::get('/demos', [DemoController::class, 'index']);
});
