<template>
  <div>
    <div class="row" v-for="(row, rowIndex) in chunkedCategorias" :key="'row-' + rowIndex">
      <div class="col-sm-6 col-xl-3" v-for="cat in row" :key="cat.id">
        <div class="card custom-card">
            <div class="image-container">
                <img class="card-img-top img-fluid" :src="cat.url" alt="Card image cap">
                <div class="overlay-button">
                    <a v-if="cat.enlace"
                        class="btn btn-outline-light waves-effect"
                        :href="cat.enlace"
                        target="_blank">
                        Ingresar
                    </a> 
                <button v-else
                        class="btn btn-outline-light waves-effect"
                        @click="abrirModal(cat)">
                    Ingresar
                </button>
                </div>
            </div>

            <div class="card-body small-padding">
                <h4 class="card-title">{{ cat.nombre }}</h4>
                <p class="card-text mb-0">{{ cat.descripcion }}</p>
            </div>
            </div>
      </div>
    </div>

    <!-- <div class="row">
        <div class="col-sm-6 col-xl-3">
            cardd
        </div>
    </div> -->

    <modalEnlacesComponent :enlaces="enlaces" ref="modalEnlaces"></modalEnlacesComponent>
    <modalSoporteComponent></modalSoporteComponent>
  </div>
</template>

<script>
import modalEnlacesComponent from './modals/ModalEnlacesComponet.vue'
import modalSoporteComponent from './modals/ModalSoporteComponent.vue'
export default {
  name: 'CategoriasGrid',
    components: {
        modalEnlacesComponent,
        modalSoporteComponent
    },
   data() {
        return {
           categorias:[],
           enlaces:[]
        }
    },
  computed: {
    chunkedCategorias() {
      // Divide el array en grupos de 4 elementos
      const chunkSize = 4;
      const chunks = [];
      for (let i = 0; i < this.categorias.length; i += chunkSize) {
        chunks.push(this.categorias.slice(i, i + chunkSize));
      }
      return chunks;
    }
  },
  methods: {
     getCategorias(){
            axios.post('api/get-info')
            .then(response => {
                console.log(response.data); 
                this.categorias = response.data.categorias         
            })
            .catch(error => {
                console.error('Error: ', error);
            });
    },
    abrirModal(cat) {
        this.enlaces = []
        this.enlaces = cat.enlaces
        // Aquí puedes manejar lógica adicional, como cargar un iframe
        console.log('Abrir modal para:', cat);
        $('#modalEnlaces').modal('show')
    }
  }, 
  mounted(){
    this.getCategorias()
  }
}
</script>