$(document).ready(function() {
    $('#btnOpcao').click(function() {
        $('#contCheck').toggleClass('d-none');
    });
});

let contCampo = 0; // Contador de campos

function addCampo(type) {
    const formContent = $('#formContent');
    contCampo++;

    let contHtml = '';
    const addTitulo = prompt('Adicione um título para o novo campo: ');

    if (!addTitulo) return;

    const campoNome = `campos[${contCampo}][${type}]`;

    switch (type) {
        case 'texto':
            contHtml = `<div class="mb-3" data-titulo="${addTitulo}" data-order="${contCampo}">
                            <label for="${campoNome}" class="form-label">${addTitulo}</label>
                            <input type="text" name="${campoNome}" id="${campoNome}" class="form-control">
                        </div>`;
            break;
        case 'textoarea':
            contHtml = `<div class="mb-3" data-titulo="${addTitulo}" data-order="${contCampo}">
                            <label for="${campoNome}" class="form-label">${addTitulo}</label>
                            <textarea name="${campoNome}" id="${campoNome}" class="form-control" rows="3"></textarea>
                        </div>`;
            break;
        case 'select':
            const selectId = `select_${contCampo}`;
            contHtml = `<div class="mb-3" data-titulo="${addTitulo}" data-order="${contCampo}">
                            <label for="${selectId}" class="form-label">${addTitulo}</label>
                            <select name="${campoNome}" id="${selectId}" class="form-control">

                            </select>
                            <button type="button" class="btn btn-secondary mt-2" onclick="addOption('${selectId}')">Adicionar Opção</button>
                        </div>`;
            break;
    }

    formContent.append(contHtml);
    $('#btnOpcao').addClass('d-none');
}

function addOption(selectId) {
    const optionText = prompt('Digite o texto: ');
    if (optionText) {
        $(`#${selectId}`).append(`<option value="${optionText}">${optionText}</option>`);
    }
}

$('#cadastroForm').submit(function(e) {
    e.preventDefault();

    var url = $(this).attr('action');
    let formData = new FormData(this);

    // Coleta os campos e ordena por data-order
    let fields = $('#formContent .mb-3').toArray();
    fields.sort((a, b) => {
        return $(a).data('order') - $(b).data('order');
    });

    console.log(formData);
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response);
            if (response && response.message) {
                window.location.href = `/formularios/${response.message}`;
            } else {
                console.error('Resposta inválida do servidor.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Erro na requisição:', error);
            console.log(xhr.responseText);
        }

    });
});

