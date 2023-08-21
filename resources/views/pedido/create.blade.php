@extends('layouts.app')

<link href="{{ asset('css/carousel.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

@section('content')
    <div class="main-item">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card text-center">
                        <div class="card-body">
                            <h1 class="text-center">MENU</h1>
                            <form id="pedido-form" method="POST">
                                @csrf
                                <div class="row product-list">
                                    <!-- Os produtos serão preenchidos aqui via AJAX -->
                                </div>
                                <button type="button" class="btn btn-primary btn-block" id="avancar-btn" disabled>AVANÇAR</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $.ajax({
                url: '{{ route('pedidos.create') }}', // Substitua pelo URL correto para listar os produtos
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Preencha o formulário com os produtos listados
                    var productList = $('.product-list');
                    $.each(data.produtos, function (index, produto) {
                        productList.append(
                            '<div class="col-md-6 mb-3">' +
                            '<div class="card product-card">' +
                            '<div class="card-body">' +
                            '<div class="circle">' +
                            '<img src="URL_DA_IMAGEM_DO_PRODUTO" alt="' + produto.nome + '">' +
                            '</div>' +
                            '<label class="text-center"><strong>R$' + produto.preco + ',00</strong></label>' +
                            '<input type="hidden" name="produtos[' + produto.id + '][id]" value="' + produto.id + '">' +
                            '<label for="' + produto.id + '" class="text-center">' + produto.nome + '</label>' +
                            '<input style="text-align: center" type="number" name="produtos[' + produto.id + '][quantidade]" class="form-control quantity-input" min="0">' +
                            '</div>' +
                            '</div>' +
                            '</div>'
                        );
                    });

                    // Após preencher os produtos, ativar o botão se houver produtos selecionados
                    $('.quantity-input').trigger('change');
                }
            });

            $('.quantity-input').on('change', function () {
                var quantity = parseInt($(this).val());

                if (quantity > 0) {
                    $(this).closest('.product-card').addClass('product-selected');
                } else {
                    $(this).closest('.product-card').removeClass('product-selected');
                }

                // Verificar se há pelo menos um produto selecionado
                if ($('.product-selected').length > 0) {
                    $('#avancar-btn').prop('disabled', false); // Habilitar o botão
                } else {
                    $('#avancar-btn').prop('disabled', true); // Desabilitar o botão
                }
            });
        });
    </script>

    <style>
        .circle {
            background: rgba(15, 28, 63, 0.125);
            border-radius: 50%;
            height: 8em;
            width: 8em;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
        }

        .circle img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 50%;
        }

        .product-card {
            text-align: center;
        }

        .product-selected {
            background-color: #fdfd96;
            color: black;
        }
    </style>
@endsection
