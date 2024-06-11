$(document).ready(function() {
    $('#btnOpcao').click(function() {
        $('#contCheck').toggleClass('d-none');
    });
});

let contCampo = 0; // Contador de campos

function addCampo(type) {
    const formContent = $('#formContent'); // obtém o elemento do formulário pelo ID 'formContent'

    contCampo++; // incrementa o contador de campos

    let contHtml = ''; // variável para armazenar o HTML do novo campo

    const addTitulo = prompt('Adicione um título para o novo campo: '); // solicita ao usuário um título para o campo

    if (!addTitulo) return; // se o campo estiver vazio, encerra a função

    const campoNome = `campos[${contCampo}][${type}]`; // cria um nome único para o campo

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

            contHtml = `<div class="mb-3" data-titulo="${addTitulo}">
            <label class="form-label">${addTitulo}</label>
            <div class="checkbox-container">
            ${checkboxes.map((item, index) => `
                <div class="form-check">
                <input class="form-check-input" type="checkbox" name="${campoNome}[]" value="${item}" id="${campoNome}_checkbox${index}">
                <label for="${campoNome}_checkbox${index}" class="form-check-label">${item}</label>
                </div>`).join('')}
                </div>
                <button type="button" class="btn btn-primary mt-2" onclick="addCheckbox(this, '${campoNome}')">Adicionar Opção</button>
                </div>`;
                const checkboxes = prompt('Digite os itens do checkbox separados por vírgula').split(',').map(item => item.trim());
            break;
    }

    formContent.append(contHtml); // adiciona o HTML do novo campo ao elemento 'formContent'
    $('#btnOpcao').addClass('d-none'); // esconde o botão 'Escolha a opção'
}

$('#cadastroForm').submit(function(e){
    e.preventDefault();

    var url = $(this).attr('action');
    let formData = new FormData(this);

     // Adiciona os títulos ao formData na ordem desejada
    $('#formContent .mb-3').each(function(index, element) {
    let titulo = $(element).data('titulo');
    if (titulo) {
        let type = $(element).find('input[type="text"]').length ? 'texto' : ($(element).find('textarea').length ? 'textoarea' : 'multiplo');
        formData.append(`campos[${type}_${index}][titulo]`, titulo);
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
            window.location.href = `/formularios/form/${response.message}`;
        },
        error: function(response) {
            console.log(response);
        }
    });
});

// Adiciona um novo checkbox ao grupo existente
function addCheckbox(button, contNome) {
    const container = $(button).closest('.mb-3');
    const lastCheckbox = container.find('.form-check:last-child');
    const lastCheckboxIndex = lastCheckbox.index();
    const newIndex = lastCheckboxIndex + 1;
    const checkboxId = `${contNome}_checkbox${newIndex}`;
    const newCheckboxLabel = `<input type="text" class="form-check-label form-control" placeholder="Opção ${newIndex}">`;

    const newCheckboxHtml = `
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="${contNome}[]" id="${checkboxId}">
            ${newCheckboxLabel}
        </div>
    `;

    container.find('.checkbox-container').append(newCheckboxHtml);
}
