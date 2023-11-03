<?php

use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

#PEDIDO
Route::get('/home', [PedidoController::class, 'index'])->name('pedidos.index');
Route::post('/pedido/store', [PedidoController::class, 'store'])->name('pedidos.store');
Route::get('/pedido/checkout/{pedido}', [PedidoController::class, 'showCheckoutForm'])->name('pedido.checkout');
Route::put('/pedido/checkout/{pedido}', [PedidoController::class, 'processCheckout'])->name('pedido.processCheckout');
Route::delete('/pedido/{pedido}/produtos/{produto}', [PedidoController::class, 'removeProduto'])->name('pedido.removeProduto');





