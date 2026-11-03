import axios from 'axios';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import '../css/session-expiration.css';

const sessionDialog = Swal.mixin({
    customClass: {
        container: 'session-dialog-container',
        popup: 'session-dialog',
        title: 'session-dialog-title',
        htmlContainer: 'session-dialog-content',
        confirmButton: 'session-dialog-confirm',
    },
    buttonsStyling: false,
    allowOutsideClick: false,
    allowEscapeKey: false,
});

const lifetime = Number(document.querySelector('meta[name="session-lifetime"]')?.content);

if (document.querySelector('meta[name="session-expired"]')) {
    sessionDialog.fire({
        icon: 'info',
        title: 'Tu sesión ha expirado',
        text: 'Por seguridad, cerramos tu sesión. Ingresa nuevamente para continuar.',
        confirmButtonText: 'Entendido',
    }).then(() => {
        const url = new URL(window.location.href);
        url.searchParams.delete('session_expired');
        window.history.replaceState(null, '', url);
        document.getElementById('rut')?.focus();
    });
}

if (lifetime > 0) {
    const loginUrl = document.querySelector('meta[name="session-login-url"]').content;
    const extendUrl = document.querySelector('meta[name="session-extend-url"]').content;
    const storageKey = 'portal-session-deadline';
    const warningTime = Math.min(120, lifetime / 2) * 1000;
    let deadline;
    let warningOpen = false;
    let expired = false;

    function renew(seconds) {
        deadline = Date.now() + seconds * 1000;
        try { localStorage.setItem(storageKey, String(deadline)); } catch {}
        if (warningOpen) {
            warningOpen = false;
            Swal.close();
        }
    }

    async function expire() {
        if (expired) return;
        expired = true;
        warningOpen = false;
        sessionDialog.fire({
            icon: 'info',
            title: 'Tu sesión ha expirado',
            text: 'Inicia sesión nuevamente para continuar.',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
        });
        try {
            await axios.post(document.querySelector('meta[name="session-logout-url"]').content, {}, {
                timeout: 10000,
                headers: { Accept: 'application/json' },
            });
        } catch (error) {
            // An expired session may already reject logout with 401 or 419.
            if (![401, 419].includes(error.response?.status)) {
                sessionDialog.fire({
                    icon: 'warning',
                    title: 'Tu sesión ha expirado',
                    text: 'No se pudo confirmar el cierre por un problema de conexión. Reintenta para continuar.',
                    confirmButtonText: 'Reintentar cierre',
                }).then(() => { expired = false; expire(); });
                return;
            }
        }
        const destination = new URL(loginUrl, window.location.origin);
        destination.searchParams.set('session_expired', '1');
        window.location.replace(destination.href);
    }

    renew(lifetime);
    axios.interceptors.response.use(response => {
        const seconds = Number(response.headers['x-session-lifetime']);
        if (seconds > 0 && !expired) renew(seconds);
        return response;
    }, error => {
        if ([401, 419].includes(error.response?.status)) expire();
        return Promise.reject(error);
    });

    window.addEventListener('storage', event => {
        if (event.key === storageKey && Number(event.newValue) > deadline && !expired) {
            deadline = Number(event.newValue);
            if (warningOpen) {
                warningOpen = false;
                Swal.close();
            }
        }
    });

    function tick() {
        if (expired) return;
        const remaining = deadline - Date.now();
        if (remaining <= 0) { expire(); return; }
        if (remaining <= warningTime && !warningOpen) {
            warningOpen = true;
            sessionDialog.fire({
                icon: 'warning',
                title: 'Tu sesión está por terminar',
                html: '<p>Tu sesión se cerrará por inactividad en:</p>'
                    + '<div class="session-dialog-timer" role="timer" aria-label="Tiempo restante">'
                    + '<strong id="session-countdown"></strong><span>minutos restantes</span></div>'
                    + '<p class="session-dialog-hint">Mantén tu sesión activa para seguir trabajando.</p>',
                confirmButtonText: 'Mantener sesión activa',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        await axios.post(extendUrl);
                        return true;
                    } catch {
                        if (!expired) Swal.showValidationMessage('No se pudo renovar la sesión. Inténtalo nuevamente.');
                        return false;
                    }
                },
            }).then(() => { warningOpen = false; });
        }
        const countdown = document.getElementById('session-countdown');
        if (countdown) {
            const seconds = Math.ceil(remaining / 1000);
            countdown.textContent = `${Math.floor(seconds / 60)}:${String(seconds % 60).padStart(2, '0')}`;
        }
    }

    setInterval(tick, 1000);
    document.addEventListener('visibilitychange', tick);
    tick();
}
