<!-- Resultado do relatório -->
<h2>Relatório de Pedidos</h2>
<p>Período: {{ $dataInicial }} a {{ $dataFinal }}</p>
<p>Status: {{ $status ? $statusOptions[$status] : 'Todos' }}</p>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Total</th>
            <th>Nome</th>
            <!-- Adicione mais colunas conforme necessário -->
        </tr>
    </thead>
    <tbody>
        @foreach ($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->id }}</td>
                <td>{{ $pedido->total }}</td>
                <td>{{ $pedido->nome }}</td>
                <!-- Adicione mais colunas conforme necessário -->
            </tr>
        @endforeach
        <tr>
            <td colspan="2"><strong>Total Geral:</strong></td>
            <td>{{ $pedidos->sum('total') }}</td>
            <!-- Adicione mais colunas conforme necessário -->
        </tr>
    </tbody>
</table>
