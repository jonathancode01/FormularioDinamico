<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/form.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Formularios</title>
</head>
<body>

<header class="cabeca">Jonathan Dev</header>
<main class="corpo">
    <form id="forme" method="POST" action="/formularios/id">
        @csrf
        <h3>{{$formularios->titulo}}</h3>
        @foreach ($campoFormulario as $index => $campo)
        <p>{{$campo->titulo}}</p>
        {{-- <input type="hidden" name="formulario_id" value="{{$formularios->id}}"> <!-- ID do formulário --> --}}
            <?php if ($campo->tipo === 'texto'): ?>
                <input type="text" name="campos[{{$index}}][resp]" id="{{$campo->nome}}">
                <input type="hidden" name="campos[{{$index}}][tipo]" value="texto">
            <?php elseif ($campo->tipo === 'textoarea'): ?>
                <textarea name="campos[{{$index}}][resp]" id="{{$campo->nome}}"></textarea>
                <input type="hidden" name="campos[{{$index}}][tipo]" value="textoarea">
            <?php endif; ?>
        @endforeach
        <button id="btnOK" type="submit">Enviar</button>
    </form>
</main>

<footer class="rodape">Copy</footer>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/form.js"></script>
</body>
</html>
