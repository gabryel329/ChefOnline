
@extends('layouts.app')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
@section('content')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Lista de Produtos</h1>
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
                                            <h5 class="modal-title">Crie um novo Produto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Adicione o formulário aqui -->
                                            <form method="POST" action="{{ route('produtos.store') }}" enctype="multipart/form-data">
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
                                                                <label for="inputText">Tipo</label>
                                                                <select class="form-control" id="tipo" name="tipo">
                                                                    <option disabled selected required>Escolha
                                                                    </option>
                                                                    <option value="1">Salgado</option>
                                                                    <option value="2">Bebida</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="inputText">Preço</label>
                                                                <input type="text" class="form-control" id="inputText" name="preco">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                            <label for="inputText">Imagem</label>
                                                                <input class="form-control" type="file" name="imagem">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="inputText">Descrição</label>
                                                                <input type="text" class="form-control" id="inputText" name="descricao">
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
                                    <th scope="col">Preço</th>
                                    <th scope="col">Descrição</th>
                                    <th scope="col">Excluir</th>
                                    <th scope="col">Detalhes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produtos as $produto)

                                    <tr>
                                        <td scope="row">{{ $produto->id }}</td>
                                        <td>{{ $produto->nome }}</td>
                                        <td>R${{ $produto->preco }},00</td>
                                        <td>{{ $produto->descricao }}</td>
                                        <td>
                                            <form action="{{ route('produtos.destroy', $produto->id) }}" method="post"
                                                class="ms-2">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger">Excluir</button>

                                            </form>
                                        </td>
                                        <td>
                                            <div>
                                                <!-- Botão de edição que abre o modal -->
                                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $produto->id }}">
                                                    Editar
                                                </button>
                                            </div>

                                            <!-- Modal de edição para cada investimento -->
                                            <div class="modal fade" id="editModal{{ $produto->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Editar produto</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <!-- Formulário de edição para este produto -->
                                                            <form method="POST" action="{{ route('produtos.update', ['id' => $produto->id]) }}" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="col-md-12">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="inputText">Nome</label>
                                                                                <input type="text" class="form-control" id="inputText" name="nome" value="{{ $produto->nome }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="inputText">Preço</label>
                                                                                <input type="text" class="form-control" id="inputText" name="preco" value="{{ $produto->preco }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="inputText">Imagem</label>
                                                                                <input type="file" class="form-control" id="inputText" name="imagem" value="{{ $produto->imagem }}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="inputText">Descrição</label>
                                                                                <input type="text" class="form-control" id="inputText" name="descricao" value="{{ $produto->descricao }}">
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
                                        <p class="alert-warning" style="font-size:22px; text-align:center;">Nenhum Tipo de Produto Cadastrado</p>

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
@endsection
