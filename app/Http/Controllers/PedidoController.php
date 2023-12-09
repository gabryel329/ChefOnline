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

            if ($quantidade > 0) { // Verifique se a quantidade Ã© maior que 0 antes de adicionar ao pedido
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

        return redirect()->route('pedidos.index')->with('success', 'Pedido #' . $pedido->id . ' concluí­do com sucesso!');
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
    public function lista()
    {
        $pedidos = Pedido::with(['produtos', 'formaPagamento', 'status'])
            ->orderBy('created_at', 'desc')
            ->get();
        $statuses = Status::all();

        return view('pedido.lista', compact('pedidos', 'statuses'));
    }

    public function pedidos(Request $request)
    {
        $filtroStatus = $request->query('status_id');

        $query = Pedido::with(['produtos', 'formaPagamento', 'status'])->orderBy('created_at', 'desc')->whereDate('created_at', Carbon::today());

        if ($filtroStatus !== null) {
            $query->where('status_id', $filtroStatus);
        }

        $pedidos = $query->get();

        return response()->json(['pedidos' => $pedidos]);
    }

    public function update(Request $request, $id)
    {

        $pedido = Pedido::findOrFail($id);
        $pedido->status_id = $request->input('status_id');
        $pedido->save();

        return redirect()->back()->with('success', 'Status atualiza com sucesso.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
