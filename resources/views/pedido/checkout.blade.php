@extends('layouts.app')

@section('content')

<section class="book_section layout_padding">
    <div class="container">
        <div class="heading_container">
            <h2>
                Finalize o Pedido
            </h2>
        </div>
        <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
        <div class="row">
            <div class="col-md-6">
                <h3>DADOS DO CLIENTE</h3>
                <div class="form_container">
                    <form action="{{ route('pedido.processCheckout', ['pedido' => $pedido->id]) }}" method="POST">
                        @csrf
                        <div>
                            <input type="text" name="nome" class="form-control" placeholder="Seu Name" />
                        </div>
                        <div>
                            <input type="text" name="telefone" class="form-control" placeholder="Telefone" />
                        </div>
                        <div>
                            <input type="text" name="cpf" class="form-control" placeholder="CPF" />
                        </div>
                        <div>
                            <select  name="forma_pagamento_id" class="form-control nice-select wide">
                                <option value="" disabled selected>
                                    Escolha
                                </option>
                                    @foreach ($formasPagamento as $formaPagamento)
                                        <option value="{{ $formaPagamento->id }}">{{ $formaPagamento->nome }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="btn_box">
                            <button type="submit" class="btn btn-danger">
                                Finalizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <h3>RESUMO DO PEDIDO</h3>
                <div class="form_container">
                    <table class="order-table">
                        <tbody>
                            @foreach ($pedido->produtos as $produto)
                                @if ($produto->pivot->quantidade > 0)
                                    <tr>
                                        <td>
                                            <div class="img-box">
                                                <img style="border-radius: 10px" src="{{ asset('images/' . $produto->imagem) }}" alt="{{ $produto->nome }}">
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
                            <div id="total" name="total" class="thin dense">R${{ $total }},00</div>
                        </span>
                    </div>
                </div>
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
