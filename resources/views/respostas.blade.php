<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/form.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Respostas do Formulário</title>
</head>
<body>

<header class="cabeca">Jonathan Dev</header>
<main class="corpo">

    <!-- Seção para exibir as respostas -->
    <div id="respostas">
        <h3>{{ $formulario->titulo }}</h3>
        <h3>Respostas do Formulário</h3>
        @if($campos->isNotEmpty())
            @foreach ($campos as $campo)
                <div class="resposta">
                    <p><strong>{{ $campo->titulo }}:</strong>
                        @php
                            // Encontre a resposta correspondente para o campo
                            $resposta = $respostas->firstWhere('campo_id', $campo->id);
                        @endphp
                        {{ $resposta ? $resposta->resp : 'Nenhuma resposta' }}
                    </p>
                </div>
            @endforeach
        @else
            <p>Nenhuma resposta enviada ainda.</p>
        @endif
    </div>

</main>

<footer class="rodape">Copy</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5pNlyT2bRjXhW+ALEwIH" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../js/form.js"></script>
</body>
</html>
