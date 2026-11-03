import axios from 'axios';
import { installClinicalSessionBridge } from './clinical-session-bridge';
// The default "all" bundle injects an inline stylesheet blocked by our CSP.
import Swal from 'sweetalert2/dist/sweetalert2.esm.js';
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
    const stopClinicalBridge = installClinicalSessionBridge(lifetime);
    const heartbeatUrl = document.querySelector('meta[name="session-heartbeat-url"]').content;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const activityInterval = Math.min(15000, lifetime * 1000 / 4);
    const activityEvents = ['click', 'pointermove', 'pointerdown', 'keydown', 'input', 'scroll', 'wheel'];
    let activityPending = false;
    let lastActivityAttempt = -Infinity;

    async function registerPortalActivity(event) {
        if (!event.isTrusted || document.visibilityState !== 'visible' || expired || activityPending) return;
        // Once the deadline has passed, activity must not revive an expired session.
        if (Date.now() >= deadline) { expire(); return; }
        if (Date.now() - lastActivityAttempt < activityInterval) return;
        lastActivityAttempt = Date.now();
        activityPending = true;
        try {
            await axios.post(heartbeatUrl, {}, {
                timeout: 10000,
                headers: { 'X-CSRF-TOKEN': csrfToken, Accept: 'application/json' },
            });
            // The response interceptor updates the countdown only after server confirmation.
        } catch {
            // Connection failures do not renew the timer; 401/419 trigger expiration.
        } finally { activityPending = false; }
    }

    for (const type of activityEvents) {
        document.addEventListener(type, registerPortalActivity, { passive: true, capture: true });
    }

    function updateHeaderCounter() {
        const seconds = Math.max(0, Math.ceil((deadline - Date.now()) / 1000));
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const time = [
            ...(hours > 0 ? [String(hours).padStart(2, '0')] : []),
            String(minutes).padStart(2, '0'),
            String(seconds % 60).padStart(2, '0'),
        ].join(':');
        document.querySelectorAll('[data-session-counter]').forEach(counter => {
            counter.textContent = time;
            counter.closest('.session-header-counter')?.classList.toggle('session-header-counter-warning', seconds * 1000 <= warningTime);
        });
    }

    function renew(seconds) {
        deadline = Date.now() + seconds * 1000;
        updateHeaderCounter();
        try { localStorage.setItem(storageKey, String(deadline)); } catch {}
        if (warningOpen) {
            warningOpen = false;
            Swal.close();
        }
    }

    async function expire() {
        if (expired) return;
        expired = true;
        stopClinicalBridge();
        for (const type of activityEvents) {
            document.removeEventListener(type, registerPortalActivity, true);
        }
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
            updateHeaderCounter();
            if (warningOpen) {
                warningOpen = false;
                Swal.close();
            }
        }
    });

    function tick() {
        if (expired) return;
        updateHeaderCounter();
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
