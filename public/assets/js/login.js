$(document).ready(function() {
    $('#password-addon').on('click', function() {
        const input = $('#password');
        const type = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr('type', type);

        // Cambiar el texto del botón
        // $(this).text(type === 'password' ? '👁️ Ver' : 'Ocultar');
    });
});


function formatearRutSoloGuion(input) {
  let rut = input.value || '';
  rut = rut.replace(/[^0-9kK]/g, '').toUpperCase();
  if (rut.length < 2) {
    input.value = rut;
    return;
  }

  const cuerpo = rut.slice(0, -1);
  const dv = rut.slice(-1);

  input.value = `${cuerpo}-${dv}`;
}