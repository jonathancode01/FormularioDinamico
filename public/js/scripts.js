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
            contHtml = `<div class="mb-3" data-titulo="${addTitulo}">
                            <label for="${campoNome}" class="form-label">${addTitulo}</label>
                            <input type="text" name="${campoNome}" id="${campoNome}" class="form-control">
                        </div>`;
            break;
        case 'textoarea':
            contHtml = `<div class="mb-3" data-titulo="${addTitulo}">
                            <label for="${campoNome}" class="form-label">${addTitulo}</label>
                            <textarea name="${campoNome}" id="${campoNome}" class="form-control" rows="3"></textarea>
                        </div>`;
            break;
        case 'multiplo':
            const checkboxes = prompt('Digite os itens do checkbox separados por vírgula').split(',').map(item => item.trim());
            contHtml = `<div class="mb-3" data-titulo="${addTitulo}">
                            <label class="form-label">${addTitulo}</label>
                            <div class="checkbox-container">
                            ${checkboxes.map((item, index) => `
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="${campoNome}[]" value="${item}" id="${campoNome}_checkbox${index}">
                                    <label for="${campoNome}_checkbox${index}" class="form-check-label">${item}</label>
                                </div>`).join('')}
                            </div>
                            <button type="button" class="btn btn-primary mt-2" onclick="addCheckbox('${campoNome}')">Adicionar Opção</button>
                        </div>`;
            break;
    }

    formContent.append(contHtml);
    $('#btnOpcao').addClass('d-none');
}

$('#cadastroForm').submit(function(e){
    e.preventDefault();

    var url = $(this).attr('action');
    let formData = new FormData(this);

    $('#formContent .mb-3').each(function(index, element) {
        let titulo = $(element).data('titulo');
        if (titulo) {
            let type = $(element).find('input[type="text"]').length ? 'texto' : ($(element).find('textarea').length ? 'textoarea' : 'multiplo');
            formData.append(`campos[${index}][titulo]`, titulo);
            formData.append(`campos[${index}][tipo]`, type);

            if (type === 'multiplo') {
                const hiddenInput = $(element).find('input[type="hidden"]').val();
                if (hiddenInput) {
                    try {
                        const opcoes = JSON.parse(hiddenInput);
                        opcoes.forEach(opcao => {
                            formData.append(`campos[${index}][opcoes][]`, opcao);
                        });
                    } catch (e) {
                        console.error('Error parsing JSON:', e);
                    }
                } else {
                    console.warn('Hidden input value is empty or undefined for multiplo type');
                }
            }
        }
    });

    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response);
            window.location.href = `/formularios/${response.message}`;
        },
        error: function(response) {
            console.log(response);
        }
    });
});

// Adiciona um novo checkbox ao grupo existente
function addCheckbox(contNome) {
    const container = $(`[name="${contNome}[]"]`).closest('.mb-3');
    const lastCheckbox = container.find('.form-check:last-child');
    const lastCheckboxIndex = lastCheckbox.index();
    const newIndex = lastCheckboxIndex + 1;
    const checkboxId = `${contNome}_checkbox${newIndex}`;
    const newCheckboxHtml = `
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="${contNome}[]" id="${checkboxId}" value="Opção ${newIndex}">
            <label for="${checkboxId}" class="form-check-label">Opção ${newIndex}</label>
        </div>
    `;

    container.find('.checkbox-container').append(newCheckboxHtml);
}
