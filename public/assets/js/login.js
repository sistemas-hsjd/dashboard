$(document).ready(function() {
    $('#password-addon').on('click', function() {
        const input = $('#password');
        const type = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr('type', type);

        // Cambiar el texto del botón
        // $(this).text(type === 'password' ? '👁️ Ver' : 'Ocultar');
    });
});