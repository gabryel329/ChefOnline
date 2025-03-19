@extends('layouts.app')
@section('content')

<section class="book_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            @php
                $empresa = \App\Models\empresa::first();
            @endphp

            @if($empresa)
                <h2>
                    <img style="width: 40%; aspect-ratio: 3/2; object-fit: contain; margin-top: 10px" src="{{ asset('images/' . $empresa->imagem) }}">
                </h2>
            @endif
        </div>
        <div class="row justify-content-center">
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
                                                <span class="small">Preço: R${{ $produto->preco }}</span>
                                                <br>
                                                <span id="qtd">Qtd: {{ $produto->pivot->quantidade }}</span>
                                                <br>
                                                <span class="thin small">Subtotal: R${{ number_format($produto->preco * $produto->pivot->quantidade, 2) }}</span>
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
                            <div id="total" name="total" class="thin dense">R${{ number_format($total, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="heading_container">
                    <h2>Dados do Cliente</h2>
                </div>
                <div class="form_container rounded p-4" style="background-color: white;">
                    <form action="{{ route('pedido.processCheckout', ['pedido' => $pedido->id]) }}" method="POST">
                        @csrf
                        <div>
                            <label>Nome</label>
                            <input type="text" name="nome" class="form-control" required />
                        </div>
                        <div>
                            <label>Telefone</label>
                            <input type="text" name="telefone" class="form-control" placeholder="(XX)XXXXX-XXXX" />
                        </div>
                        <div>
                            <label>Data e Hora da entrega</label>
                            <input type="datetime-local" name="cpf" class="form-control" placeholder="Escolha a data e hora">
                            <input style="display: none" name="total" class="form-control" value="{{ $pedido->total }}" />
                            <input style="display: none" name="id" id="id" class="form-control" value="{{ $pedido->id }}" />
                        </div>
                        <div>
                            <label>Forma Pagamento</label>
                            <select name="forma_pagamento_id" class="form-control nice-select wide">
                                <option value="" disabled selected>Escolha</option>
                                @foreach ($formasPagamento as $formaPagamento)
                                    <option value="{{ $formaPagamento->id }}" required>{{ $formaPagamento->forma }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="form-label">Frete:</label>
                        <div class="row">
                            <div class="mb-3 col-md-2">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio"
                                            name="frete" value="S" onchange="toggleDivs()">Sim
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3 col-md-2">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio"
                                            name="frete" value="N" onchange="toggleDivs()">Não
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3 col-md-8 bairroDiv" style="display: none;">
                                <label>Bairros</label>
                                <select name="frete_bairro" id="frete_bairro" class="form-control nice-select wide">
                                    <option value="" disabled selected>Selecione o bairro</option>
                                    @foreach ($fretes as $frete)
                                        <option value="{{ $frete->valor }}">{{ $frete->bairro }}</option>
                                        <option value="">Outros</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <!-- OBSERVAÇÃO DIV -->
                        <div class="obsDiv" style="display: none;">
                            <input type="text" name="obs" id="obs" class="form-control" placeholder="Observação" style=" height: 6em;">
                        </div>
                        <!-- FIM OBSERVAÇÃO DIV -->

                        <!-- FRETE DIV -->
                        <div class="fretDiv" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>CEP:</label>
                                    <input type="text" id="cep" name="cep" class="form-control" style="" placeholder="Digite seu CEP">
                                </div>
                                <div class="col-md-6">
                                    <label>Valor Frete:</label>
                                    <input type="text" id="valor_frete" name="valor_frete" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Logradouro:</label>
                                    <input type="text" id="logradouro" name="logradouro" class="form-control" placeholder="Rua/Avenida" style="">
                                </div>
                                <div class="col-md-6">
                                    <label>Bairro:</label>
                                    <input type="text" id="bairro" name="bairro" class="form-control" placeholder="Bairro" style="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Número:</label>
                                    <input type="text" id="numero" name="numero" class="form-control" placeholder="Nº" style="">
                                </div>
                                <div class="col-md-5">
                                    <label>Cidade:</label>
                                    <input type="text" id="cidade" name="cidade" class="form-control" placeholder="Cidade" style="">
                                </div>
                                <div class="col-md-5">
                                    <label>Estado:</label>
                                    <input type="text" id="estado" name="estado" class="form-control" placeholder="Estado" style="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" name="complemeto" id="complemeto" class="form-control" placeholder="Complemento" style=" height: 6em;">
                                </div>
                            </div>
                        </div>
                        <!-- FIM FRETE DIV -->

                        <div class="btn_box mt-2">
                            <button id="finalizarButton" type="button" class="btn btn-danger">Finalizar</button>
                        </div>
                    </form>
                </div>
                <div class="btn_box mt-2">
                    <a href="javascript:history.back()" class="btn btn-danger">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>

<script>
    $(document).ready(function() {
        var form = $('form');

        $('#finalizarButton').on('click', function() {
            var nome = $('input[name="nome"]').val();
            var telefone = $('input[name="telefone"]').val();
            var cpf = $('input[name="cpf"]').val();
            var dataFormatada = formatDateBR(cpf);
            var obs = $('input[name="obs"]').val();
            var valor_frete = $('input[name="valor_frete"]').val();
            var cep = $('input[name="cep"]').val();
            var logradouro = $('input[name="logradouro"]').val();
            var bairro = $('input[name="bairro"]').val();
            var numero = $('input[name="numero"]').val();
            var cidade = $('input[name="cidade"]').val();
            var estado = $('input[name="estado"]').val();
            var complemento = $('input[name="complemeto"]').val();
            var formaPagamento = $('select[name="forma_pagamento_id"] option:selected').text();
            var nomeEmpresa = '@if($empresa){{ $empresa->nome }}@else{{ 'Nome da Empresa não disponível' }}@endif';
            
            // Condição para verificar se a função do WhatsApp deve ser desabilitada
            @if($empresa && $empresa->whats == 'N')
                // Se WhatsApp desabilitado, envia o formulário diretamente
                form.submit();
            @else
                if (nome && telefone) {
                    var message = "*" + nomeEmpresa + "*\n\n";
                    message += "Olá, segue pedido *#" + $('#id').val() + "*\n\n";

                    // Construa a parte da mensagem com detalhes dos produtos aqui
                    var produtosInfo = "*Produtos*:\n";
                    $('.order-table tbody tr').each(function() {
                        var nomeProduto = $(this).find('strong').text();
                        var quantidade = $(this).find('span[id="qtd"]').text().split(": ")[1];
                        var subtotal = $(this).find('.thin.small').text();

                        produtosInfo += nomeProduto + "\nQuantidade: " + quantidade + "\n" + subtotal + "\n\n";
                    });

                    message += produtosInfo;
                    if (valor_frete) {
                        message += "*Valor Frete:* " + valor_frete + "\n";
                    }else{
                        message += "*Valor Frete:* Consultar\n";
                    }
                    message += "*Total:* " + $('#total').text() + "\n";
                    message += "*Forma de Pagamento:* " + formaPagamento + "\n\n";
                    message += "*ENTREGA:*\n";
                    if (cep) {
                        message += "*CEP:* " + cep + "\n";
                        message += "*Logradouro:* " + logradouro + "\n";
                        message += "*Bairro:* " + bairro + "\n";
                        message += "*Número:* " + numero + "\n";
                        message += "*Cidade:* " + cidade + "\n";
                        message += "*Estado:* " + estado + "\n";
                        message += "*Complemento:* " + complemento + "\n\n";
                    } else {
                        message += obs + "\n\n";
                    }
                    message += "*Nome:* " + nome + "\n";
                    message += "*Telefone:* "+ telefone +"\n";
                    message += "*Data e Hora da entrega:* " + dataFormatada;

                    var recipientPhoneNumber = @if($empresa) {{ $empresa->whats_number }} @endif;
                    var encodedMessage = encodeURIComponent(message);
                    var whatsappURL = 'https://api.whatsapp.com/send?phone='+recipientPhoneNumber+'&text='+encodedMessage;

                    // Abra o WhatsApp em uma nova aba
                    window.open(whatsappURL, '_blank');

                    // Aguarde um segundo e depois envie o formulário
                    setTimeout(function() {
                        form.submit();
                    }, 1000);
                } else {
                    alert('Preencha todos os campos antes de finalizar o pedido.');
                }
            @endif
        });
    });

    $(document).ready(function() {
        // Máscara para CPF
        //$('input[name="cpf"]').inputmask("999.999.999-99", { showMaskOnHover: false });
        // Aplica a máscara para data e hora
        $('#dataHora').mask('00/00/0000 - 00:00', {
            translation: {
                '0': { pattern: /[0-9]/ }
            }
        });
        // Máscara para telefone
        $('input[name="telefone"]').inputmask("(99)99999-9999", { showMaskOnHover: false });
    });

    document.getElementById('frete_bairro').addEventListener('change', function() {
        let valorFrete = parseFloat(this.value); // Pega o valor do frete selecionado
        let totalElement = document.getElementById('total'); // Elemento total
        let totalAtual = parseFloat(totalElement.innerText.replace('R$', '').replace(',', '.')) || 0; // Converte total para número

        // Se valorFrete for inválido (null, vazio ou NaN), não soma
        if (isNaN(valorFrete) || valorFrete <= 0) {
            document.getElementById('valor_frete').value = ""; // Mantém o input vazio
            totalElement.innerText = 'R$' + totalAtual.toFixed(2).replace('.', ','); // Mantém o total sem alteração
            return;
        }

        let novoTotal = totalAtual + valorFrete; // Soma o valor do frete ao total
        document.getElementById('valor_frete').value = valorFrete.toFixed(2).replace('.', ','); // Formata o valor do frete
        totalElement.innerText = 'R$' + novoTotal.toFixed(2).replace('.', ','); // Atualiza o total formatado
    });

</script>


@endsection
