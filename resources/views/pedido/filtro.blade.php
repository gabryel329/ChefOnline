@extends('layouts.app')
<style>
.form-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Optional: Set a specific height to center vertically */
}
</style>
@section('content')
    <div class="form-container">

            <form action="/relatorio" method="post">
                @csrf
                <label for="data_inicial">Data Inicial:</label>
                <input class="form-control" type="date" name="data_inicial" required>

                <label for="data_final">Data Final:</label>
                <input class="form-control" type="date" name="data_final" required>

                <label for="status">Status:</label>
                <select class="form-control" name="status">
                    <option value="">Todos</option>
                    <option value="1">Em Andamento</option>
                    <option value="2">Feito</option>
                    <option value="3">Deletado</option>
                    <!-- Adicione mais opções conforme necessário -->
                </select>
                <br>
                <button class="btn btn-danger" type="submit">Gerar Relatório</button>
            </form>
    </div>
@endsection

