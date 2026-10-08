<template>
  <div class="staff-portal">
    <section class="staff-section" aria-labelledby="localSystemsTitle">
      <div class="staff-section-heading">
        <span class="staff-section-icon" aria-hidden="true"><i class="mdi mdi-hospital-building"></i></span>
        <div><h2 id="localSystemsTitle">Sistemas Locales</h2><p>Accede a tus aplicaciones clínicas y administrativas.</p></div>
        <span class="staff-count">{{ sistemas.length }} sistemas</span>
      </div>
      <div class="staff-grid">
        <article v-for="sistema in sistemas" :key="sistema.id" class="staff-card">
          <div class="staff-card-image"><img :src="`assets/images/img-portal/${sistema.img}`" :alt="sistema.tx_descripcion" loading="lazy"></div>
          <div class="staff-card-body">
            <span class="staff-card-badge">Sistema local</span>
            <h3>{{ sistema.tx_descripcion }}</h3>
            <p v-if="sistema.descripcion">{{ sistema.descripcion }}</p>
            <div class="staff-card-actions">
              <button v-if="sistema.id === 10000000" type="button" class="staff-access" @click="abrirAcess()">Ingresar <i class="mdi mdi-arrow-right" aria-hidden="true"></i></button>
              <a v-else-if="localUrl(sistema)" class="staff-access" :href="localUrl(sistema)" target="_blank" rel="noopener noreferrer" :aria-label="`Ingresar a ${sistema.tx_descripcion} (nueva pestaña)`">Ingresar <i class="mdi mdi-arrow-top-right" aria-hidden="true"></i></a>
              <span v-else class="staff-unavailable">Acceso no disponible</span>
            </div>
          </div>
        </article>
      </div>
    </section>
    <section class="staff-section staff-support" aria-labelledby="supportSystemsTitle">
      <div class="staff-section-heading">
        <span class="staff-section-icon" aria-hidden="true"><i class="mdi mdi-lifebuoy"></i></span>
        <div><h2 id="supportSystemsTitle">Plataformas de apoyo</h2><p>Herramientas de apoyo para la atención hospitalaria.</p></div>
        <span class="staff-count">{{ sistemasDefaults.length }} plataformas</span>
      </div>
      <div class="staff-grid">
        <article v-for="sistema in sistemasDefaults" :key="sistema.id" class="staff-card">
          <div class="staff-card-image"><img :src="`assets/images/img-portal/${sistema.img}`" :alt="sistema.tx_descripcion" loading="lazy"></div>
          <div class="staff-card-body">
            <span class="staff-card-badge">{{ sistema.estado == 0 && [24, 20].includes(Number(sistema.id)) ? 'Contingencia' : 'Plataforma de apoyo' }}</span>
                   <template v-if="sistema.estado == 0 && sistema.id === 24">
                      <h4 class="card-title">TracKare de Contingencia</h4>
                       <p class="card-text mb-0 text-danger">En caso de presentar inconvenientes para el ingreso,<br> por favor comuníquese al número <strong>{{ sistema.encargado?.telefono }}</strong>.</p>
                    </template>
                    <template v-else-if="sistema.estado == 0 && sistema.id === 20">
                      <h4 class="card-title">Laboratorio Clínico Contingencia <br>User:LABO Pass: Labo1234</h4>
                    </template>
                    <template v-else-if="sistema.id === 24 || sistema.id === 28">
                        <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                        <p class="card-text mb-0 text-primary">En caso de presentar inconvenientes para el ingreso,<br> por favor comuníquese al número <strong>{{ sistema.encargado?.telefono }}</strong>.</p>
                    </template>
                    <template v-else-if="sistema.id === 20 || sistema.id === 29">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">En caso de presentar inconvenientes para el ingreso,<br> por favor comuníquese al correo eléctronico <strong>{{ sistema.encargado?.email }}</strong>.</p>
                  
                        <template v-if="sistema.id === 20">
                        <p class="card-text mb-0 text-danger">
                          <strong>(Exámenes hasta el 07-julio-2026)</strong>.
                        </p>
                      </template>

                      <template v-if="sistema.id === 29">
                        <p class="card-text mb-0 text-danger">
                          <strong>(Exámenes desde el 08-julio-2026)</strong>.
                        </p>
                      </template>
                      
                    </template>
                    <template v-else-if="sistema.id === 19">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">En caso de presentar inconvenientes para el ingreso,<br> por favor comuníquese al número <strong>{{ sistema.encargado?.telefono }}</strong>.</p>
                    </template>
                    <template v-else-if="sistema.id === 22">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">En caso de presentar inconvenientes para el ingreso,<br> por favor comuníquese al número <strong>{{ sistema.encargado?.telefono }}</strong>.</p>
                    </template>
                    <template v-else-if="sistema.id === 23">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">En caso de presentar inconvenientes para el ingreso,<br> por favor comuníquese al número <strong>{{ sistema.encargado?.telefono }}</strong>.</p>
                    </template>
                    <template v-else-if="sistema.id === 25">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">En caso de presentar inconvenientes para el ingreso,<br> por favor comuníquese al número <strong>{{ sistema.encargado?.telefono }}</strong>.</p>
                    </template>
                    <!-- <template v-else-if="sistema.id === 29">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">En caso de presentar inconvenientes para el ingreso,<br> por favor comuníquese al número (Exámenes desde el 08-julio-2026)<strong>{{ sistema.encargado?.telefono }}</strong>.</p>
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
    <modalEstadosEnlacesComponent></modalEstadosEnlacesComponent>
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
import ModalEstadosEnlacesComponent from './modals/ModalEstadosEnlacesComponent.vue';
import ModalUciComponent from './modals/ModalUciComponent.vue';
import PopupComponent  from './elements/PopupComponent.vue';
// import TourNuevoMenu  from './elements/TourNuevoMenuCompoent.vue';

export default {
  name: 'MisSistemasGrid',
    components: {
        modalDesarrolloComponent,
        modalCrearCuentaComponent,
        ModalEstadosEnlacesComponent,
        ModalUciComponent,
        modalNewSoporteComponent,
        PopupComponent,
        // TourNuevoMenu,
    },
   data() {
        return {
          sistemas :[],

          sistemasDefaults:[],
          user:[],

        }
    },
  methods: {
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
  mounted(){
    this.getSistemas()
    this.getAuthUser()      
  }
}
</script>

<style scoped>
.staff-section { --staff-accent: #258674; --staff-soft: #e5f3ee; margin-bottom: 30px; }
.staff-support { --staff-accent: #5866ac; --staff-soft: #eceef9; }
.staff-section-heading { display: flex; align-items: center; gap: 12px; margin-bottom: 18px; }
.staff-section-icon { display: grid; place-items: center; width: 46px; height: 46px; flex-shrink: 0; border-radius: 14px; background: var(--staff-soft); color: var(--staff-accent); font-size: 25px; }
.staff-section-heading h2 { margin: 0 0 4px; color: #253e52; font-size: 18px; font-weight: 700; }
.staff-section-heading p { margin: 0; color: #526779; font-size: 12px; }
.staff-count { margin-left: auto; padding: 5px 10px; border-radius: 20px; background: var(--staff-soft); color: var(--staff-accent); font-size: 11px; font-weight: 600; white-space: nowrap; }
.staff-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 20px; }
.staff-card { display: flex; flex-direction: column; overflow: hidden; border: 1px solid #d5e1e9; border-radius: 16px; background: #fff; box-shadow: 0 2px 6px #294d7005; }
.staff-card-image { height: 132px; flex: 0 0 132px; overflow: hidden; background: var(--staff-soft); }
.staff-card-image img { display: block; width: 100%; height: 132px; object-fit: cover; }
.staff-card-body { flex: 1; display: flex; flex-direction: column; padding: 16px; border-left: 3px solid var(--staff-accent); }
.staff-card-badge { align-self: flex-start; padding: 3px 8px; margin-bottom: 9px; background: var(--staff-soft); color: var(--staff-accent); border-radius: 20px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .3px; }
.staff-card-body h3, .staff-card-body .card-title { font-size: 14px; line-height: 1.4; color: #111827; font-weight: 700; margin: 0 0 8px; }
.staff-card-body p { font-size: 12px; line-height: 1.6; color: #43586a; overflow-wrap: anywhere; }
.staff-card-actions { display: flex; justify-content: flex-end; margin-top: auto; padding-top: 12px; border-top: 1px solid #e3eaf0; }
.staff-access { display: inline-flex; gap: 8px; align-items: center; background: var(--staff-accent); border: 0; border-radius: 20px; color: #fff; padding: 7px 14px; font-size: 12px; font-weight: 700; }
.staff-access:hover { color: #fff; filter: brightness(.9); }
.staff-access:focus-visible { outline: 3px solid #245d83; outline-offset: 3px; }
.staff-unavailable { font-size: 12px; color: #526779; }
.staff-card-body .card-text { margin-bottom: 12px !important; }
@media (max-width: 1199px) { .staff-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
@media (max-width: 767px) { .staff-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; } .staff-section-heading { flex-wrap: wrap; } }
@media (max-width: 575px) { .staff-grid { grid-template-columns: 1fr; } .staff-section-heading h2 { font-size: 16px; } .staff-count { margin-left: 58px; } }
</style>
