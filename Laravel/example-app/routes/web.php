<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get("/test", [TestController::class, 'test']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products',
    [ProductController::class,
        'createProduct'
    ])->withoutMiddleware([VerifyCsrfToken::class]);;
Route::put('/products/{id}',
    [ProductController::class,
        'update'
    ])->withoutMiddleware([VerifyCsrfToken::class]);;
Route::delete('/products/{id}',
    [ProductController::class,
        'delete'
    ])->withoutMiddleware([VerifyCsrfToken::class]);;
