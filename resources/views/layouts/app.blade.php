<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ChefOnline</title>

    {{-- <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/carousel/">
    <link href="{{ asset('resources/css/carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        /* Estilo personalizado para os círculos vermelho e amarelo */
        .bg-red {
            background-color: #ff0000;
        }

        .bg-yellow {
            background-color: #ffcc00;
        }

        /* Degradê de vermelho para amarelo no header */
        .header-gradient {
            background: linear-gradient(to right, #ff0000, #ffcc00);
        }

        /* Estilos para o item do main */
        .main-item {
            color: black;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            text-align: center;
            margin-top: 100px;
        }

        .main-item svg {
            width: 400px;
            height: 400px;
        }

        .main-item h2 {
            margin-top: 30px;
            font-weight: bold;
            text-transform: uppercase;
            font-family: 'Ubuntu', sans-serif;
        }

        .main-item a.btn {
            background-color: #ff0000;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* .footer {
        text-align: center;
        padding: 20px 0;
        position: fixed;
        bottom: 0;
        width: 100%;
        background-color: #f8f9fa; Adicione uma cor de fundo ao footer
        } */
        /* Estilo personalizado para o dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            background-color: #ff0000;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 25px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #ffcc00;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            right: 0;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ff0000;
            color: white;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .elegant-background {
            background-color: #f0f0f0;
            position: relative;
        }
    </style>

    @stack('css')
</head>

<body class="elegant-background">

    @php
        @session_start();
    @endphp

    @auth
        @include('layouts.header')
    @endauth

    @yield('content')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
    @stack('scripts')
</body>

</html>
