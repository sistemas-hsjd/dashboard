<template>
  <div>
    <div class="row" v-for="(row, rowIndex) in chunkedSistemas" :key="'row-' + rowIndex">
      <div class="col-sm-6 col-xl-3" v-for="sistema in row" :key="sistema.id">
        <div class="card custom-card">
            <div class="image-container">
                <img class="card-img-top img-fluid" :src="`assets/images//img-portal/${sistema.tx_imagen}`" alt="Card image cap">
                <div class="overlay-button">
                    <a v-if="sistema.enlace"
                        class="btn btn-outline-light waves-effect"
                        :href="sistema.enlace"
                        target="_blank">
                        Ingresar
                    </a> 
                <button v-else
                        class="btn btn-outline-light waves-effect"
                        @click="abrirModal(sistema)">
                    Ingresar
                </button>
                </div>
            </div>

            <div class="card-body small-padding">
                <h4 class="card-title">{{ sistema.tx_descripcion }}</h4>
                <p class="card-text mb-0">{{ sistema.descripcion }}</p>
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
           enlaces:[]
        }
    },
  computed: {
    chunkedSistemas() {
      // Divide el array en grupos de 4 elementos
      const chunkSize = 4;
      const chunks = [];
      for (let i = 0; i < this.sistemas.length; i += chunkSize) {
        chunks.push(this.sistemas.slice(i, i + chunkSize));
      }
      return chunks;
    }
  },
  methods: {
    getSistemas(){
        axios.post('api/get-mis-sistemas')
        .then(response => {
            console.log(response.data); 
            this.sistemas = response.data.mis_sistemas
     
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