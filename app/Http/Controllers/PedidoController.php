<?php

namespace App\Http\Controllers;

use App\Models\FormaPagamento;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
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
            'forma_pagamento_id' => $request->forma_pagamento_id,
            'total' => $request->total,
        ]);

        return redirect()->route('home')->with('success', 'Pedido concluído com sucesso!');
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
