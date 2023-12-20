@extends('layouts.app')

<style>
    input {
        border-radius: 10px;
        outline: none;
        border: none;
        padding: 15px 0;
        width: 50px;
        text-align: center;
        font-size: 1.5em;
        margin: 0 10px;
    }

    #cart {
        position: fixed;
        bottom: 20px;
        right: 10px;
        background-color: #fff;
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        /* display: none; Remova esta linha */
        z-index: 1000;
        max-width: 50%; /* Defina a largura máxima desejada */
        max-height: 50%; /* Defina a altura máxima desejada */
        overflow-y: auto; /* Adicione esta linha para permitir rolar caso o conteúdo seja muito longo */
        font-size: 13px;
    }



    #cart ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    #cart li {
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
    }

    #cart li span {
        margin-left: 10px;
    }
    #cart h1 {
    font-size: inherit; /* Use o tamanho de fonte padrão para h1 */
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
        <div class="heading_container heading_center">
            @php
                $empresa = \App\Models\empresa::first();
            @endphp

            @if($empresa)
                <h2>
                    <img style="width: 40%; aspect-ratio: 3/2; object-fit: contain;" src="{{ asset('images/' . $empresa->imagem) }}">
                </h2>
            @endif
        </div>

        <div class="col-mt-2">
            <button id="botaoEnviar" class="btn btn-danger btn-block" id="avancar-button" disabled>AVANÇAR</button>
        </div>
        <ul class="filters_menu">
            <li class="active" data-filter="*">Todos</li>
            @foreach ($tipos as $tipo)
                <li data-filter="{{ $tipo->id }}">{{ $tipo->tipo }}</li>
            @endforeach
        </ul>
        <div class="filters-content">
            <form id="meuForm" action="{{ route('pedidos.store') }}" method="POST">
                @csrf
                <div class="row grid">
                    @foreach($produtos as $produto)
                        <div class="col-sm-3 filter-item" data-tipo="{{ $produto->tipo }}">
                            <div class="box">
                                <div>
                                    <div class="img-box">
                                        <img style="border-radius: 10px" src="{{ asset('images/' . $produto->imagem) }}" alt="{{ $produto->nome }}">
                                    </div>
                                    <div class="detail-box">
                                        <h5>{{ $produto->nome }}</h5>
                                        <div class="options">
                                            <h6>R${{ $produto->preco }} - <small>{{ $produto->descricao }}</small></h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-12" style="align-items: center">
                                                <button type="button" onclick="qtdporcao({{ $produto->id }},0)" class="sub btn btn-danger"><strong>-</strong></button>
                                                <input type="text" id="qtd{{ $produto->id }}" class="qtyBox" name="produtos[{{ $produto->id }}][quantidade]" readonly="" value="0">
                                                <button type="button" onclick="qtdporcao({{ $produto->id }},1)" class="add btn btn-success"><strong>+</strong></button>
                                                <input type="hidden" id="prod{{ $produto->id }}" name="produtos[{{ $produto->id }}][id]" value="{{ $produto->id }}">
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
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var filterItems = document.querySelectorAll(".filter-item");
            var filterButtons = document.querySelectorAll(".filters_menu li");

            filterButtons.forEach(function (button) {
                button.addEventListener("click", function () {
                    var filterValue = this.getAttribute("data-filter");

                    // Adiciona ou remove a classe 'active' dos botões do menu
                    filterButtons.forEach(function (btn) {
                        btn.classList.remove("active");
                    });
                    this.classList.add("active");

                    // Mostra ou oculta os itens do grid com base no filtro selecionado
                    filterItems.forEach(function (item) {
                        var tipo = item.getAttribute("data-tipo");
                        if (filterValue === "*" || tipo === filterValue) {
                            item.style.display = "block";
                        } else {
                            item.style.display = "none";
                        }
                    });
                });
            });

            let addBtns = document.querySelectorAll('.add');
            let subBtns = document.querySelectorAll('.sub');
            let qtyInputs = document.querySelectorAll('.qtyBox');
            let cart = document.getElementById('cart');
            let cartItems = document.getElementById('cart-items');
            let cartTotal = document.getElementById('cart-total');
            let botaoAvancar = document.getElementById("botaoEnviar");


            addBtns.forEach((addBtn, index) => {
                addBtn.addEventListener('click', () => {
                    qtyInputs[index].value = parseInt(qtyInputs[index].value) + 1;
                    updateCart(index);
                });
            });

            subBtns.forEach((subBtn, index) => {
                subBtn.addEventListener('click', () => {
                    if (qtyInputs[index].value > 0) {
                        qtyInputs[index].value = parseInt(qtyInputs[index].value) - 1;
                        updateCart(index);
                    }
                });
            });

            function updateCart(index) {
                let productName = document.querySelectorAll('.detail-box h5')[index].innerText;
                let productPrice = parseFloat(document.querySelectorAll('.options h6')[index].innerText.split('R$')[1]);
                let quantity = parseInt(qtyInputs[index].value);
                let subtotal = quantity * productPrice;

                if (quantity > 0) {
                    addToCart(productName, quantity, subtotal);
                } else {
                    removeFromCart(productName);
                }

                updateCartTotal();
                habilitarBotaoAvancar();
            }

            function addToCart(name, quantity, subtotal) {
                const truncatedName = name.length > 12 ? name.substring(0, 12) + '...' : name;

                const existingItem = document.querySelector(`#cart-items li[data-name="${name}"]`);
                if (existingItem) {
                    existingItem.querySelector('span.quantity').innerText = quantity;
                    existingItem.querySelector('span.subtotal').innerText = (quantity * subtotal).toFixed(2);
                } else {
                    const li = document.createElement('li');
                    li.dataset.name = name;
                    li.innerHTML = `${truncatedName}<span class="quantity">${quantity}</span>R$<span class="subtotal">${(quantity * subtotal).toFixed(2)}</span>`;
                    cartItems.appendChild(li);
                }

                cart.style.display = 'block';
            }


            function removeFromCart(name) {
                const itemToRemove = document.querySelector(`#cart-items li[data-name="${name}"]`);
                if (itemToRemove) {
                    itemToRemove.remove();
                }
            }

            function updateCartTotal() {
                const subtotals = document.querySelectorAll('#cart-items li .subtotal');
                let total = 0;

                subtotals.forEach(subtotal => {
                    const subtotalValue = parseFloat(subtotal.innerText);

                    if (!isNaN(subtotalValue)) {
                        total += subtotalValue;
                    }
                });

                cartTotal.innerText = total.toFixed(2);
            }


            function habilitarBotaoAvancar() {
                let qtyInputs = document.querySelectorAll('.qtyBox');
                let habilitar = false;

                qtyInputs.forEach(function (qtyInput) {
                    if (parseInt(qtyInput.value) > 0) {
                        habilitar = true;
                    }
                });

                botaoAvancar.disabled = !habilitar;
            }

            // Adicione este trecho para atualizar o carrinho ao carregar a página
            updateCartTotal();
            habilitarBotaoAvancar();

            // Adicione este trecho para submeter o formulário quando o botão "AVANÇAR" for clicado
            botaoAvancar.addEventListener("click", function () {
                document.getElementById("meuForm").submit();
            });
        });
    </script>

    <!-- Carrinho de Compras -->
    <div id="cart">
        <h2>Carrinho</h2>
        <ul id="cart-items"></ul>
        <hr>
        <strong>Total: R$<span id="cart-total">0.00</span></strong>
    </div>
@endsection
