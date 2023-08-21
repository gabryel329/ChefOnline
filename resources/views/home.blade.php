@extends('layouts.app')

@section('content')
<div class="main-item">
    <div class="container marketing">
      <div class="row justify-content-center main-item">
        <div class="col-lg-6">
          <svg class="bd-placeholder-img rounded-circle bg-red" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 140x140" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#ff0000"/><text x="50%" y="50%" fill="#fff" dy=".3em">140x140</text></svg>
          <h2 style="font-family: 'Ubuntu', sans-serif; text-transform: uppercase; font-weight: bold;">Faça seu Pedido</h2>
          <p><a class="btn btn-secondary btn-lg" href="{{ route('pedidos.create') }}" style="background-color: #ff0000;">PEÇA JÁ!</a></p>
        </div>
      </div>
    </div>
</main>
@endsection
