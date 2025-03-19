<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Basic -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!-- Site Metas -->
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        @php
            $empresa = \App\Models\empresa::first();
        @endphp

        @if($empresa)
            <link rel="shortcut icon" href="{{ asset('images/' . $empresa->imagem) }}" type="image/png">
            <title>{{ $empresa->nome }}</title>
        @endif

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}" />

        <!-- Owl slider stylesheet -->
        <link rel="stylesheet" type="text/css" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css') }}" />

        <!-- Nice Select CSS -->
        <link rel="stylesheet" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css') }}" />

        <!-- Font Awesome CSS -->
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" />

        <!-- Custom styles for this template -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" />

        <!-- Responsive style -->
        <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" />


        @stack('css')
    </head>

    <body class="elegant-background">
        <div class="container">
            @php
                @session_start();
            @endphp

            @auth
                @include('layouts.header')
            @endauth

            @yield('content')

            <!-- jQery -->
            <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
            <!-- popper js -->
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
            </script>
            <!-- bootstrap js -->
            <script src="{{ asset('js/bootstrap.js') }}"></script>
            <!-- owl slider -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
            </script>
            <!-- isotope js -->
            <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
            <!-- nice select -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
            <!-- custom js -->
            <script>
                function toggleDivs() {
                    var freteSim = document.querySelector('input[name="frete"][value="S"]:checked');
                    var freteNao = document.querySelector('input[name="frete"][value="N"]:checked');
                    
                    var obsDiv = document.querySelector('.obsDiv');
                    var fretDiv = document.querySelector('.fretDiv');
                    var bairroDiv = document.querySelector('.bairroDiv');
                    
                    if (freteSim) {
                        obsDiv.style.display = 'none';
                        bairroDiv.style.display = 'block';
                        fretDiv.style.display = 'block';
                    } else if (freteNao) {
                        fretDiv.style.display = 'none';
                        bairroDiv.style.display = 'none';
                        obsDiv.style.display = 'block';
                    }
                }

                // Evento de 'blur' no campo CEP para preenchimento automático
                document.getElementById('cep').addEventListener('blur', function() {
                    let cep = this.value.replace(/\D/g, ''); // Remove caracteres não numéricos

                    if (cep.length !== 8) {
                        alert("Digite um CEP válido com 8 dígitos!");
                        return;
                    }

                    // URL da API ViaCEP
                    let url = `https://viacep.com.br/ws/${cep}/json/`;

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            if (data.erro) {
                                alert("CEP não encontrado.");
                                return;
                            }

                            // Preencher os campos automaticamente
                            document.getElementById('logradouro').value = data.logradouro || '';
                            document.getElementById('bairro').value = data.bairro || '';
                            document.getElementById('cidade').value = data.localidade || '';
                            document.getElementById('estado').value = data.uf || '';
                        })
                        .catch(error => console.error('Erro ao buscar CEP:', error));
                });

                
                function formatDateBR(data) {
                    // Extrai a data e a hora do valor
                    var partes = data.split('T');
                    var dataParte = partes[0]; // "2025-03-21"
                    var horaParte = partes[1]; // "16:03"

                    // Separa a data para pegar o dia, mês e ano
                    var dataArray = dataParte.split('-');
                    var dia = dataArray[2];
                    var mes = dataArray[1];
                    var ano = dataArray[0];

                    // Retorna no formato BR (dd/mm/yyyy - hh:mm)
                    return dia + '/' + mes + '/' + ano + ' - ' + horaParte;
                }
            </script>
            @stack('scripts')
        </div>
    </body>
    <footer class="footer_section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-col">
                    <div class="footer_contact">
                        <h4>
                            Contato
                        </h4>
                        <div class="contact_link_box">
                            <a href="">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <span>
                                    @if($empresa)
                                        {{ $empresa->telefone }}
                                    @endif
                                </span>
                            </a>
                            <a href="">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <span>
                                    @if($empresa)
                                        {{ $empresa->email }}
                                    @endif
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 footer-col">
                    <h4>
                        <a href="" class="footer-logo">
                            @if($empresa)
                                {{ $empresa->nome }}
                            @endif
                        </a>
                    </h4>
                    <p>
                        <div class="footer_social">
                            @if($empresa)
                                <a href="{{ $empresa->instagram }}">
                                    <i class="fa fa-instagram" aria-hidden="true"></i>
                                </a>
                            @endif
                        </div>
                    </p>
                </div>
                <div class="col-md-4 footer-col">
                    <h4>
                        Horário de Funcionamento
                    </h4>
                    <p>
                        @if($empresa)
                            {{ $empresa->dias }}
                        @endif
                    </p>
                    <p>
                        @if($empresa)
                            {{ $empresa->horario }}
                        @endif
                    </p>
                </div>
            </div>
            <div class="footer-info">
                <p>
                    <a href="#">&copy; 2023–2023 Grupo GRS Software, Inc.</a>
                </p>
            </div>
        </div>
    </footer>
</html>
