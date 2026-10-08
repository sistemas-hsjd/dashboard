<template>
  <div id="modalEnlaces" class="modal fade hospital-links-modal" tabindex="-1"
       aria-labelledby="modalEnlacesTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <div class="d-flex align-items-center gap-3">
            <span class="links-heading-icon" aria-hidden="true"><i class="mdi mdi-hospital-building"></i></span>
            <div>
              <h5 id="modalEnlacesTitle" class="modal-title">{{ titulo || 'Aplicaciones hospitalarias' }}</h5>
              <p class="links-heading-description">Selecciona la aplicación a la que deseas ingresar.</p>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="links-toolbar">
            <span class="links-count">{{ enlaces.length }} accesos disponibles</span>
            <label class="links-search">
              <i class="mdi mdi-magnify" aria-hidden="true"></i>
              <input v-model="busqueda" type="search" placeholder="Buscar aplicación" aria-label="Buscar aplicación">
            </label>
          </div>
          <div v-if="enlacesFiltrados.length" class="links-grid">
            <article v-for="enlace in enlacesFiltrados" :key="enlace.id" class="link-card">
              <div class="link-card-image">
                <img v-if="enlace.url && !imagenesFallidas[enlace.id]" :src="enlace.url" alt="" loading="lazy"
                     @error="imagenesFallidas[enlace.id] = true">
                <i v-else class="mdi mdi-hospital-building" aria-hidden="true"></i>
              </div>
              <div class="link-card-content">
                <h6>{{ enlace.nombre }}</h6>
                <p v-if="enlace.descripcion">{{ enlace.descripcion }}</p>
                <div class="link-card-footer">
                  <a v-if="enlace.enlace && enlace.enlace.trim()" :href="enlace.enlace.trim()" target="_blank"
                     rel="noopener noreferrer" class="link-access"
                     :aria-label="`Ingresar a ${enlace.nombre} (abre en otra pestaña)`">
                    Ingresar <i class="mdi mdi-arrow-top-right" aria-hidden="true"></i>
                  </a>
                  <span v-else class="link-unavailable">Enlace no disponible</span>
                </div>
              </div>
            </article>
          </div>
          <div v-else class="links-empty" role="status">
            <i class="mdi mdi-magnify" aria-hidden="true"></i>
            <p>{{ enlaces.length ? 'No se encontraron aplicaciones con esa búsqueda.' : 'No hay enlaces disponibles en esta categoría.' }}</p>
          </div>
        </div>
        <div class="modal-footer">
          <span class="links-footer-note">Los accesos se abren en una nueva pestaña.</span>
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    enlaces: { type: Array, default: () => [] },
    titulo: { type: String, default: '' }
  },
  data() {
    return { busqueda: '', imagenesFallidas: {} };
  },
  computed: {
    enlacesFiltrados() {
      const normalize = value => String(value || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
      const term = normalize(this.busqueda).trim();
      return this.enlaces.filter(enlace => normalize(`${enlace.nombre || ''} ${enlace.descripcion || ''}`).includes(term));
    }
  },
  watch: {
    enlaces() {
      this.busqueda = '';
      this.imagenesFallidas = {};
    }
  }
};
</script>

<style scoped>
.modal-content { border: 1px solid #dbe8f0; border-radius: 18px; overflow: hidden; box-shadow: 0 20px 60px #203b4933; }
.modal-header { background: #eef7fb; border-bottom: 1px solid #dcebf2; padding: 22px 24px; }
.modal-title { color: #304f66; font-size: 18px; font-weight: 700; }
.links-heading-icon { display: grid; place-items: center; width: 48px; height: 48px; flex-shrink: 0; border-radius: 14px; background: #dbeef5; color: #3684a9; font-size: 27px; }
.links-heading-description { margin: 4px 0 0; color: #374151; font-size: 12px; }
.modal-body { padding: 24px; background: #f6fafc; }
.links-toolbar { display: flex; justify-content: space-between; align-items: center; gap: 14px; margin-bottom: 20px; }
.links-count { color: #374151; font-size: 12px; }
.links-search { display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #d8e5ee; padding: 8px 12px; border-radius: 10px; color: #5485a4; }
.links-search:focus-within { outline: 2px solid #4588b5; outline-offset: 2px; }
.links-search input { width: 220px; min-width: 0; border: 0; outline: 0; color: #304f66; background: transparent; font-size: 13px; }
.links-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 18px; }
.link-card { display: flex; flex-direction: column; border: 1px solid #a8b8c4; border-radius: 14px; overflow: hidden; background: #fff; }
.link-card-image { height: 132px; flex: 0 0 132px; min-width: 0; overflow: hidden; display: flex; align-items: center; justify-content: center; padding: 10px; background: #e2f0f6; color: #4286a8; font-size: 44px; border-bottom: 1px solid #edf2f5; }
.link-card-image img { display: block; width: 100%; height: 112px; max-width: 100%; max-height: 112px; min-width: 0; object-fit: contain; background: #f1f7fa; }
.link-card-content { display: flex; flex-direction: column; flex: 1; padding: 16px; }
.link-card-content h6 { color: #111827; font-size: 14px; line-height: 1.4; font-weight: 800; margin-bottom: 8px; overflow-wrap: anywhere; }
.link-card-content p { font-size: 12px; line-height: 1.6; color: #374151; margin-bottom: 14px; overflow-wrap: anywhere; }
.link-card-footer { margin-top: auto; padding-top: 12px; border-top: 1px solid #ccd5de; display: flex; justify-content: flex-end; }
.link-access { display: inline-flex; align-items: center; gap: 8px; border-radius: 20px; background: #176579; color: #fff; font-weight: 600; font-size: 12px; padding: 7px 14px; }
.link-access:hover { background: #104d5d; color: #fff; }
.link-access:focus-visible { outline: 3px solid #245d83; outline-offset: 3px; }
.link-unavailable { color: #4b5563; font-size: 12px; }
.links-empty { text-align: center; padding: 40px 16px; color: #374151; }
.links-empty i { font-size: 36px; }
.links-empty p { margin: 10px 0 0; }
.modal-footer { justify-content: space-between; border-top: 1px solid #e0eaf0; padding: 14px 24px; }
.links-footer-note { font-size: 11px; color: #374151; }
@media (max-width: 991px) { .links-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
@media (max-width: 767px) { .links-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } .links-toolbar { align-items: stretch; flex-direction: column; } .links-search input { width: 100%; } }
@media (max-width: 480px) { .links-grid { grid-template-columns: 1fr; } .modal-body, .modal-header { padding: 18px; } .modal-title { font-size: 16px; } }
</style>
