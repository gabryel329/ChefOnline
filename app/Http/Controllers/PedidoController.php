<?php

namespace App\Http\Controllers;

use App\Models\FormaPagamento;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $pedidos = Pedido::all();

        // return view('pedido.create', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produtos = Produto::all();

        return view('pedido.create', compact('produtos'));
    }

    public function store(Request $request)
    {
        $data = [];

        $total = 0;

        foreach ($request->produtos as $produto) {
            $prod = Produto::find($produto['id']);
            $total += $prod->preco * $produto['quantidade'];
        }

        $data['total'] = $total;

        $pedido = Pedido::create($data);

        foreach ($request->produtos as $produto) {
            $pedido->produtos()->attach($produto['id'], ['quantidade' => $produto['quantidade']]);
        }

        return response()->json(['message' => 'Pedido criado com sucesso', 'pedido_id' => $pedido->id]);
    }
    public function showCheckoutForm($pedido)
    {
        $pedido = Pedido::findOrFail($pedido);
        $formasPagamento = FormaPagamento::all();
        $produtos = $pedido->produtos;
        $total = $pedido->total;

        return response()->json([
            'pedido' => $pedido,
            'formasPagamento' => $formasPagamento,
            'produtos' => $produtos,
            'total' => $total
        ]);
    }

    public function processCheckout(Request $request, $pedido)
    {
        $pedido = Pedido::findOrFail($pedido);

        $pedido->update([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'forma_pagamento_id' => $request->forma_pagamento_id,
        ]);

        // Retorne uma resposta JSON com uma mensagem de sucesso
        return response()->json([
            'message' => 'Pedido concluído com sucesso!'
        ]);
    }

    public function removeProduto(Request $request, Pedido $pedido, $produto)
    {
        // Encontre o produto no pedido pelo ID
        $produtoRemover = $pedido->produtos()->findOrFail($produto);

        // Remova o produto do pedido
        $pedido->produtos()->detach($produtoRemover->id);

        // Retorne uma resposta JSON com uma mensagem de sucesso
        return response()->json([
            'message' => 'Produto removido com sucesso do pedido.'
        ]);
    }




    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
