@extends('layouts.app')
<style>
input{
	border-radius: 10px;
	outline: none;
	border: none;
	padding: 15px 0;
	width: 50px;
	text-align: center;
	font-size: 1.5em;
	margin: 0 10px;
}
</style>
@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div style="text-align: center" class="alert alert-warning">
    {{ session('error') }}
</div>
@endif
<section class="food_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2><img style="width: 50%; height: 40%; margin-top: -10%" src="{{ asset('images/logo1.png') }}"></h2>
        </div>
        <div class="col-mt-2">
            <button id="botaoEnviar" class="btn btn-danger btn-block" id="avancar-button">AVANÇAR</button>
        </div>
        <div class="filters-content">
            <form id="meuForm" action="{{ route('pedidos.store') }}" method="POST">
                @csrf
                <div class="row grid">
                    @foreach($produtos as $produto)
                    <div class="col-sm-3">
                        <div class="box">
                            <div>
                                <div class="img-box">
                                    <img style="border-radius: 10px" src="{{ asset('images/' . $produto->imagem) }}" alt="{{ $produto->nome }}">
                                </div>
                                <div class="detail-box">
                                    <h5>{{ $produto->nome }}</h5>
                                    <div class="options">
                                        <h6>R${{ number_format($produto->preco, 2) }} - {{$produto->descricao }}</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-12" style="align-items: center">
                                            <button type="button" onclick="qtdporcao({{ $produto->id }},0)" class="sub btn btn-danger"><strong>-</strong></button>
                                            <input type="text" id="qtd{{ $produto->id }}" class="qtyBox" name="produtos[{{ $produto->id }}][quantidade]" readonly="" value="0">
                                            <button type="button" onclick="qtdporcao({{ $produto->id }},1)" class="add btn btn-success"><strong>+</strong></button> <span id="porcao-text{{ $produto->id }}"></span>
                                            <input type="hidden" name="produtos[{{ $produto->id }}][id]" value="{{ $produto->id }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    function qtdporcao(index, ref){
        var qtd = document.getElementById("qtd"+index+"").value;

        if (ref==0)
        {
            var qtd = qtd - 1;
        }else{
            var qtd = qtd + 1;
        }

        if (parseInt(qtd) > 1) {
            document.getElementById("porcao-text"+index+"").innerHTML = "- Porções";
        } else {
            document.getElementById("porcao-text"+index+"").innerHTML = "- Porção";
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
    let addBtns = document.querySelectorAll('.add');
    let subBtns = document.querySelectorAll('.sub');
    let qtyInputs = document.querySelectorAll('.qtyBox');

    addBtns.forEach((addBtn, index) => {
        addBtn.addEventListener('click', () => {
            qtyInputs[index].value = parseInt(qtyInputs[index].value) + 1;
            habilitarBotaoAvancar(); // Chame a função após a atualização
        });
    });

    subBtns.forEach((subBtn, index) => {
        subBtn.addEventListener('click', () => {
            if (qtyInputs[index].value <= 0) {
                qtyInputs[index].value = 0;
            } else {
                qtyInputs[index].value = parseInt(qtyInputs[index].value) - 1;
            }
            habilitarBotaoAvancar(); // Chame a função após a atualização
        });
    });

    document.getElementById("botaoEnviar").addEventListener("click", function(e) {
        e.preventDefault(); // Impede o comportamento padrão do botão
        document.getElementById("meuForm").submit();
    });

    function habilitarBotaoAvancar() {
        let qtyInputs = document.querySelectorAll('.qtyBox');
        let botaoAvancar = document.getElementById("botaoEnviar");

        let habilitar = false;

        qtyInputs.forEach(function(qtyInput) {
            if (parseInt(qtyInput.value) > 0) {
                habilitar = true;
            }
        });

        botaoAvancar.disabled = !habilitar;
    }

    // Chame a função para habilitar/desabilitar o botão quando a página carregar
    habilitarBotaoAvancar();
});

</script>

@endsection
