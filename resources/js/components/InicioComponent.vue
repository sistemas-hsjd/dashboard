<template>
  <div>
    <div class="card border">
      <div class="card-header bg-transparent border-success card-header_sistemas">
        <h5 class="my-0 text-success"><i class="mdi mdi-check-all me-3"></i>Sistemas Locales</h5>
      </div>
      <div class="card-body">
          <div class="row" v-for="(row, rowIndex) in chunkedSistemas" :key="'row-' + rowIndex">
            <div class="col-sm-6 col-xl-3" v-for="sistema in row" :key="sistema.id">
              <div class="card custom-card">
                  <div class="image-container">
                      <img class="card-img-top img-fluid" :src="`assets/images/img-portal/${sistema.img}`" :alt="`${sistema.img}`">
                      <div class="overlay-button">
                        <template v-if="sistema.id == 22 || sistema.id == 24 || sistema.id == 20 || sistema.id == 21 || sistema.id == 19">
                          <a v-if="sistema.tx_direccion"
                              class="btn btn-outline-light waves-effect"
                              :href="sistema.tx_direccion"
                              target="_blank">
                              Ingresar
                          </a> 
                        </template>
                        <template v-else-if="sistema.id === 10000000">
                            <button
                              class="btn btn-outline-light waves-effect"
                              @click="abrirAcess()">
                              Ingresar        
                            </button>
                        </template>
                        <template v-else>
                          <a v-if="sistema.tx_direccion"
                              class="btn btn-outline-light waves-effect"
                              :href="sistema.url_final"
                              target="_blank">
                              Ingresar
                          </a> 
                          <button v-else
                                  class="btn btn-outline-light waves-effect"
                                  @click="abrirModal(sistema.tx_direccion)">
                                  Ingresar
                          </button>
                        </template>
                          
                      </div>
                  </div>

                  <div class="card-body small-padding card-header_sistemas">
                      <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                      <p class="card-text mb-0">{{ sistema.descripcion }}</p>
                  </div>
                </div>
            </div>
          </div>
      </div>
    </div>
    
    <div class="card border">
      <div class="card-header bg-transparent border-primary card-header_sistemas">
        <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>Plataformas de apoyo</h5>
      </div>
      <div class="card-body">
       <div class="row" v-for="(row, rowIndex) in chunkedSistemasDefaults" :key="'row-' + rowIndex">
          <div class="col-sm-6 col-xl-3" v-for="sistema in row" :key="sistema.id">
            <div class="card custom-card">
                <div class="image-container">
                    <img class="card-img-top img-fluid" :src="`assets/images/img-portal/${sistema.img}`" :alt="`${sistema.img}`">
                    <div class="overlay-button">
                      <template v-if="(sistema.estado == 0 && sistema.id === 24) || (sistema.estado == 0 && sistema.id === 20)">
                        <a v-if="sistema.tx_direccion"
                            class="btn btn-outline-light waves-effect"
                            :href="sistema.tx_direccion_contingencia"
                            target="_blank">
                            Ingresar
                        </a> 
                      </template>
                      <template v-else>
                         <a v-if="sistema.tx_direccion"
                            class="btn btn-outline-light waves-effect"
                            :href="sistema.tx_direccion"
                            target="_blank">
                            Ingresar
                        </a> 
                      </template>
                    </div>
                </div>

                <div class="card-body small-padding card-header_sistemas">
                  
                   <template v-if="sistema.estado == 0 && sistema.id === 24">
                      <h4 class="card-title">TracKare de Contingencia</h4>
                       <p class="card-text mb-0 text-danger">En caso de presentar inconvenientes para el ingreso,<br> por favor comuníquese al número <strong>{{ sistema.encargado.telefono }}</strong>.</p>
                    </template>
                    <template v-else-if="sistema.estado == 0 && sistema.id === 20">
                      <h4 class="card-title">Laboratorio Clínico Contingencia <br>User:LABO Pass: Labo1234</h4>
                    </template>
                    <template v-else-if="sistema.id === 24">
                        <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                        <p class="card-text mb-0 text-primary">En caso de presentar inconvenientes para el ingreso,<br> por favor comuníquese al número <strong>{{ sistema.encargado.telefono }}</strong>.</p>
                    </template>
                    <template v-else-if="sistema.id === 20">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">En caso de presentar inconvenientes para el ingreso,<br> por favor comuníquese al correo eléctronico <strong>{{ sistema.encargado.email }}</strong>.</p>
                    </template>
                    <template v-else-if="sistema.id === 19">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">En caso de presentar inconvenientes para el ingreso,<br> por favor comuníquese al número <strong>{{ sistema.encargado.telefono }}</strong>.</p>
                    </template>
                    <template v-else-if="sistema.id === 22">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">En caso de presentar inconvenientes para el ingreso,<br> por favor comuníquese al número <strong>{{ sistema.encargado.telefono }}</strong>.</p>
                    </template>
                    <template v-else-if="sistema.id === 23">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">En caso de presentar inconvenientes para el ingreso,<br> por favor comuníquese al número <strong>{{ sistema.encargado.telefono }}</strong>.</p>
                    </template>
                    <template v-else-if="sistema.id === 25">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                          <p class="card-text mb-0 text-primary">En caso de presentar inconvenientes para el ingreso,<br> por favor comuníquese al número <strong>{{ sistema.encargado.telefono }}</strong>.</p>
                    </template>
                    <template v-else-if="sistema.id === 26">
                          <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                    </template>

                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  
    <modalCrearCuentaComponent></modalCrearCuentaComponent>
    <modalEstadosEnlacesComponent></modalEstadosEnlacesComponent>
    <modalDesarrolloComponent></modalDesarrolloComponent>
    <modalNewSoporteComponent></modalNewSoporteComponent>
    <ModalUciComponent></ModalUciComponent>
    
    <!-- <TourNuevoMenu></TourNuevoMenu> -->
    <div v-if="iniciarPupUP">
        <div v-if="showImagePopup" class="image-popup" @click.self="cerrarPopup">
          <img :src="popupImage" class="popup-img" />
          <button class="close-btn" @click="cerrarPopup">✕</button>
        </div>
    </div>
  
  </div>
</template>

<script>

import modalDesarrolloComponent from './modals/ModalDesarrolloComponent.vue';
import modalNewSoporteComponent from './modals/modalNewSoporteComponent.vue';
import modalCrearCuentaComponent from './modals/ModalCrearCuentaComponent.vue';
import ModalEstadosEnlacesComponent from './modals/ModalEstadosEnlacesComponent.vue';
import ModalUciComponent from './modals/ModalUciComponent.vue';
// import TourNuevoMenu  from './elements/TourNuevoMenuCompoent.vue';

export default {
  name: 'MisSistemasGrid',
    components: {
        modalDesarrolloComponent,
        modalCrearCuentaComponent,
        ModalEstadosEnlacesComponent,
        ModalUciComponent,
        modalNewSoporteComponent,
        // TourNuevoMenu,
    },
   data() {
        return {
          iniciarPupUP: false,
          sistemas :[],
          enlaces:[],
          sistemasDefaults:[],
          user:[],
          // popup
          showImagePopup: false,
          popupImage: '', 
          popupActivo:[]
        }
    },
  computed: {
    chunkedSistemas() {
      const chunkSize = 4;
      const chunks = [];
      for (let i = 0; i < this.sistemas.length; i += chunkSize) {
        chunks.push(this.sistemas.slice(i, i + chunkSize));
      }
      return chunks;
    },
    chunkedSistemasDefaults() {
      const chunkSize = 4;
      const chunks = [];
      for (let i = 0; i < this.sistemasDefaults.length; i += chunkSize) {
        chunks.push(this.sistemasDefaults.slice(i, i + chunkSize));
      }
      return chunks;
    }
  },
  methods: {
      mostrarImagenPopup(img) {
        this.popupImage = img;
        this.showImagePopup = true;
      },

    cerrarPopup() {
      this.showImagePopup = false;

      // CLAVE: guardar que el usuario lo cerró
      //localStorage.setItem('popup_cerrado', '1');
    },
    abrirAcess(){
      $('#modalUci').modal('show')
    },
    getSistemas(){
        axios.post('api/get-mis-sistemas')
        .then(response => {
          this.sistemas = response.data.mis_sistemas
          this.sistemasDefaults = response.data.defaultSistemas
          console.log(this.sistemasDefaults)
        })
        .catch(error => {
            console.error('Error: ', error);
        });
    },
    getPermisoPopup(){
        axios.post('api/get-permiso-pop-up')
        .then(response => {
            console.log('Permiso PopUp:', response.data);
            this.popupActivo = response.data;
            if(this.popupActivo && this.popupActivo.mostrar_popup) {
                this.iniciarPupUP = true;
            }
            console.log('Popup Activo:', this.popupActivo);
     
        })
        .catch(error => {
            console.error('Error al obtener el permiso del PopUp:', error);
            return null;
        });
    },
    abrirModal(cat) {
        this.enlaces = []
        this.enlaces = cat.enlaces
        // Aquí puedes manejar lógica adicional, como cargar un iframe
        $('#modalEnlaces').modal('show')
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
    this.getPermisoPopup()

      // revisar si el usuario ya lo cerró
      const cerrado = localStorage.getItem('popup_cerrado');

      if (!cerrado) {
        setTimeout(() => {
          this.mostrarImagenPopup('assets/images/1777389396-AFICHES PROMO-01.jpg');
        }, 1000);
      }

  }
}
</script>

<style scoped>
  .card-header_sistemas{
      padding: .5em !important;
  }

  .image-popup {
  position: fixed;
  bottom: 20px;   /* distancia desde abajo */
  right: 20px;    /* distancia desde la derecha */
  z-index: 9999;

  background: #000;
  padding: 10px;
  border-radius: 12px;

  box-shadow: 0 10px 25px rgba(0,0,0,0.4);
}

/* imagen */
.popup-img {
  max-width: 325px;
  border-radius: 8px;
  display: block;
}

/* botón cerrar */
.close-btn {
  position: absolute;
  top: -10px;
  right: -10px;

  background: red;
  border: none;
  color: white;

  border-radius: 50%;
  width: 25px;
  height: 25px;

  cursor: pointer;
}
</style>