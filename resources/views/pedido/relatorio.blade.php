@extends('layouts.app')
    <style>
        h1 {
            text-align: center;
            margin-top: 20px;
        }

        p {
            text-align: center;
        }

        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }
    </style>
@section('content')
    <h1>Relatório de Vendas</h1>
    <p>Período: {{ $dataInicial }} a {{ $dataFinal }}</p>
    <p>Status: {{ $status ? $statusOptions[$status] : 'Todos' }}</p>
    <table>
        <thead>
            <tr>
                <th>Pedido</th>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Data/Hora</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->id }}</td>
                    <td>{{ $pedido->nome }}</td>
                    <td>{{ $pedido->telefone }}</td>
                    <td>{{ $pedido->created_at }}</td>
                    <td>R${{ $pedido->total }},00</td>
                </tr>
            @endforeach
            <tr>
                <td><strong>Total de Pedidos: {{ $pedidos->count('id') }}</strong></td>
                <td colspan="3"></td>
                <td><strong>Total Geral: R${{ $pedidos->sum('total') }},00</strong></td>
                <!-- Adicione mais colunas conforme necessário -->
            </tr>
        </tbody>
    </table>


@endsection
