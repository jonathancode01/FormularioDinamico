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
        <h1>Form John</h1>
    </main>
    <div class="container">
        <h1>Forms Johnson & Johnsons</h1>
        <form id="cadastroForm" action="/formularios" method="POST">
            @csrf
            <div class="mb-3">
                <label for="formTitle" class="form-label">Título do formulário</label>
                <input type="text" name="titulo" id="formTitle" class="form-control" required>
            </div>
            <button type="button" id="btnOpcao" class="btn btn-primary">Escolha a opção</button>
            <div id="contCheck" class="mt-3 d-none">
                <button type="button" class="btn btn-secondary mb-2" onclick="addCampo('texto', 'Título do campo')">Texto Pequeno</button>
                <button type="button" class="btn btn-secondary mb-2" onclick="addCampo('textoarea', 'Título do campo')">Texto Grande</button>
                <button type="button" class="btn btn-secondary mb-2" onclick="addCampo('multiplo', 'Título do campo')">Checkbox</button>
            </div>
            <div id="formContent" class="mt-3"></div>
            <input type="submit" value="Enviar" class="btn btn-primary">
        </form>
    </div>

    <footer class="rodape mt-5">
        Copyright © Jonathan Dev
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script src="./js/scripts.js"></script>
</body>
</html>
