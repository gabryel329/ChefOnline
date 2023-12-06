@extends('layouts.app')
<style>
    /* Estilo para o botão no canto superior direito */
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
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-warning">
    {{ session('error') }}
</div>
@endif
<button href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();" id="botao-canto-superior-direito">
        Sair
</button>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
<section class="food_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2><img style="width: 40%; height: 30%; margin-top: -10%;  margin-bottom: -10%" src="{{ asset('images/logo1.png') }}"></h2>
        </div>
        <div class="row filters_menu">
            <div class="col-md-12">
                <div class="btn-group filters_menu" role="group" aria-label="Filtrar por status">
                    @foreach ($statuses as $status)
                        <a href="{{ route('pedidos.lista', ['status' => $status->id]) }}"
                           class="btn btn-secondary mr-2 @if ($status->id == $statusSelecionado) active @endif">{{ $status->nome }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($pedidos as $pedido)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header" style="text-align: center">
                            Pedido #{{ $pedido->id }}
                            <p class="card-text"><small class="text-muted">{{ $pedido->nome }} - {{ $pedido->telefone }}</small></p>
                        </div>
                        <div class="card-body">
                            <ul>
                                @foreach ($pedido->produtos as $produto)
                                    <li>{{ $produto->nome }} - Quantidade: {{ $produto->pivot->quantidade }}</li>
                                @endforeach
                                <li>Forma Pagamento: {{ $pedido->formaPagamento->nome }}</li>
                                <li><strong style="color: red">Total: R${{ $pedido->total }},00</strong></li>
                            </ul>
                            Observação:<p class="card-text"><small class="text-muted">{{ $pedido->obs }}</small></p>
                        </div>
                        <div class="card-footer">
                            <form action="{{ route('pedido.update', $pedido->id) }}" method="POST" class="update-status-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="pedido_id" value="{{ $pedido->id }}"> <!-- Adicione um campo oculto com o ID do pedido -->
                                <div class="form-group" >
                                    <label for="status_id">Status do Pedido:</label>
                                    <select name="status_id" class="form-control status-select" data-pedido="{{ $pedido->id }}" id="status_id">
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}" {{ $pedido->status_id === $status->id ? 'selected' : '' }}>
                                                {{ $status->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('.status-select').change(function() {
            var id = $(this).data('pedido');
            var novoStatus = $(this).val();

            $.ajax({
                type: 'PUT',
                url: '/pedidos/' + id, // Substitua pelo URL correto da rota de atualização
                data: {
                    _token: '{{ csrf_token() }}',
                    status_id: novoStatus
                },
                success: function(response) {
                    document.getElementById(id).style.display='none'
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });


    $(document).ready(function() {
        $('.filters_menu a').click(function() {
            $('.filters_menu a').removeClass('active');
            $(this).addClass('active');
        });

        $('.status-select').change(function() {
            // Seu código de atualização de status aqui
        });
    });

    // Função para atualizar a página a cada 30 segundos
    function atualizarPagina() {
        setTimeout(function() {
            location.reload(); // Recarrega a página
        }, 15000); // 30 segundos em milissegundos
    }

    // Chama a função na carga inicial da página
    atualizarPagina();

</script>

@endsection
