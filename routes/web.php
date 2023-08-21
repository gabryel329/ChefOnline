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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

#PEDIDO
Route::get('/index', [PedidoController::class, 'index'])->name('pedidos.index');

Route::get('/pedido/create', [PedidoController::class, 'create'])->name('pedidos.create');
Route::post('/pedido', [PedidoController::class, 'store'])->name('pedidos.store');
Route::get('/pedido/checkout/{pedido}', [PedidoController::class, 'showCheckoutForm'])->name('pedido.checkout');
Route::post('/pedido/checkout/{pedido}', [PedidoController::class, 'processCheckout'])->name('pedido.process_checkout');
Route::put('/pedido/{pedido}/processCheckout', [PedidoController::class, 'processCheckout'])->name('pedido.processCheckout');
Route::delete('/pedidos/{pedido}/produtos/{produto}', [PedidoController::class, 'removeProduto'])->name('pedido.removeProduto');



