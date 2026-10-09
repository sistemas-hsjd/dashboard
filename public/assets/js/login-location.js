(() => {
    const form = document.getElementById('clinical-login-form');
    if (!form) return;
    if (!window.isSecureContext) {
        document.getElementById('login-location-status').textContent = 'La ubicación requiere HTTPS o localhost. En esta conexión solo se registrará la IP.';
    }
    let pending = false;
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        if (pending) return;
        pending = true;
        const button = form.querySelector('button[type="submit"]');
        const message = document.getElementById('login-location-status');
        button.disabled = true;
        const finish = (status, coords) => {
            const labels = { success: 'Ubicación obtenida.', denied: 'Permiso de ubicación denegado.', unavailable: 'El navegador no pudo obtener la ubicación.', timeout: 'Se agotó el tiempo para obtener la ubicación.', unsupported: 'Este navegador no admite geolocalización.', insecure: 'La ubicación requiere HTTPS o localhost.' };
            message.textContent = labels[status];
            form.elements.location_status.value = status;
            if (coords) {
                form.elements.latitude.value = coords.latitude;
                form.elements.longitude.value = coords.longitude;
                form.elements.accuracy_meters.value = coords.accuracy;
            }
            setTimeout(() => HTMLFormElement.prototype.submit.call(form), status === 'success' ? 0 : 1200);
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
        const deadline = setTimeout(() => complete('timeout'), 60000);
        try {
            navigator.geolocation.getCurrentPosition(
                position => complete('success', position.coords),
                error => complete(({1: 'denied', 2: 'unavailable', 3: 'timeout'})[error.code] || 'unavailable'),
                { enableHighAccuracy: false, timeout: 20000, maximumAge: 0 }
            );
        } catch {
            complete('unavailable');
        }
    });
})();
