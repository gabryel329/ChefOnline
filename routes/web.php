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

#PEDIDO


Route::middleware(['auth', 'checkUserRole:Admin'])->group(function () {
    Route::get('/home', [PedidoController::class, 'index'])->name('pedidos.index');
});

Route::middleware(['auth', 'checkUserRole:Client'])->group(function () {
    Route::get('/lista/{status?}', [PedidoController::class, 'lista'])->name('pedidos.lista');
});


Route::post('/pedido/store', [PedidoController::class, 'store'])->name('pedidos.store');
Route::get('/pedido/checkout/{pedido}', [PedidoController::class, 'showCheckoutForm'])->name('pedido.checkout');
Route::post('/pedido/checkout/{pedido}', [PedidoController::class, 'processCheckout'])->name('pedido.processCheckout');
Route::delete('/pedido/{pedido}/produtos/{produto}', [PedidoController::class, 'removeProduto'])->name('pedido.removeProduto');

Route::put('/pedidos/{pedido}', [PedidoController::class, 'updateLista'])->name('pedido.updateLista');






