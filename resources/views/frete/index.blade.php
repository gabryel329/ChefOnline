@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous" defer></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
@section('content')
<style>
    #botao-canto-superior-direito {
    position: fixed;
    top: 10px; /* Distância do topo */
    right: 10px; /* Distância da direita */
    padding: 10px;
    background-color: #e25a5a; /* Cor de fundo */
    color: #fff; /* Cor do texto */
    border: none;
    cursor: pointer;
    border-radius: 10%;
}
</style>
<main id="main" class="main">
    <a href="/pedidos" id="botao-canto-superior-direito" class="btn btn-secondary">Voltar</a>
    <div class="pagetitle">
      <h1>Dados do Frete</h1>
    </div><!-- End Page Title -->
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
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <br>
                        <div>
                            <!-- Small Modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#smallModal">
                                Novo
                            </button>

                            <div class="modal fade" id="smallModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Crie os dados do Frete</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Adicione o formulário aqui -->
                                            <form method="POST" action="{{ route('frete.store') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="">Bairro</label>
                                                                <input type="text" class="form-control" id="" name="bairro">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="valor">Valor</label>
                                                                <input class="form-control" type="text" name="valor" id="valor" oninput="formatarPreco(this)" placeholder="0,00">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Codigo</th>
                                        <th scope="col">Bairro</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Excluir</th>
                                        <th scope="col">Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($fretes as $frete)

                                        <tr>
                                            <td scope="row">{{ $frete->id }}</td>
                                            <td>{{ $frete->bairro }}</td>
                                            <td>R${{ $frete->valor }}</td>
                                            <td>
                                                <form action="{{ route('frete.destroy', $frete->id) }}" method="post"
                                                    class="ms-2">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger">Excluir</button>

                                                </form>
                                            </td>
                                            <td>
                                                <div>
                                                    <!-- Botão de edição que abre o modal -->
                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $frete->id }}">
                                                        Editar
                                                    </button>
                                                </div>

                                                <!-- Modal de edição para cada investimento -->
                                                <div class="modal fade" id="editModal{{ $frete->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Editar Dados da Frete</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Formulário de edição para este tipoProd -->
                                                                <form method="POST" action="{{ route('frete.update', ['id' => $frete->id]) }}" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="col-md-12">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="">Bairro</label>
                                                                                    <input type="text" class="form-control" id="" name="bairro" value="{{ $frete->bairro }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="">Valor</label>
                                                                                    <input class="form-control" type="text" name="valor" id="valor" oninput="formatarPreco(this)"value="{{ $frete->valor }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Fim do modal de edição -->
                                            </td>
                                        @empty
                                            <p class="alert-warning" style="font-size:22px; text-align:center;">Nenhum Dados da Frete Cadastrado</p>

                                        </tr>

                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Aplica a formatação ao abrir o modal
    $('#smallModal').on('shown.bs.modal', function () {
        let input = document.querySelector('#valor');
        if (input) {
            input.addEventListener('input', function() {
                formatarPreco(this);
            });
        }
    });
});

function formatarPreco(input) {
    // Remove tudo que não for número
    let precoValue = input.value.replace(/\D/g, '');

    // Remove zeros à esquerda
    precoValue = precoValue.replace(/^0+/, '');

    // Se o valor for vazio, define como "0"
    if (precoValue === '') precoValue = '0';

    // Garante pelo menos dois dígitos para centavos
    if (precoValue.length < 3) {
        precoValue = precoValue.padStart(3, '0');
    }

    // Divide o valor principal e os centavos
    let inteiro = precoValue.slice(0, -2);
    let centavos = precoValue.slice(-2);

    // Formata o número corretamente
    let precoFormatado = `${inteiro},${centavos}`;

    // Atualiza o valor no input
    input.value = precoFormatado;
}
</script>
@endsection
