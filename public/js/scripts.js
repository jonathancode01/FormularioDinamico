$(document).ready(function() {
    $('#btnOpcao').click(function() {
        $('#contCheck').toggleClass('d-none');
    });
});

let contCampo = 0; // Contador de campos

function addCampo(type) {
    const formContent = $('#formContent');
    contCampo++;

    const addTitulo = prompt('Adicione um título para o novo campo: ');

    if (!addTitulo) return;

    const campoNome = `campos[${contCampo}]`;

    let contHtml = '';

    switch (type) {
        case 'texto':
            contHtml = `<div class="mb-3" data-titulo="${addTitulo}" data-order="${contCampo}">
                            <label for="${campoNome}_titulo" class="form-label">${addTitulo}</label>
                            <input type="text" name="${campoNome}[resp]" id="${campoNome}_resp" class="form-control" nullable>
                            <input type="hidden" name="${campoNome}[titulo]" value="${addTitulo}">
                            <input type="hidden" name="${campoNome}[tipo]" value="texto">
                        </div>`;
            break;
        case 'textoarea':
            contHtml = `<div class="mb-3" data-titulo="${addTitulo}" data-order="${contCampo}">
                            <label for="${campoNome}_titulo" class="form-label">${addTitulo}</label>
                            <textarea name="${campoNome}[resp]" id="${campoNome}_resp" class="form-control" rows="3" nullable></textarea>
                            <input type="hidden" name="${campoNome}[titulo]" value="${addTitulo}">
                            <input type="hidden" name="${campoNome}[tipo]" value="textoarea">
                        </div>`;
            break;

        case 'select':
            const selectId = `select_${contCampo}`;
            contHtml = `<div class="mb-3" data-titulo="${addTitulo}" data-order="${contCampo}">
                            <label for="${selectId}" class="form-label">${addTitulo}</label>
                            <select name="${campoNome}[resp]" id="${selectId}" class="form-control" ></select>
                            <input type="hidden" name="${campoNome}[titulo]" value="${addTitulo}">
                            <input type="hidden" name="${campoNome}[tipo]" value="select">
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

    const url = $(this).attr('action');
    const formData = new FormData(this);
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    formData.append('_token', csrfToken);

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            console.log(response);
            if (response && response.message) {
                window.location.href = `/formularios/${response.message}`;
            } else {
                console.error('Resposta inválida do servidor.');
            }
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText); // Exibir resposta de erro detalhada
            alert(`Erro: ${xhr.responseText}`); // Alerta com a mensagem de erro
        }
    });
});
