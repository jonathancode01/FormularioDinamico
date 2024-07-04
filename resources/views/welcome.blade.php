<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Form John</title>
</head>
<body>
    <header class="cabeca">
        <h1>Jonathan Dev</h1>
    </header>

    <main class="corpo">
        <div class="container">
            <form id="cadastroForm" action="{{ route('formularios') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título do Formulário</label>
                    <input type="text" name="titulo" id="titulo" class="form-control" required>
                </div>
                <div id="formContent"></div>
                <button type="button" class="btn btn-primary" onclick="addCampo('texto')">Paragrafo curto</button>
                <button type="button" class="btn btn-primary" onclick="addCampo('textoarea')">Paragrafo</button>
                <button type="button" class="btn btn-primary" onclick="addCampo('select')">Lista Suspensa</button>
                <button type="submit" class="btn btn-success mt-3">Salvar Formulário</button>
            </form>

        </div>
    </main>
    <footer class="rodape mt-5">
        Copyright © Jonathan Dev
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/scripts.js"></script>
</body>
</html>
