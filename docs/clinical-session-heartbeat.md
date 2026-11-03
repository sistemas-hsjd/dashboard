# Actividad de Registro Clínico y sesión del Portal

## Arquitectura y configuración

Los enlaces de InicioComponent.vue se abren en otra pestaña con `target="_blank" rel="noopener noreferrer"`. Antes no había referencia entre ventanas. El puente del Portal intercepta el clic normal sobre enlaces cuyo origen coincida exactamente con `CLINICAL_ORIGIN`, abre una pestaña, conserva su WindowProxy y elimina su `opener` antes de navegar. Esto también cubre los enlaces de categorías y sus modales. No cambia las direcciones guardadas ni envía tokens del Portal a Registro Clínico.

Configurar en el servidor del Portal `CLINICAL_ORIGIN` con el origen real de Registro Clínico (esquema, host y puerto, sin ruta ni barra final), por ejemplo `https://registro.example.cl`. Vacío desactiva el puente. No se deduce el origen desde nombres de sistemas ni se confía en un origen indicado por el mensaje. Ejecutar `php artisan config:cache` y compilar con `npm run build`; desplegar public/build completo.

## Endpoint del Portal

`POST /session/heartbeat` devuelve **204**, `Cache-Control: no-store` y `X-Session-Lifetime` en segundos. Pertenece al grupo web y auth: requiere la cookie de sesión existente y CSRF válido; no acepta el token de Registro Clínico como sustituto. Guarda `portal_last_activity_at` y StartSession persiste la sesión actual, renovando su vigencia sin regenerarla ni autenticar usuarios nuevos. Sin autenticación devuelve 401 para solicitudes JSON; sin CSRF válido, 419. No hay excepciones CSRF, cambios CORS ni relajación de CSP.

El Portal recibe `clinical:activity:v1`, valida origen exacto **y** que event.source sea una pestaña registrada y abierta, y hace su propio POST same-origin con su cookie y `X-CSRF-TOKEN`. Como máximo hay una solicitud simultánea y un intento cada min(30 segundos, SESSION_LIFETIME/4). Solo una respuesta exitosa con X-Session-Lifetime actualiza el contador y cierra la advertencia. Los fallos no extienden el contador; 401/419 siguen el flujo de expiración. El puente se detiene al expirar.

## Código necesario en Registro Clínico (repositorio externo)

El Portal envía cada 2 segundos un saludo `portal:session-init:v1` con targetOrigin exacto. El saludo no renueva sesiones. Registro Clínico debe incorporar este ejemplo en su bundle externo permitido por su CSP, sustituyendo PORTAL_ORIGIN por configuración confiable propia:

```js
const PORTAL_ORIGIN = 'https://portal.example.cl'; // exacto; en Laragon, http://dashboard.test
let portal = null;
let lastActivity = -Infinity;
window.addEventListener('message', event => {
    if (event.origin !== PORTAL_ORIGIN || event.data?.type !== 'portal:session-init:v1' || !event.source) return;
    if (portal && portal !== event.source) return;
    portal = event.source;
});
function notifyPortal(event) {
    if (!event.isTrusted || document.visibilityState !== 'visible' || !portal || portal.closed) return;
    if (Date.now() - lastActivity < 15000) return;
    lastActivity = Date.now();
    portal.postMessage({ type: 'clinical:activity:v1' }, PORTAL_ORIGIN);
}
for (const type of ['pointerdown', 'keydown', 'input', 'scroll']) {
    document.addEventListener(type, notifyPortal, { passive: true, capture: true });
}
```

Enviar solo actividad real: no usar un temporizador incondicional, ni reenviar cada saludo como actividad. `POST /session/keep-alive` de Registro Clínico sigue siendo independiente. No incluir datos clínicos, credenciales, tokens ni identificadores de paciente en los mensajes.

## Límites y operación

El flujo elegido fuerza una pestaña nueva en el clic normal incluso si el enlace apunta a la misma pestaña; el Portal permanece abierto y conserva la referencia. No necesita window.opener en el hijo. No hay renovación automática para pestañas abiertas por dirección directa, menú contextual, clic con modificadores, bloqueo de ventanas o si se cierra el Portal. En esos casos volver al Portal y abrir Registro Clínico mediante clic normal; no se sustituye por un ping ciego ni por un fetch cross-origin con credenciales. Si Registro Clínico exige COOP que separe los grupos de navegación, la referencia también se pierde: es necesaria otra integración, no funciona este puente.

El Portal no puede renovar de forma segura una sesión desde una página externa sin referencia ni contexto autenticado del Portal. Para una futura navegación exclusivamente en la misma pestaña se necesitaría un mecanismo distinto (por ejemplo integración de servidor a servidor con concesión revocable vinculada a la sesión), fuera de este flujo. No enviar CSRF o cookies del Portal en URLs ni compartir cookies entre aplicaciones.

Verificar en navegador con ambos sistemas: actividad real en Registro Clínico produce POST 204 al Portal y reinicia su contador; al dejar de trabajar vence normalmente; origen, tipo o ventana distintos no producen POST. Probar logout/401/419, popup bloqueado y cierre de la pestaña clínica. La implementación del emisor en Registro Clínico es requisito pendiente fuera de este repositorio.
