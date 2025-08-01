<template>
  <div>
    <div class="card border border-success">
      <div class="card-header bg-transparent border-success card-header_sistemas">
        <h5 class="my-0 text-success"><i class="mdi mdi-check-all me-3"></i>Sistemas Locales</h5>

        <button type="button" class="btn btn-primary waves-effect waves-light" @click="abrirExcel">Abrir excel</button>
      </div>
      <div class="card-body">
          <div class="row" v-for="(row, rowIndex) in chunkedSistemas" :key="'row-' + rowIndex">
            <div class="col-sm-6 col-xl-3" v-for="sistema in row" :key="sistema.id">
              <div class="card custom-card">
                  <div class="image-container">
                      <img class="card-img-top img-fluid" :src="`assets/images/img-portal/${sistema.img}`" :alt="`${sistema.img}`">
                      <div class="overlay-button">
                        <template v-if="sistema.id == 22 || sistema.id == 22 || sistema.id == 24 || sistema.id == 20 || sistema.id == 21 || sistema.id == 19">
                          <a v-if="sistema.tx_direccion"
                              class="btn btn-outline-light waves-effect"
                              :href="sistema.tx_direccion"
                              target="_blank">
                              Ingresar
                          </a> 
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
    
    <div class="card border border-primary">
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
                        <a v-if="sistema.tx_direccion"
                            class="btn btn-outline-light waves-effect"
                            :href="sistema.tx_direccion"
                            target="_blank">
                            Ingresar
                        </a>     
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
  
    <modalCrearCuentaComponent></modalCrearCuentaComponent>
    <modalSoporteComponent></modalSoporteComponent>
  </div>
</template>

<script>

import modalSoporteComponent from './modals/ModalSoporteComponent.vue'
import modalCrearCuentaComponent from './modals/ModalCrearCuentaComponent.vue'
export default {
  name: 'MisSistemasGrid',
    components: {
        modalSoporteComponent,
        modalCrearCuentaComponent
    },
   data() {
        return {
           sistemas :[],
           enlaces:[],
           sistemasDefaults:[]
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
      
    abrirExcel(){
      console.log('desde abrir ')
        axios.get('/api/abrir-excel')
        .then(response => {
            console.log(response.data)
        })
        .catch(error => {
            console.error('Error: ', error);
        });
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
    abrirModal(cat) {
        this.enlaces = []
        this.enlaces = cat.enlaces
        // Aquí puedes manejar lógica adicional, como cargar un iframe
        $('#modalEnlaces').modal('show')
    }
  }, 
  mounted(){
    this.getSistemas()
  }
}
</script>

<style scoped>
  .card-header_sistemas{
      padding: .5em !important;
  }
</style>