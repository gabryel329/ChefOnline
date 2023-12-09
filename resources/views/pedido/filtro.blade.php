<!-- Formulário para seleção de datas -->
<form action="/relatorio" method="post">
    @csrf
    <label for="data_inicial">Data Inicial:</label>
    <input type="date" name="data_inicial" required>

    <label for="data_final">Data Final:</label>
    <input type="date" name="data_final" required>

    <label for="status">Status:</label>
    <select name="status">
        <option value="">Todos</option>
        <option value="1">Em Andamento</option>
        <option value="2">Feito</option>
        <option value="3">Deletado</option>
        <!-- Adicione mais opções conforme necessário -->
    </select>

    <button type="submit">Gerar Relatório</button>
</form>
