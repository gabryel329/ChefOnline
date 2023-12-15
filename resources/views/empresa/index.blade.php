
@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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
      <h1>Dados da Empresa</h1>
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
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Crie os dados da Empresa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Adicione o formulário aqui -->
                                            <form method="POST" action="{{ route('empresa.store') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="inputText">Nome</label>
                                                                <input type="text" class="form-control" id="inputText" name="nome">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                            <label for="inputText">Imagem</label>
                                                                <input class="form-control" type="file" name="imagem">
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
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Codigo</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Logo</th>
                                    <th scope="col">Excluir</th>
                                    <th scope="col">Detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($empresas as $empresa)

                                    <tr>
                                        <td scope="row">{{ $empresa->id }}</td>
                                        <td>{{ $empresa->nome }}</td>
                                        <td>{{ $empresa->imagem }}</td>
                                        <td>
                                            <form action="{{ route('empresa.destroy', $empresa->id) }}" method="post"
                                                class="ms-2">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger">Excluir</button>

                                            </form>
                                        </td>
                                        <td>
                                            <div>
                                                <!-- Botão de edição que abre o modal -->
                                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $empresa->id }}">
                                                    Editar
                                                </button>
                                            </div>

                                            <!-- Modal de edição para cada investimento -->
                                            <div class="modal fade" id="editModal{{ $empresa->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Editar Dados da Empresa</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Formulário de edição para este tipoProd -->
                                                            <form method="POST" action="{{ route('empresa.update', ['id' => $empresa->id]) }}" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="inputText">Nome</label>
                                                                                <input type="text" class="form-control" id="inputText" name="nome" value="{{ $empresa->nome }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="inputText">Imagem</label>
                                                                                <input type="file" class="form-control" id="inputText" name="imagem" value="{{ $empresa->imagem }}">
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
                                        <p class="alert-warning" style="font-size:22px; text-align:center;">Nenhum Dados da Empresa Cadastrado</p>

                                    </tr>

                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
<script>
    function formatarPreco() {
      var precoInput = document.getElementById('preco');
      var precoValue = precoInput.value;

      // Remover espaços em branco e substituir vírgulas por pontos
      precoValue = precoValue.replace(/\s/g, '').replace('.', ',');

      // Converter para número com duas casas decimais
      precoValue = parseFloat(precoValue).toFixed(2);

      // Atualizar o valor no input
      precoInput.value = precoValue;
    }

    function formatarPreco2() {
      var precoInput = document.getElementById('preco2');
      var precoValue = precoInput.value;

      // Remover espaços em branco e substituir vírgulas por pontos
      precoValue = precoValue.replace(/\s/g, '').replace('.', ',');

      // Converter para número com duas casas decimais
      precoValue = parseFloat(precoValue).toFixed(2);

      // Atualizar o valor no input
      precoInput.value = precoValue;
    }
</script>
@endsection
