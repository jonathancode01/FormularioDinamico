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
                            <select name="${campoNome}[resp]" id="${selectId}" class="form-control"></select>
                            <input type="hidden" name="${campoNome}[titulo]" value="${addTitulo}">
                            <input type="hidden" name="${campoNome}[tipo]" value="select">
                            <button type="button" class="btn btn-secondary mt-2" onclick="addOption('${selectId}', '${campoNome}')">Adicionar Opção</button>
                        </div>`;
            break;
    }

    formContent.append(contHtml);
    $('#btnOpcao').addClass('d-none');
}

function addOption(selectId, campoNome) {
    const optionText = prompt('Digite o texto: ');
    if (optionText) {
        $(`#${selectId}`).append(`<option value="${optionText}">${optionText}</option>`);
        // Adiciona um input hidden para enviar a opção com o formulário
        const inputHidden = document.createElement('input');
        inputHidden.type = 'hidden';
        inputHidden.name = `${campoNome}[options][]`;
        inputHidden.value = optionText;
        document.getElementById(selectId).parentNode.appendChild(inputHidden);
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

function procurar() {
    const search = document.getElementById('procurar').value;
    console.log("Procurando...", search);

    fetch('/search', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ search })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro na busca');
        }
        return response.json();
    })
    .then(data => {
        console.log(data);

        // Exibir os resultados
        const resultadosDiv = document.getElementById('resultados');
        resultadosDiv.innerHTML = '';

        if (data.formularios.length > 0) {
            const formulariosHeader = document.createElement('h3');
            formulariosHeader.textContent = 'Formulários:';
            resultadosDiv.appendChild(formulariosHeader);

            data.formularios.forEach(formulario => {
                const formularioDiv = document.createElement('div');0
                formularioDiv.textContent = `Título: ${formulario.titulo} `;
                resultadosDiv.appendChild(formularioDiv);
            });
        }

        if (data.campos.length > 0) {
            const camposHeader = document.createElement('h3');
            camposHeader.textContent = 'Campos:';
            resultadosDiv.appendChild(camposHeader);

            data.campos.forEach(campo => {
                const campoDiv = document.createElement('div');
                campoDiv.textContent = `Título: ${campo.titulo} `;
                resultadosDiv.appendChild(campoDiv);
            });
        }

        if (data.respostas.length > 0) {
            const respostasHeader = document.createElement('h3');
            respostasHeader.textContent = 'Respostas:';
            resultadosDiv.appendChild(respostasHeader);

            data.respostas.forEach(resposta => {
                const respostaDiv = document.createElement('div');
                respostaDiv.textContent = `Resposta: ${resposta.resp} `;
                resultadosDiv.appendChild(respostaDiv);
            });
        }

        if (data.campos.length === 0 && data.formularios.length === 0 && data.respostas.length === 0) {
            resultadosDiv.textContent = 'Nenhum resultado encontrado.';
        }
    })
    .catch(error => console.error('Erro:', error));
}

