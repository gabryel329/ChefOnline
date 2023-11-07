<?php

namespace App\Http\Controllers;

use App\Models\FormaPagamento;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PedidoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'store', 'showCheckoutForm', 'processCheckout','removeProduto','lista','update']);
    }

    public function index()
    {
        $produtos = Produto::all();
        return view('pedido.create', compact('produtos'));
    }

    public function store(Request $request)
    {
        $data = [];

        $total = 0;

        foreach ($request->produtos as $produtoId => $produtoData) {
            $prod = Produto::find($produtoId);
            $total += $prod->preco * $produtoData['quantidade'];
        }

        $data['total'] = $total;

        $pedido = Pedido::create($data);

        foreach ($request->produtos as $produtoId => $produtoData) {
            $quantidade = $produtoData['quantidade'];

            if ($quantidade > 0) { // Verifique se a quantidade é maior que 0 antes de adicionar ao pedido
                $pedido->produtos()->attach($produtoId, ['quantidade' => $quantidade]);
            }
        }


        return redirect()->route('pedido.checkout', ['pedido' => $pedido->id]);
    }


    public function showCheckoutForm($pedido)
    {
        $pedido = Pedido::findOrFail($pedido);
        $formasPagamento = FormaPagamento::all();
        $produtos = $pedido->produtos;
        $total = $pedido->total;

        return view('pedido.checkout', compact('pedido', 'formasPagamento', 'produtos', 'total'));
    }

    public function processCheckout(Request $request, $pedido)
    {
        $pedido = Pedido::findOrFail($pedido);

        $pedido->update([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'obs' => $request->obs,
            'status_id' => '1',
            'forma_pagamento_id' => $request->forma_pagamento_id,
            'total' => $request->total,
        ]);

        return redirect()->route('pedidos.index')->with('success', 'Pedido #' . $pedido->id . ' concluído com sucesso!');
    }

    public function removeProduto(Request $request, Pedido $pedido, $produto)
    {
        // Encontre o produto no pedido pelo ID
        $produtoRemover = $pedido->produtos()->findOrFail($produto);

        // Remova o produto do pedido
        $pedido->produtos()->detach($produtoRemover->id);

        return redirect()->back()->with('success', 'Produto removido com sucesso do pedido.');
    }
    /**
     * Show the form for editing the specified resource.
     */

    public function lista($status = null)
    {
        $statuses = Status::all();
        $pedidosQuery = Pedido::with('produtos')->orderBy('id', 'desc')->whereDate('created_at', Carbon::today())->whereNotNull('cpf');

        $statusSelecionado = $status ?? 1; // Defina o status selecionado, usando o valor padrão 1 se nenhum estiver definido.

        if ($status !== null) {
            $pedidosQuery->where('status_id', $status);
        }

        $pedidos = $pedidosQuery->get();

        return view('pedido.lista', compact('pedidos', 'statuses', 'statusSelecionado'));
    }

     public function update(Request $request, $id)
     {
         $pedido = Pedido::find($id);

         if ($pedido) {
             $pedido->status_id = $request->input('status_id');
             $pedido->save();

             // Lide com a resposta AJAX, se necessário
             return response()->json(['message' => 'Status atualizado com sucesso']);
         }

         return response()->json(['error' => 'Pedido não encontrado'], 404);
     }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
