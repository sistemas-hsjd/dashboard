document.addEventListener('click', function (event) {
    if (event.target.closest('#enlace_logout')) {
        event.preventDefault();
        document.getElementById('logout-form')?.requestSubmit();
    }
});

document.addEventListener('change', function (event) {
    const input = event.target;
    if (input.matches('[data-layout-setting]')) {
        document.body.setAttribute(input.dataset.layoutSetting, input.dataset.layoutValue);
    }
});
