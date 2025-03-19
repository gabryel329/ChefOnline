<?php

namespace App\Http\Controllers;

use App\Models\Frete;
use Illuminate\Http\Request;

class FreteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fretes = Frete::all();
        return view('frete.index', compact('fretes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $bairro = strtoupper($request->input('bairro'));
        $valor = $request->input('valor');

        $existingFrete = Frete::where('bairro', $bairro)->first();

        if ($existingFrete) {
            return redirect()->route('frete.index')->with('error', 'Nome do bairro já existe');
        }

        Frete::create([
            'bairro' => $bairro,
            'valor' => $valor,
        ]);

        return redirect()->route('frete.index')->with('success', 'Frete criado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Frete $frete)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Frete $frete)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $frete = Frete::find($id);

        if (!$frete) {
            return redirect()->back()->with('error', 'Frete não encontrado');
        }

        $frete->bairro = strtoupper($request->input('bairro'));
        $frete->valor = $request->input('valor');

        $frete->save();

        return redirect()->route('frete.index')->with('success', 'Frete atualizado com sucesso');
    }

    public function destroy($id)
    {
        $frete = Frete::findOrFail($id);

        $frete->delete();

        return redirect()->route('frete.index')->with('success', 'Frete excluído com sucesso');
    }
}
