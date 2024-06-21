<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/form.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Visualizar Formulário</title>
</head>
<body>

<header class="cabeca">Jonathan Dev</header>

<main class="corpo">
    <form id="forme">
        @csrf
        <form id="forme">
            <h3>{{$formulario->titulo}}</h3>

            @csrf
            @foreach ($campoFormulario as $campo)

            <label for="{{$campo->titulo}}">{{$campo->titulo}}</label>
            if ($campo->tipo === 'texto')
                <input type="text" class="form-control" name="{{$campo->tipo}}">



            @endforeach
        </form>
    </form>
</main>

<footer class="rodape">Copy</footer>

</body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../js/form.js"></script>
</body>
</html>
