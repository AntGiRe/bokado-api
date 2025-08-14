<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\RegisteredUserController;
use App\Http\Controllers\Api\V1\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetLinkController;
use App\Http\Controllers\Api\V1\Auth\NewPasswordController;
use App\Http\Controllers\Api\v1\Currency\CurrencyController;
use App\Http\Controllers\Api\v1\Features\FeatureController;
use App\Http\Controllers\Api\V1\Manage\Restaurants\RestaurantController;
use App\Http\Controllers\Api\V1\Manage\Restaurants\RestaurantPaymentMethodController;
use App\Http\Controllers\Api\V1\PaymentMethods\PaymentMethodController;
use App\Http\Controllers\Api\V1\Locations\CountryController;
use App\Http\Controllers\Api\V1\Locations\RegionController;
use App\Http\Controllers\Api\V1\Locations\ProvinceController;
use App\Http\Controllers\Api\V1\Locations\CityController;
use App\Http\Controllers\Api\V1\Locations\TouristicRegionController;
use App\Http\Middleware\CheckRestaurantPermission;
use App\Http\Middleware\SetUserLocale;

// Registro API
Route::prefix('v1')->middleware(SetUserLocale::class)->group(function () {

    // Rutas de autenticación
    Route::prefix('auth')->group(function () {
        Route::post('register', [RegisteredUserController::class, 'store']);

        Route::post('login', [AuthenticatedSessionController::class, 'store']);

        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('password.email');

        Route::post('reset-password', [NewPasswordController::class, 'store'])
            ->name('password.store');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
        });
    });

    // Rutas públicas de restaurantes
    Route::prefix('restaurants')->group(function () {
        Route::get('{slug}', [PublicRestaurantController::class, 'show']);
        Route::get('{slug}/menu', [PublicRestaurantController::class, 'menu']);
    });

    // Rutas de gestión con middleware auth
    Route::prefix('manage')->middleware('auth:sanctum')->group(function () {
        Route::prefix('restaurants')->group(function () {
            // Rutas SIN middleware CheckRestaurantPermission
            Route::get('/', [RestaurantController::class, 'index']);
            Route::post('/', [RestaurantController::class, 'store']);

            // Rutas CON middleware CheckRestaurantPermission
            Route::middleware(CheckRestaurantPermission::class)->group(function () {
                Route::prefix('{restaurant}')->group(function () {
                    Route::get('/', [RestaurantController::class, 'show']);
                    Route::patch('/', [RestaurantController::class, 'update']);
                    Route::delete('/', [RestaurantController::class, 'destroy']);

                    // Activate/Deactivate restaurant
                    Route::post('activate', [RestaurantController::class, 'activate']);
                    Route::post('deactivate', [RestaurantController::class, 'deactivate']);

                    // Personal del restaurante
                    Route::apiResource('staff', RestaurantUserController::class);
                    // Menú (platos, cartas)
                    Route::apiResource('menu', RestaurantMenuController::class);
                    // payment methods
                    Route::apiResource('payment-methods', RestaurantPaymentMethodController::class);
                });
            });
        });
    });

    // Payment methods TODO DELETE in admin
    Route::prefix('payment-methods')->group(function () {
        Route::get('/', [PaymentMethodController::class, 'index']);
        Route::get('/{paymentMethod}', [PaymentMethodController::class, 'show']);
    });

    // Payment methods TODO DELETE in admin
    Route::prefix('currency')->group(function () {
        Route::get('/', [CurrencyController::class, 'index']);
        Route::get('/{currency}', [CurrencyController::class, 'show']);
    });

    // Payment methods TODO DELETE in admin
    Route::prefix('feature')->group(function () {
        Route::get('/', [FeatureController::class, 'index']);
        Route::get('/{feature}', [FeatureController::class, 'show']);
    });

    // Locations
    Route::prefix('locations')->group(function () {
        Route::get('cities', [CityController::class, 'index']);
        Route::get('cities/{city}', [CityController::class, 'show']);
        Route::get('countries', [CountryController::class, 'index']);
        Route::get('countries/{country}', [CountryController::class, 'show']);
        Route::get('regions', [RegionController::class, 'index']);
        Route::get('regions/{region}', [RegionController::class, 'show']);
        Route::get('provinces', [ProvinceController::class, 'index']);
        Route::get('provinces/{province}', [ProvinceController::class, 'show']);
        Route::get('touristic-regions', [TouristicRegionController::class, 'index']);
        Route::get('touristic-regions/{touristicRegion}', [TouristicRegionController::class, 'show']);
    });
});
