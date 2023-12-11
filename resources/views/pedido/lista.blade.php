@extends('layouts.app')

<style>
    #menu__toggle {
        opacity: 0;
    }
    #menu__toggle:checked + .menu__btn > span {
        transform: rotate(45deg);
    }
    #menu__toggle:checked + .menu__btn > span::before {
        top: 0;
        transform: rotate(0deg);
    }
    #menu__toggle:checked + .menu__btn > span::after {
        top: 0;
        transform: rotate(90deg);
    }
    #menu__toggle:checked ~ .menu__box {
        left: 0 !important;
    }
    .menu__btn {
        position: fixed;
        top: 20px;
        left: 20px;
        width: 26px;
        height: 26px;
        cursor: pointer;
        z-index: 1;
    }
    .menu__btn > span,
    .menu__btn > span::before,
    .menu__btn > span::after {
        display: block;
        position: absolute;
        width: 100%;
        height: 2px;
        background-color: #616161;
        transition-duration: .25s;
    }
    .menu__btn > span::before {
        content: '';
        top: -8px;
    }
    .menu__btn > span::after {
        content: '';
        top: 8px;
    }
    .menu__box {
        display: block;
        position: fixed;
        top: 0;
        left: -100%;
        width: 200px; /* Adjust the width as needed */
        height: auto; /* Set to auto or a specific value */
        margin: 0;
        padding: 80px 0;
        list-style: none;
        background-color: #ECEFF1;
        box-shadow: 2px 2px 6px rgba(0, 0, 0, .4);
        transition-duration: .25s;
    }
    .menu__item {
        display: block;
        padding: 12px 24px;
        color: #333;
        font-family: 'Roboto', sans-serif;
        font-size: 20px;
        font-weight: 600;
        text-decoration: none;
        transition-duration: .25s;
    }
    .menu__item:hover {
        background-color: #CFD8DC;
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

<div class="hamburger-menu" id="botao-canto-superior-direito">
    <input id="menu__toggle" type="checkbox" />
    <label class="menu__btn" for="menu__toggle">
      <span></span>
    </label>

    <ul class="menu__box">
      <li><a class="menu__item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a></li>
      <li><a class="menu__item" href="/filtro">Relatorio</a></li>
    </ul>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

<section class="food_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2><img style="width: 40%; height: 30%; margin-top: -10%; margin-bottom: -10%" src="{{ asset('images/logo1.png') }}"></h2>
        </div>
        <div class="row filters_menu">
            <div class="col-md-12">
                <div class="btn-group filters_menu" role="group" aria-label="Filtrar por status">
                    <ul class="filters_menu" id="filtro-tipo">
                        <li data-tipo="">Todos</li>
                        <li class="active" data-tipo="1">Em Andamento</li>
                        <li data-tipo="2">Feito</li>
                        <li data-tipo="3">Deletado</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="filters-content" id="lista-de-pedidos">
            <!-- Aqui serão exibidos os produtos via AJAX -->
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function carregarPedidos(filtroStatus) {
        var url = '/pedidos/lista';
        if (filtroStatus !== undefined && filtroStatus !== '') {
            url += '?status_id=' + filtroStatus;
        }

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response && response.pedidos) {
                    exibirPedidos(response.pedidos);
                } else {
                    console.error('Resposta da lista de pedidos inválida:', response);
                }
            },
            error: function(error) {
                console.error('Erro ao obter a lista de pedidos:', error);
            }
        });
    }

    function exibirPedidos(pedidos) {
        var listaDePedidos = $('#lista-de-pedidos');
        listaDePedidos.empty();

        var pedidosPorStatus = {};

        pedidos.forEach(function(pedido) {
            if (!pedidosPorStatus[pedido.status_id]) {
                pedidosPorStatus[pedido.status_id] = [];
            }

            pedidosPorStatus[pedido.status_id].push(pedido);
        });

        for (var status_id in pedidosPorStatus) {
            if (pedidosPorStatus.hasOwnProperty(status_id)) {
                exibirStatus_id(status_id, pedidosPorStatus[status_id]);
            }
        }
    }

    var status_id = 0;

    var statusNames = {
    1: 'Em Andamento',
    2: 'Feito',
    3: 'Deletado'
    };

    function exibirStatus_id(status_id, pedidos) {
        var listaDePedidos = $('#lista-de-pedidos');
        if (statusNames.hasOwnProperty(status_id)) {
        listaDePedidos.append('<div class="status_id-separator"><br><h2>' + statusNames[status_id] + '</h2></div>');
        } else {
        console.error('Nome do status não encontrado para o ID ' + status_id);
        }
        let htmlString = '<div class="row">';
        pedidos.forEach(pedido => {

            const formasPagamento = {
                1: 'PIX',
                2: 'DEBITO',
                3: 'CREDITO',
                4: 'DINHEIRO'
            };

            htmlString += `
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header" style="text-align: center">
                            Pedido #${pedido.id}
                            ${pedido.nome ? `<p class="card-text"><small class="text-muted">${pedido.nome} - ${pedido.telefone}</small></p>` : ''}
                            <p class="card-text"><small class="text-muted">${formatarData(pedido.created_at)}</small></p>
                        </div>
                        <div class="card-body">
                            <ul>
                                ${pedido.produtos.map(produto => `
                                    <li>${produto.nome} - Quantidade: ${produto.pivot.quantidade}</li>
                                `).join('')}
                                ${pedido.forma_pagamento_id ? `<li>Forma Pagamento:<strong> ${formasPagamento[pedido.forma_pagamento_id]}</strong></li>` : ''}
                                <li><strong style="color: red">Total: R$${pedido.total},00</strong></li>
                            </ul>
                            ${pedido.obs ? `Observação:<p class="card-text"><small class="text-muted">${pedido.obs}</small></p>` : ''}
                        </div>
                        <div class="card-footer">
                            <form action="/pedidos/${pedido.id}/update" method="POST" class="update-status-form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="pedido_id" value="${pedido.id}">
                            <div class="form-group">
                                <label for="status_id">Status do Pedido:</label>
                                <select name="status_id" class="form-control">
                                    <option value="1" ${pedido.status_id == 1 ? 'selected' : ''}>Em Andamento</option>
                                    <option value="2" ${pedido.status_id == 2 ? 'selected' : ''}>Feito</option>
                                    <option value="3" ${pedido.status_id == 3 ? 'selected' : ''}>Deletado</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-danger">Atualizar Status</button>
                        </form>
                        </div>
                    </div>
                </div>`;
        });

        htmlString += '</div>';

        function formatarData(data) {
            const dataFormatada = new Date(data);
            const dia = String(dataFormatada.getDate()).padStart(2, '0');
            const mes = String(dataFormatada.getMonth() + 1).padStart(2, '0');
            const ano = dataFormatada.getFullYear();
            const horas = String(dataFormatada.getHours()).padStart(2, '0');
            const minutos = String(dataFormatada.getMinutes()).padStart(2, '0');
            const segundos = String(dataFormatada.getSeconds()).padStart(2, '0');

            return `${dia}-${mes}-${ano} ${horas}:${minutos}:${segundos}`;
        }

        listaDePedidos.append(htmlString);
    }

    $(document).ready(function() {
        carregarPedidos('');

        $('.filters_menu li').click(function() {
            $('.filters_menu li').removeClass('active');
            $(this).addClass('active');
            var status_idSelecionado = $(this).data('tipo');
            carregarPedidos(status_idSelecionado);
        });
    });

    // Função para atualizar a página a cada 30 segundos
    function atualizarPagina() {
        setTimeout(function() {
            location.reload(); // Recarrega a página
        }, 30000); // 30 segundos em milissegundos
    }

    // Chama a função na carga inicial da página
    atualizarPagina();

</script>

@endsection
