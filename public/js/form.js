$(document).ready(function() {
    // Fazendo a requisição AJAX
    $.ajax({
        url: `/formularios/1`, // Corrija a URL para apontar para o endpoint correto
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            // Manipulando a resposta para gerar os elementos HTML
            response.forEach(function(campo) {
                let html = '';
                switch (campo.tipo) {
                    case 'texto':
                        html = `<div class="mb-3">
                                    <label for="${campo.nome}" class="form-label">${campo.titulo}</label>
                                    <input type="text" name="${campo.nome}" id="${campo.nome}" class="form-control">
                                </div>`;
                        break;
                    case 'textoarea':
                        html = `<div class="mb-3">
                                    <label for="${campo.nome}" class="form-label">${campo.titulo}</label>
                                    <textarea name="${campo.nome}" id="${campo.nome}" class="form-control" rows="3"></textarea>
                                </div>`;
                        break;
                    case 'checkbox':
                        html = `<div class="mb-3">
                                    <label class="form-label">${campo.titulo}</label>
                                    <div class="checkbox-container">
                                        <!-- Aqui você pode adicionar os checkboxes dinamicamente -->
                                    </div>
                                </div>`;
                        break;
                    // Adicione outros tipos de campo conforme necessário
                }
                $('#formContent').append(html);
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});
