{% extends 'partials/template.twig.php' %}

{% block title %}Novo Registro{% endblock %}

{% block body %}
<h1>Novo Registro</h1>

<hr/>

<form action="{{BASE}}conta-salvar" method="post">
    <div class="mt-3">
        <label for="txtValor" class="form-label">Valor</label>
        <input type="text" id="txtValor" name="txtValor" class="form-control" placeholder="Valor" required />
    </div>
    <div class="mt-3">
        <label for="selMovimentacao" class="form-label">Movimentação</label>
        <select id="selMovimentacao" name="selMovimentacao" class="form-control">
            <option value="">Selecione</option>
            <option value="CREDITO">Crédito</option>
            <option value="DEDITO">Débito</option>
        </select>
    </div>
    <div class="mt-3 text-right">
        <button type="submit" class="btn btn-success">Salvar</button>
    </div>
</form>

{% endblock %}
