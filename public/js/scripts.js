$(document).ready(function() {
    $('#btnOpcao').click(function() {
        $('#contCheck').toggleClass('d-none');
    });

    $('#cadastroForm').submit(function(e){
        e.preventDefault();

        var url = $(this).attr('action');

        // Cria uma instância do FormData com o formulário atual
        let formData = new FormData(this);

        // Adiciona o token CSRF ao formData (opcional se já estiver incluído)
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log(data);
                window.location.href = '/formularios';
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
});


        let contCampo = 0; // Contador de campos

    function addCampo(type, label) {
        const formContent = $('#formContent'); // obtem o elemento do formulário pelo ID 'formContent'

        let contHtml = ''; // variável para armazenar o HTML do novo campo

        const addTitulo = prompt('Adicione um novo campo: ', label); // solicita ao usuario um titulo para o campo

        if (!addTitulo) return; // se o campo estiver vazio, encerra a função

        contCampo++; // incrementa o contador de campos

        const contNome = `${type}${contCampo}`; // cria um nome unico para o campo
        const contTexto = `${type}_texto${contCampo}`; //
        const contMultiplo = `${type}_multiplo${contCampo}`;

        switch (type) {
            case 'texto':
                contHtml = `<div class="mb-3">
                                <label for="${contNome}" class="form-label">${addTitulo}</label>
                                <input type="text" name="${contNome}" id="${contNome}" class="form-control">
                            </div>`;
                break;
            case 'textoarea':
                contHtml = `<div class="mb-3">
                                <label for="${contNome}" class="form-label">${addTitulo}</label>
                                <textarea name="${contTexto}" id="${contTexto}" class="form-control" rows="3"></textarea>
                            </div>`;
                break;
                case 'multiplo':
                    const checkboxes = prompt('Digite os itens do checkbox separados por vírgula').split(',').map(item => item.trim());

                    contHtml = `<div class="mb-3">
                                    <label class="form-label">${addTitulo}</label>
                                    <div class="checkbox-container">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="${contMultiplo}" id="${contMultiplo}">
                                        <input type="text" class="form-check-label form-control" placeholder="Opção 1">
                                        </div>
                                        </div>
                                        <button type="button" class="btn btn-primary mt-02" onclick="addCheckbox(this, ${contMultiplo})">Adicionar Opção</button>
                                        </div>
                                        `;
                    break;
    }

    formContent.append(contHtml); // adiciona o HTML do novo campo ao elemento 'formContent'
    $('#btnOpcao').addClass('d-none'); // esconde o botão 'Escolha a opção'

}
// Adiciona um novo checkbox ao grupo existente
function addCheckbox(button, contNome) {
    const container = $(button).closest('.mb-3');
    const lastCheckbox = container.find('.form-check:last-child');
    const lastCheckboxIndex = lastCheckbox.index();
    const newIndex = lastCheckboxIndex + 2;
    const checkboxId = `${contNome}_checkbox${newIndex}`;
    const newCheckboxLabel = `<input type="text" class="form-check-label form-control" placeholder="Opção ${newIndex}">`;

    const newCheckboxHtml = `
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="${contNome}" id="${checkboxId}">
            ${newCheckboxLabel}
        </div>
    `;

    container.find('.checkbox-container').append(newCheckboxHtml);
}


