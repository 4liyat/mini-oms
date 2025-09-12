<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TechnicianController;

// Authentication routes will go here later

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Endpoints for Orders
    Route::apiResource('orders', OrderController::class)->except(['update']);
    Route::post('orders/{order}/assign-technician', [OrderController::class, 'assignTechnician']);
    Route::patch('orders/{order}/done', [OrderController::class, 'markAsDone']);

    // Endpoints for Customers and Technicians (for dropdowns, etc.)
    Route::get('customers', [CustomerController::class, 'index']);
    Route::get('technicians', [TechnicianController::class, 'index']);
});