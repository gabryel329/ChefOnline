<?php

use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;
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

// Route::get('/', function () {
//     return view('pedido.create');
// });

Auth::routes();

Route::get('/', [PedidoController::class, 'index'])->name('pedidos.index');
Route::middleware(['auth', 'checkUserRole:Client'])->group(function () {

    #Pedido
    Route::get('/pedidos', [PedidoController::class, 'lista']);
    Route::get('/pedidos/lista', [PedidoController::class, 'pedidos'])->name('pedidos.lista');
    Route::put('/pedidos/{id}/update', [PedidoController::class, 'update'])->name('pedidos.update');
    Route::get('/filtro', [PedidoController::class, 'filtro']);
    Route::post('/relatorio', [PedidoController::class, 'relatorio']);

    #Produtos
    Route::get('produtos', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::get('produtos/{id}', [ProdutoController::class, 'show'])->name('produtos.show');
    Route::post('produtos', [ProdutoController::class, 'store'])->name('produtos.store');
    Route::put('produtos/{id}', [ProdutoController::class, 'update'])->name('produtos.update');
    Route::delete('produtos/{id}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');
});

#Processo Checkout
Route::post('/pedido/store', [PedidoController::class, 'store'])->name('pedidos.store');
Route::get('/pedido/checkout/{pedido}', [PedidoController::class, 'showCheckoutForm'])->name('pedido.checkout');
Route::post('/pedido/checkout/{pedido}', [PedidoController::class, 'processCheckout'])->name('pedido.processCheckout');
Route::delete('/pedido/{pedido}/produtos/{produto}', [PedidoController::class, 'removeProduto'])->name('pedido.removeProduto');






