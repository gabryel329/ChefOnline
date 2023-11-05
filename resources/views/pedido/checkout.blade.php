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
                            <input style="display: none" name="total" class="form-control" value="{{ $pedido->total }}" />
                        </div>
                        <div>
                            <select name="forma_pagamento_id" class="form-control nice-select wide">
                                <option value="" disabled selected>Escolha</option>
                                @foreach ($formasPagamento as $formaPagamento)
                                    <option value="{{ $formaPagamento->id }}">{{ $formaPagamento->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <textarea name="obs" id="obs" class="form-control" placeholder="Informe onde você se encontra na praça"></textarea>
                        </div>
                        <div class="btn_box mt-4">
                            <button id="finalizarButton" type="button" class="btn btn-danger">Finalizar</button>
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
                                                <span class="thin small">Preço: R${{ $produto->preco }},00</span>
                                                <br>
                                                <span id="qtd" class="thin small">Porções: {{ $produto->pivot->quantidade }}</span>
                                                <br>
                                                <span class="thin small"><strong>Subtotal: R${{ $produto->preco * $produto->pivot->quantidade }},00</strong></span>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <form action="{{ route('pedido.removeProduto', ['pedido' => $pedido->id, 'produto' => $produto->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $produto->id }}">Excluir</button>
                                            </form>
                                        </td> --}}
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
    document.addEventListener('DOMContentLoaded', function() {
        var finalizarButton = document.getElementById('finalizarButton');
        var form = document.querySelector('form');

        finalizarButton.addEventListener('click', function() {
            // Submeta o formulário
            form.submit();

            // Aguarde um curto período de tempo (pode precisar ser ajustado)
            setTimeout(function() {
                var nome = document.querySelector('input[name="nome"]').value;
                var telefone = document.querySelector('input[name="telefone"]').value;
                var cpf = document.querySelector('input[name="cpf"]').value;
                var obs = document.querySelector('textarea[name="obs"]').value;
                var formaPagamento = document.querySelector('select[name="forma_pagamento_id"]').options[document.querySelector('select[name="forma_pagamento_id"]').selectedIndex].text;
                var produtosInfo = "";

                // Obtém detalhes dos produtos
                var produtos = document.querySelectorAll('.order-table tr');
                produtos.forEach(function(produto) {
                    var nomeProduto = produto.querySelector('strong').textContent;
                    var quantidade = produto.querySelector('span[id="qtd"]').textContent.split(": ")[1];
                    var subtotal = produto.querySelector('.thin.small strong').textContent;

                    produtosInfo += `*${nomeProduto}*\nQuantidade: *${quantidade}*\n${subtotal}\n\n`;
                });

                if (nome && telefone && cpf) {
                    var message = "*Camarão da Praça*\n\n";
                    message += "Olá, gostaria de fazer um pedido.\n\n";
                    message += produtosInfo;
                    message += "*Total:* " + document.getElementById('total').textContent + "\n";
                    message += "*Forma de Pagamento:* " + formaPagamento + "\n\n";
                    message += "*ENTREGA:*\n";
                    message += obs + "\n\n";
                    message += "*Nome:* " + nome + "\n";
                    message += "*Telefone:* " + telefone;

                    var recipientPhoneNumber = '71986082537';
                    var encodedMessage = encodeURIComponent(message);
                    var whatsappURL = 'https://api.whatsapp.com/send?phone=' + recipientPhoneNumber + '&text=' + encodedMessage;

                    // Abra o WhatsApp em uma nova aba
                    window.open(whatsappURL, '_blank');
                } else {
                    alert('Preencha todos os campos antes de finalizar o pedido.');
                }
            }, 500); // Espere 500 milissegundos (0,5 segundos) após a submissão do formulário
        });
    });
</script>


@endsection
