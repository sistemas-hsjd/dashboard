<template>
  <div class="staff-portal">
    <section class="staff-section" aria-labelledby="localSystemsTitle">
      <div class="staff-section-heading staff-local-heading">
        <span class="staff-section-icon" aria-hidden="true"><i class="mdi mdi-hospital-building"></i></span>
        <div><h2 id="localSystemsTitle">Sistemas locales</h2><p>Accede a tus aplicaciones clínicas y administrativas.</p></div>
        <span v-if="user?.nombre" class="staff-greeting">{{ saludo }}, <strong>{{ user.nombre }}</strong></span>
        <span class="staff-count">{{ sistemas.length }} sistemas</span>
      </div>
      <div class="staff-grid">
        <article v-for="sistema in sistemas" :key="sistema.id" class="staff-card">
          <div class="staff-card-image"><img :src="`assets/images/img-portal/${sistema.img}`" :alt="sistema.tx_descripcion" loading="lazy"></div>
          <div class="staff-card-body">
            
            <div class="staff-title-row">
              <h3>{{ sistema.tx_descripcion }}</h3>
            <div class="staff-inline-actions">
              <button v-if="Number(sistema.id) === 10000000" type="button" class="staff-access" @click="abrirAcess()">Ingresar <i class="mdi mdi-arrow-right" aria-hidden="true"></i></button>
              <a v-else-if="localUrl(sistema)" class="staff-access" :href="localUrl(sistema)" target="_blank" rel="noopener noreferrer" :aria-label="`Ingresar a ${sistema.tx_descripcion} (nueva pestaña)`">Ingresar <i class="mdi mdi-arrow-top-right" aria-hidden="true"></i></a>
              <span v-else class="staff-unavailable">Acceso no disponible</span>
            </div>
            </div>
            <p v-if="sistema.descripcion" class="staff-local-description">{{ sistema.descripcion }}</p>
          </div>
        </article>
      </div>
    </section>
    <section class="staff-section staff-support" aria-labelledby="supportSystemsTitle">
      <div class="staff-section-heading">
        <span class="staff-section-icon" aria-hidden="true"><i class="mdi mdi-layers-triple-outline"></i></span>
        <div><h2 id="supportSystemsTitle">Plataformas de apoyo</h2><p>Herramientas de apoyo para la atención hospitalaria.</p></div>
      </div>
      <div class="staff-grid">
        <article v-for="sistema in sistemasDefaults" :key="sistema.id" class="staff-card">
          <div class="staff-card-image"><img :src="`assets/images/img-portal/${sistema.img}`" :alt="sistema.tx_descripcion" loading="lazy"></div>
          <div class="staff-card-body">
            
                   <template v-if="sistema.estado == 0 && Number(sistema.id) === 24">
                      <h4 class="card-title">TracKare de Contingencia</h4>
                       <p class="card-text mb-0 text-danger">Soporte: <strong>{{ sistema.encargado?.telefono }}</strong>.</p>
                    </template>
                    <template v-else-if="sistema.estado == 0 && Number(sistema.id) === 20">
                      <h4 class="card-title">Laboratorio Clínico Contingencia <br>User:LABO Pass: Labo1234</h4>
                    </template>
                    <template v-else-if="Number(sistema.id) === 24 || Number(sistema.id) === 28">
                        <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                        <p class="card-text mb-0 text-primary">Soporte: <strong>{{ sistema.encargado?.telefono }}</strong>.</p>
                    </template>
                    <template v-else-if="Number(sistema.id) === 20 || Number(sistema.id) === 29">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">Soporte: <strong>{{ sistema.encargado?.email }}</strong>.</p>
                  
                        <template v-if="Number(sistema.id) === 20">
                        <p class="card-text mb-0 text-danger">
                          <strong>(Exámenes hasta el 07-julio-2026)</strong>.
                        </p>
                      </template>

                      <template v-if="Number(sistema.id) === 29">
                        <p class="card-text mb-0 text-danger">
                          <strong>(Exámenes desde el 08-julio-2026)</strong>.
                        </p>
                      </template>
                      
                    </template>
                    <template v-else-if="Number(sistema.id) === 19">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">Soporte: <strong>{{ sistema.encargado?.telefono }}</strong>.</p>
                    </template>
                    <template v-else-if="Number(sistema.id) === 22">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">Soporte: <strong>{{ sistema.encargado?.telefono }}</strong>.</p>
                    </template>
                    <template v-else-if="Number(sistema.id) === 23">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">Soporte: <strong>{{ sistema.encargado?.telefono }}</strong>.</p>
                    </template>
                    <template v-else-if="Number(sistema.id) === 25">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">Soporte: <strong>{{ sistema.encargado?.telefono }}</strong>.</p>
                    </template>
                    <!-- <template v-else-if="Number(sistema.id) === 29">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">Soporte: (Exámenes desde el 08-julio-2026)<strong>{{ sistema.encargado?.telefono }}</strong>.</p>
                    </template> -->
                    <template v-else>
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                    </template>

            <div class="staff-card-actions">
              <a v-if="supportUrl(sistema)" class="staff-access" :href="supportUrl(sistema)" target="_blank" rel="noopener noreferrer" :aria-label="`Ingresar a ${sistema.tx_descripcion} (nueva pestaña)`">Ingresar <i class="mdi mdi-arrow-top-right" aria-hidden="true"></i></a>
              <span v-else class="staff-unavailable">Acceso no disponible</span>
            </div>
          </div>
        </article>
      </div>
    </section>
    <modalCrearCuentaComponent></modalCrearCuentaComponent>
    <modalDesarrolloComponent></modalDesarrolloComponent>
    <modalNewSoporteComponent></modalNewSoporteComponent>
    <ModalUciComponent></ModalUciComponent>
    <PopupComponent></PopupComponent>
  </div>
</template>

<script>

import modalDesarrolloComponent from './modals/ModalDesarrolloComponent.vue';
import modalNewSoporteComponent from './modals/modalNewSoporteComponent.vue';
import modalCrearCuentaComponent from './modals/ModalCrearCuentaComponent.vue';
import ModalUciComponent from './modals/ModalUciComponent.vue';
import PopupComponent  from './elements/PopupComponent.vue';
// import TourNuevoMenu  from './elements/TourNuevoMenuCompoent.vue';

export default {
  name: 'MisSistemasGrid',
    components: {
        modalDesarrolloComponent,
        modalCrearCuentaComponent,
        ModalUciComponent,
        modalNewSoporteComponent,
        PopupComponent,
        // TourNuevoMenu,
    },
   data() {
        return {
          sistemas :[],

          sistemasDefaults:[],
          user: null,
          saludo: '',
          saludoTimer: null,

        }
    },
  methods: {
    actualizarSaludo() {
      const hora = Number(new Intl.DateTimeFormat('es-CL', {
        timeZone: 'America/Santiago', hour: '2-digit', hourCycle: 'h23'
      }).format(new Date()));
      this.saludo = hora < 12 ? 'Buen día' : hora < 20 ? 'Buenas tardes' : 'Buenas noches';
    },
    localUrl(sistema) {
      return [22, 24, 20, 21, 19].includes(Number(sistema.id))
        ? sistema.tx_direccion : (sistema.url_final || sistema.tx_direccion);
    },
    supportUrl(sistema) {
      return sistema.estado == 0 && [24, 20].includes(Number(sistema.id))
        ? sistema.tx_direccion_contingencia : sistema.tx_direccion;
    },
    abrirAcess(){
      const element = document.getElementById('modalUci');
      const Modal = window.bootstrap.Modal;
      (Modal.getInstance(element) || new Modal(element)).show();
    },
    getSistemas(){
        axios.post('api/get-mis-sistemas')
        .then(response => {
          this.sistemas = response.data.mis_sistemas
          this.sistemasDefaults = response.data.defaultSistemas

        })
        .catch(error => {
            console.error('Error: ', error);
        });
    },
    getAuthUser(){
        axios.post('data-auth')
        .then(response => {
            const { user, jefatura, authenticated } = response.data
            // this.authenticated = authenticated
            // this.jefatura = jefatura
            this.user = user
        })
        .catch(error => {
            console.error('Error: ', error);
        });
    },
  }, 
  beforeUnmount() {
    clearInterval(this.saludoTimer);
  },
  mounted(){
    this.actualizarSaludo();
    this.saludoTimer = setInterval(() => this.actualizarSaludo(), 60000);
    this.getSistemas()
    this.getAuthUser()      
  }
}
</script>

<style scoped>
.staff-portal {
  --staff-accent: #208675;
  --staff-soft: #e1efed;
  color: #0c193f;
  padding: 4px 0 28px;
}
.staff-greeting { margin: 0 8px 48px; text-align: right; font-size: 20px; line-height: 1.5; }
.staff-greeting strong { font-weight: 700; text-transform: capitalize; }
.staff-section-heading { display: flex; align-items: center; gap: 20px; margin: 0 8px 34px; }
.staff-section-icon { display: grid; place-items: center; flex: 0 0 62px; height: 62px; border-radius: 18px; background: var(--staff-soft); color: var(--staff-accent); font-size: 34px; }
.staff-section-heading h2 { margin: 0 0 3px; color: #0c193f; font-size: clamp(24px, 2.1vw, 32px); line-height: 1.2; font-weight: 700; }
.staff-section-heading p { margin: 0; color: #59667f; font-size: 18px; line-height: 1.5; }
.staff-count { margin-left: auto; padding: 7px 17px; border: 1px solid #bfddd7; border-radius: 24px; background: var(--staff-soft); color: var(--staff-accent); font-size: 17px; font-weight: 600; white-space: nowrap; }
.staff-grid { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 19px 13px; }
.staff-card { display: flex; align-items: center; gap: 20px; min-width: 0; min-height: 150px; padding: 18px; border: 1px solid #cdd4e1; border-radius: 14px; background: #ffffffb3; transition: border-color .18s, box-shadow .18s; }
.staff-card:hover { border-color: var(--staff-accent); box-shadow: 0 4px 16px #15284b0a; }
.staff-card-image { position: relative; flex: 0 0 38%; max-width: 107px; height: 110px; overflow: hidden; border-radius: 12px; background: #e1eaed; }
.staff-card-image::after { position: absolute; inset: 0; content: ''; background: #648b9420; pointer-events: none; }
.staff-card-image img { display: block; width: 100%; height: 100%; object-fit: cover; filter: saturate(.45); }
.staff-card-body { display: flex; flex: 1; flex-direction: column; align-items: flex-start; min-width: 0; padding: 0; border: 0; }
.staff-title-row { display: flex; flex-direction: column; align-items: flex-start; gap: 16px; width: 100%; }
.staff-card-body h3, .staff-card-body .card-title { margin: 0; color: #0c193f; font-size: clamp(16px, 1.3vw, 20px); line-height: 1.25; font-weight: 700; overflow-wrap: anywhere; }
.staff-inline-actions, .staff-card-actions { display: flex; justify-content: flex-start; margin: 0; padding: 0; border: 0; }
.staff-access { display: inline-flex; align-items: center; gap: 8px; padding: 3px 0; border: 0; border-radius: 3px; background: transparent; color: var(--staff-accent); font-size: 18px; font-weight: 500; line-height: 1.3; text-decoration: none; }
.staff-access .mdi { font-size: 21px; }
.staff-access:hover { color: var(--staff-accent); text-decoration: underline; }
.staff-access:focus-visible { outline: 2px solid var(--staff-accent); outline-offset: 4px; }
.staff-card { position: relative; }
.staff-access { cursor: pointer; }
.staff-access::after { content: ''; position: absolute; inset: 0; z-index: 1; border-radius: 14px; cursor: pointer; }
.staff-card:focus-within { outline: 2px solid var(--staff-accent); outline-offset: 3px; }
.staff-card { position: relative; }
.staff-access { cursor: pointer; }
.staff-access::after { content: ''; position: absolute; inset: 0; z-index: 1; border-radius: 14px; cursor: pointer; }
.staff-card:focus-within { outline: 2px solid var(--staff-accent); outline-offset: 3px; }
.staff-unavailable { color: #59667f; font-size: 13px; }
.staff-local-description { margin: 6px 0 0; color: #59667f; font-size: 13px; }
.staff-support { --staff-accent: #61559b; --staff-soft: #e9e9f2; margin-top: 54px; padding-top: 36px; border-top: 1px solid #d7ddea; }
.staff-support .staff-card { min-height: 174px; gap: 20px; padding: 20px 17px; }
.staff-support .staff-card-image { height: 124px; }
.staff-support .staff-card-body { gap: 8px; }
.staff-card-body .card-text { margin: 0 !important; color: #59667f !important; font-size: 16px; line-height: 1.4; overflow-wrap: anywhere; }
.staff-card-body .card-text strong { font-weight: 500; }
.staff-card-body .card-text.text-danger { color: #b14343 !important; font-size: 13px; }
/* Compact desktop layout keeps the application groups within easier reach. */
.staff-portal { padding: 0 0 16px; }
.staff-greeting { flex: 1; margin: 0; padding-right: 18%; text-align: center; font-size: 16px; overflow-wrap: anywhere; }
.staff-local-heading .staff-count { margin-left: 0; }
.staff-local-heading > .staff-count:last-child { margin-left: auto; }
.staff-local-heading .staff-greeting + .staff-count:last-child { margin-left: 0; }
.staff-section-heading { gap: 12px; margin: 0 0 16px; }
.staff-section-icon { flex-basis: 44px; height: 44px; border-radius: 12px; font-size: 26px; }
.staff-section-heading h2 { font-size: clamp(22px, 1.6vw, 26px); }
.staff-section-heading p { font-size: 14px; }
.staff-count { padding: 5px 12px; font-size: 14px; }
.staff-grid { gap: 12px; }
.staff-card, .staff-support .staff-card { min-height: 112px; gap: 12px; padding: 12px; }
.staff-card-image, .staff-support .staff-card-image { flex-basis: 30%; max-width: 80px; height: 80px; }
.staff-title-row { gap: 8px; }
.staff-card-body h3, .staff-card-body .card-title { font-size: clamp(14px, 1vw, 16px); }
.staff-access { font-size: 14px; }
.staff-access .mdi { font-size: 18px; }
.staff-support { margin-top: 22px; padding-top: 18px; }
.staff-support .staff-card-body { gap: 5px; }
.staff-card-body .card-text { font-size: 13px; }
@media (max-width: 1199px) {
  .staff-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); }
}
@media (max-width: 991px) {
  .staff-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .staff-local-heading { flex-wrap: wrap; }
  .staff-local-heading .staff-greeting { flex-basis: 100%; margin: 0; padding-right: 0; text-align: left; font-size: 15px; }
  .staff-section-heading { gap: 14px; margin-bottom: 24px; }
  .staff-section-heading p { font-size: 15px; }
  .staff-card-body h3, .staff-card-body .card-title { font-size: 18px; }
}
@media (max-width: 575px) {
  .staff-grid { grid-template-columns: 1fr; gap: 14px; }
  .staff-section-heading { flex-wrap: wrap; margin-left: 0; margin-right: 0; gap: 12px; }
  .staff-section-heading > div { flex: 1; min-width: 0; }
  .staff-section-icon { flex-basis: 48px; height: 48px; font-size: 28px; border-radius: 14px; }
  .staff-section-heading h2 { font-size: 23px; }
  .staff-count { margin-left: 60px; font-size: 14px; }
  .staff-card, .staff-support .staff-card { min-height: 144px; padding: 16px; }
  .staff-card-image, .staff-support .staff-card-image { flex-basis: 100px; height: 110px; }
  .staff-support { margin-top: 32px; padding-top: 28px; }
}
@media (prefers-reduced-motion: reduce) { .staff-card { transition: none; } }
</style>
