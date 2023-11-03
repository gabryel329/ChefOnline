@extends('layouts.app')

@section('content')

<section class="book_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2><img style="width: 30%; height: 20%; margin-top: -10%" src="{{ asset('images/logo1.png') }}"></h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="heading_container">
                    <h2>Dados do Cliente</h2>
                </div>
                <div class="form_container rounded p-4" style="background-color: white;">
                    <form action="{{ route('pedido.processCheckout', ['pedido' => $pedido->id]) }}" method="POST">
                        @csrf
                        <div>
                            <input type="text" name="nome" class="form-control" placeholder="Seu Nome" />
                        </div>
                        <div>
                            <input type="text" name="telefone" class="form-control" placeholder="Telefone" />
                        </div>
                        <div>
                            <input type="text" name="cpf" class="form-control" placeholder="CPF" />
                        </div>
                        <div>
                            <select name="forma_pagamento_id" class="form-control nice-select wide">
                                <option value="" disabled selected>Escolha</option>
                                @foreach ($formasPagamento as $formaPagamento)
                                    <option value="{{ $formaPagamento->id }}">{{ $formaPagamento->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="btn_box mt-4">
                            <button type="submit" class="btn btn-danger">Finalizar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="heading_container">
                    <h2>Detalhes do Pedido</h2>
                </div>
                <div class="form_container rounded p-4" style="background-color: white;">
                    <table class="order-table">
                        <tbody>
                            @foreach ($pedido->produtos as $produto)
                                @if ($produto->pivot->quantidade > 0)
                                    <tr>
                                        <td>
                                            <div class="img-box">
                                                <img style="border-radius: 10px;" src="{{ asset('images/' . $produto->imagem) }}" alt="{{ $produto->nome }}" width="70" height="70">
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="thin"><strong>{{ $produto->nome }}</strong></span>
                                                <br>
                                                <span class="thin small">PREÇO: R${{ $produto->preco }},00</span>
                                                <br>
                                                <span class="thin small">PORÇÕES: {{ $produto->pivot->quantidade }}</span>
                                                <br>
                                                <span class="thin small"><strong>SUBTOTAL: R${{ $produto->preco * $produto->pivot->quantidade }},00</strong></span>
                                            </div>
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
                        <div class="text-center">
                            <div class="thin dense" style="color: red"><strong>TOTAL</strong></div>
                            <div id="total" name="total" class="thin dense">R${{ $total }},00</div>
                        </div>
                    </div>
                </div>
                <br>
                <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
</section>

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
