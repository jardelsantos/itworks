<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link rel="stylesheet" href="{{BASE}}assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="{{BASE}}assets/css/stylesheet.css" />
        <script src="{{BASE}}assets/js/bootstrap.min.js"></script>
        <title>
            {% block title %}{% endblock %}
        </title>
    </head>
    <body>
        {% include 'partials/header.twig.php' %}

        <main class="container-fluid">
            {% block body %}{% endblock %}
        </main>

        {% include 'partials/footer.twig.php' %}
    </body>
</html>