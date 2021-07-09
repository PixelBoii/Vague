<?php

use Illuminate\Support\Facades\Route;
use PixelBoii\Vague\Http\Controllers\DashboardController;
use PixelBoii\Vague\Http\Controllers\ResourceController;
use PixelBoii\Vague\Http\Controllers\RecordController;
use PixelBoii\Vague\Http\Controllers\ElementController;

Route::redirect('/', '/' . config('vague.prefix') . '/dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('vague.dashboard.index');

Route::get('/resource/{resource}', [ResourceController::class, 'index'])->name('vague.resource.index');
Route::post('/resource/{resource}/search', [ResourceController::class, 'search'])->name('vague.resource.search');
Route::post('/resource/{resource}/create', [ResourceController::class, 'create'])->name('vague.resource.create');
Route::post('/resource/{resource}/{action}', [ResourceController::class, 'action'])->name('vague.resource.action');

Route::get('/resource/{resource}/{record}', [RecordController::class, 'index'])->name('vague.record.index');
Route::post('/resource/{resource}/{record}/actions/{action}', [RecordController::class, 'action'])->name('vague.record.action');
Route::post('/resource/{resource}/{record}/elements/{element}/events/{event}', [RecordController::class, 'triggerEvent'])->name('vague.record.triggerEvent');