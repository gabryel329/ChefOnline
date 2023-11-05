@extends('layouts.app')

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
            <h2><img style="width: 40%; height: 30%; margin-top: -10%" src="{{ asset('images/logo1.png') }}"></h2>
        </div>

        <div class="filters-content">
            <form action="{{ route('pedidos.store') }}" method="POST">
                @csrf
                <div class="col-mt-2">
                    <button type="submit" class="btn btn-danger btn-block" disabled id="avancar-button">AVANÇAR</button>
                </div>
                <div class="row grid">
                    @foreach($produtos as $produto)
                    <div class="col-sm-6 col-lg-3 all pasta">
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
                                        <div class="col-12">
                                            <input style="text-align: center" type="number" name="produtos[{{ $produto->id }}][quantidade]" class="form-control product-quantity" min="0">
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
    document.addEventListener('DOMContentLoaded', function () {
        const quantityInputs = document.querySelectorAll('.product-quantity');
        const avancarButton = document.getElementById('avancar-button');

        quantityInputs.forEach(function (input) {
            input.addEventListener('input', function () {
                // Verifica se pelo menos um input de quantidade tem um valor maior que 0
                const atLeastOneQuantityValid = [...quantityInputs].some(function (quantityInput) {
                    return parseInt(quantityInput.value) > 0;
                });

                // Habilita ou desabilita o botão "AVANÇAR" com base na condição acima
                if (atLeastOneQuantityValid) {
                    avancarButton.removeAttribute('disabled');
                } else {
                    avancarButton.setAttribute('disabled', 'disabled');
                }
            });
        });
    });
</script>

@endsection
