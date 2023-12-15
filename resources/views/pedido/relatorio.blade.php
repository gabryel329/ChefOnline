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
        #botao-canto-superior-direito {
            position: fixed;
            top: 10px; /* Distância do topo */
            right: 10px; /* Distância da direita */
            padding: 10px;
            background-color: #e25a5a; /* Cor de fundo */
            color: #fff; /* Cor do texto */
            border: none;
            cursor: pointer;
            border-radius: 10%;
        }
    </style>
@section('content')
<a href="/filtro" id="botao-canto-superior-direito" class="btn btn-secondary">Voltar</a>
    <h1>Relatório de Vendas</h1>
    <p>Período: {{ $dataInicial }} a {{ $dataFinal }}</p>
    <p>Status: {{ $status ? $statusOptions[$status] : 'Todos' }} - Pago: {{ $pago ? $pagoOptions[$pago] : 'Todos' }}</p>
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
                    <td>R${{ number_format($pedido->total, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td><strong>Total de Pedidos: {{ $pedidos->count('id') }}</strong></td>
                <td colspan="3"></td>
                <td><strong>Total Geral: R${{ number_format($pedidos->sum('total'),2) }}</strong></td>
                <!-- Adicione mais colunas conforme necessário -->
            </tr>
        </tbody>
    </table>


@endsection
