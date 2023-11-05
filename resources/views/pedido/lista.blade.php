@extends('layouts.app')

@section('content')
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-warning">
    {{ session('error') }}
</div>
@endif
<section class="food_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2><img style="width: 40%; height: 30%; margin-top: -10%" src="{{ asset('images/logo1.png') }}"></h2>
        </div>
        <div class="row filters_menu">
            <div class="col-md-12">
                <div class="btn-group filters_menu" role="group" aria-label="Filtrar por status">
                    @foreach ($statuses as $status)
                        <a href="{{ route('pedidos.lista', ['status' => $status->id]) }}" class="btn btn-secondary mr-2">{{ $status->nome }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($pedidos as $pedido)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            Pedido #{{ $pedido->id }}
                        </div>
                        <div class="card-body">
                            <ul>
                                @foreach ($pedido->produtos as $produto)
                                    <li>{{ $produto->nome }} - Quantidade: {{ $produto->pivot->quantidade }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="card-footer">
                            <form action="{{ route('pedido.updateLista', $pedido->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="status_id">Status do Pedido:</label>
                                    <select name="status_id" class="form-control" id="status_id">
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}" {{ $pedido->status_id === $status->id ? 'selected' : '' }}>
                                                {{ $status->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Atualizar Pedido</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
