@extends('layouts.app')

@section('content')
    <div class="main-item">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6 formulario"> <!-- Dados do Cliente na coluna esquerda -->
                            <h3>DADOS DO CLIENTE</h3>
                            <br>
                            <div class="line"></div>
                            <form action="{{ route('pedido.processCheckout', ['pedido' => $pedido->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nome">NOME</label>
                                    <input type="text" name="nome" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="cpf">CPF</label>
                                    <input type="text" name="cpf" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="telefone">TELEFONE</label>
                                    <input type="tel" name="telefone" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="forma_pagamento_id">FORMA DE PAGAMENTO</label>
                                    <select name="forma_pagamento_id" class="form-control" required>
                                        @foreach ($formasPagamento as $formaPagamento)
                                            <option value="{{ $formaPagamento->id }}">{{ $formaPagamento->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-danger">Finalizar</button>
                            </form>
                        </div>
                        <div class="col-md-6 formulario"> <!-- Produtos na coluna direita -->
                            <h3>RESUMO DO PEDIDO</h3>
                            <div class="line"></div>
                            <table class="order-table">
                                <tbody>
                                    @foreach ($pedido->produtos as $produto)
                                        @if ($produto->pivot->quantidade > 0)
                                            <tr>
                                                <td>
                                                    <div class="circle">
                                                        <img src="{{ $produto->imagem }}" alt="{{ $produto->nome }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <br>
                                                    <span class="thin">{{ $produto->nome }}</span>
                                                    <br>
                                                    <span class="thin small">PREÇO: R${{ $produto->preco }},00</span>
                                                    <br>
                                                    <span class="thin small">PORÇÃO: {{ $produto->pivot->quantidade }}</span>
                                                </td>
                                                <td>
                                                    <div class="price">SUBTOTAL: R${{ $produto->preco * $produto->pivot->quantidade }},00</div>
                                                </td>
                                                <td>
                                                    <form action="{{ route('pedido.removeProduto', ['pedido' => $pedido->id, 'produto' => $produto->id]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $produto->id }}">Excluir</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="line"></div>
                            <div class="total">
                                <span style="float: right; text-align: right;">
                                    <div class="thin dense">TOTAL</div>
                                    <div id="total" class="thin dense">R${{ $pedido->total }},00</div>
                                </span>
                            </div>
                            <br>
                            <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .formulario {
            padding: 30px;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            border: 1px solid #d2d8dd;
            border-radius: 10px;
        }

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

        .product-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>

    <script>
        $(document).ready(function () {
            $('.btn-delete').on('click', function (event) {
                event.preventDefault();
                var deleteForm = $(this).closest('form');
                var totalElement = $('#total'); // O elemento que exibe o total

                $.ajax({
                    url: deleteForm.attr('action'),
                    type: 'DELETE',
                    dataType: 'json',
                    data: deleteForm.serialize(),
                    success: function (data) {
                        // Atualize o valor do total com o novo valor retornado
                        totalElement.text('R$' + data.total + ',00');

                        // Remova a linha da tabela após a exclusão
                        deleteForm.closest('tr').remove();
                    }
                });
            });
        });

    </script>
@endsection
