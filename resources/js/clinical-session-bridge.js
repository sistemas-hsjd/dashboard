import axios from 'axios';

export function acceptsClinicalActivity(event, origin, windows) {
    return !!origin && event.origin === origin && windows.has(event.source)
        && !event.source.closed && event.data?.type === 'clinical:activity:v1';
}

export function installClinicalSessionBridge(lifetime) {
    const configured = document.querySelector('meta[name="clinical-origin"]')?.content;
    let origin;
    try {
        const parsed = new URL(configured);
        if (!['http:', 'https:'].includes(parsed.protocol) || parsed.origin !== configured) return () => {};
        origin = parsed.origin;
    } catch { return () => {}; }

    const windows = new Set();
    const endpoint = document.querySelector('meta[name="session-heartbeat-url"]').content;
    const token = document.querySelector('meta[name="csrf-token"]').content;
    const interval = Math.min(30000, lifetime * 1000 / 4);
    let pending = false;
    let lastAttempt = -Infinity;
    let stopped = false;

    function openClinical(event) {
        const link = event.target.closest?.('a[href]');
        if (!link || event.defaultPrevented || event.button !== 0 || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey) return;
        const url = new URL(link.href, window.location.href);
        if (url.origin !== origin) return;
        event.preventDefault();
        // Retain the child reference, but prevent the external app from navigating the Portal.
        const child = window.open('about:blank', '_blank');
        if (!child) return;
        child.opener = null;
        windows.add(child);
        child.location.replace(url.href);
    }

    async function activity(event) {
        if (stopped || !acceptsClinicalActivity(event, origin, windows) || pending || Date.now() - lastAttempt < interval) return;
        pending = true;
        lastAttempt = Date.now();
        try {
            await axios.post(endpoint, {}, {
                timeout: 10000,
                headers: { 'X-CSRF-TOKEN': token, Accept: 'application/json' },
            });
        } catch {
            // Never renew the local countdown on failure. Session handling owns 401/419.
        } finally { pending = false; }
    }

    function handshake() {
        for (const child of windows) {
            if (child.closed) { windows.delete(child); continue; }
            child.postMessage({ type: 'portal:session-init:v1' }, origin);
        }
    }
    // Handshakes identify the Portal; they do not renew either session.
    const timer = setInterval(handshake, 2000);
    document.addEventListener('click', openClinical);
    window.addEventListener('message', activity);
    return () => {
        stopped = true;
        clearInterval(timer);
        windows.clear();
        document.removeEventListener('click', openClinical);
        window.removeEventListener('message', activity);
    };
}
