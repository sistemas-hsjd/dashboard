(() => {
    const form = document.getElementById('clinical-login-form');
    if (!form) return;
    let pending = false;
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        if (pending) return;
        pending = true;
        const button = form.querySelector('button[type="submit"]');
        const message = document.getElementById('login-location-status');
        button.disabled = true;
        const finish = (status, coords) => {
            form.elements.location_status.value = status;
            if (coords) {
                form.elements.latitude.value = coords.latitude;
                form.elements.longitude.value = coords.longitude;
                form.elements.accuracy_meters.value = coords.accuracy;
            }
            HTMLFormElement.prototype.submit.call(form);
        };
        if (!window.isSecureContext) return finish('insecure');
        if (!navigator.geolocation) return finish('unsupported');
        message.textContent = 'Solicitando ubicación al navegador...';
        let finished = false;
        const complete = (status, coords) => {
            if (finished) return;
            finished = true;
            clearTimeout(deadline);
            finish(status, coords);
        };
        // A permission prompt may otherwise remain pending indefinitely.
        const deadline = setTimeout(() => complete('timeout'), 10000);
        try {
            navigator.geolocation.getCurrentPosition(
                position => complete('success', position.coords),
                error => complete(({1: 'denied', 2: 'unavailable', 3: 'timeout'})[error.code] || 'unavailable'),
                { enableHighAccuracy: false, timeout: 8000, maximumAge: 0 }
            );
        } catch {
            complete('unavailable');
        }
    });
})();
