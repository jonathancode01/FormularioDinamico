$(document).ready(function() {
    function fetchFormularios() {
        $.ajax({
            url: "/formularios",
            method: 'GET',
            success: function(response) {

                console.log(response);


            },
            error: function(xhr, status, error) {
                console.error('Erro ao buscar os formulários:', error);
            }
        });
    }

    fetchFormularios();
});
