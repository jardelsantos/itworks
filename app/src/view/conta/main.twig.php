{% extends 'partials/template.twig.php'  %}

{% block title %} CONTA EXTRATO {% endblock %}

{% block body %}

    <h1>Conta > Extrato</h1>

    <a href="{{BASE}}novo" class="btn btn-info btn-sm">Novo Registro</a>
    
    <hr/>
    
    <table class="table">
        {% for item in listaExtrato %}
            <tr>
                <td>{{ item.id }}</td>
                <td>{{ item.valor }}</td>
                <td>{{ item.movimentacao }}</td>
                <td>{{ item.dataRegistro }}</td>
            </tr>
        {% endfor %}
    </table>
{% endblock %}