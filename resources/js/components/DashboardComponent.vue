<template>
  <div>
    <div class="hospital-grid" aria-label="Aplicaciones hospitalarias">
      <article v-for="(cat, index) in categorias" :key="cat.id"
               class="hospital-card" :style="cardTheme(cat, index)">
        <div class="hospital-card-visual" aria-hidden="true">
          <i class="mdi hospital-card-watermark" :class="cardIcon(cat)"></i>
          <span class="hospital-card-icon"><i class="mdi" :class="cardIcon(cat)"></i></span>
        </div>
        <div class="hospital-card-body">
          <span class="hospital-card-badge">
            <span aria-hidden="true">•</span>
            {{ cat.enlace ? 'Acceso directo' : `${(cat.enlaces || []).length} aplicativos` }}
          </span>
          <h2>{{ cat.nombre }}</h2>
          <p>{{ cat.descripcion }}</p>
          <div class="hospital-card-actions">
            <a v-if="cat.enlace" :href="cat.enlace" target="_blank" rel="noopener noreferrer"
               class="hospital-card-button" :aria-label="`Ir a ${cat.nombre} (abre en otra pestaña)`">
              Ir <i class="mdi mdi-arrow-right" aria-hidden="true"></i>
            </a>
            <button v-else type="button" class="hospital-card-button" @click="abrirModal(cat)"
                    :aria-label="`Ver aplicativos de ${cat.nombre}`">
              Ver <i class="mdi mdi-arrow-right" aria-hidden="true"></i>
            </button>
          </div>
        </div>
      </article>
    </div>
    
    <modalEnlacesComponent :enlaces="enlaces" :titulo="categoriaSeleccionada" ref="modalEnlaces"></modalEnlacesComponent>
    <modalCrearCuentaComponent></modalCrearCuentaComponent>
    <modalDesarrolloComponent></modalDesarrolloComponent>
    <modalNewSoporteComponent></modalNewSoporteComponent>
    <PopupComponent></PopupComponent>
  </div>
</template>

<script>
import modalEnlacesComponent from './modals/ModalEnlacesComponet.vue'
import modalDesarrolloComponent from './modals/ModalDesarrolloComponent.vue'
import modalNewSoporteComponent from './modals/modalNewSoporteComponent.vue'
import modalCrearCuentaComponent from './modals/ModalCrearCuentaComponent.vue'
import PopupComponent  from './elements/PopupComponent.vue';
export default {
  name: 'CategoriasGrid',
    components: {
        modalEnlacesComponent,
        modalDesarrolloComponent,
        modalCrearCuentaComponent,
        PopupComponent,
        modalNewSoporteComponent
    },
   data() {
        return {
           categorias:[],
           enlaces:[],
           categoriaSeleccionada: ''
        }
    },
  methods: {
    categoryName(cat) {
      return (cat.nombre || '').normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase();
    },
    cardIcon(cat) {
      const name = this.categoryName(cat);
      if (name.includes('minister')) return 'mdi-flag-outline';
      if (name.includes('ficha')) return 'mdi-clipboard-pulse-outline';
      if (name.includes('farmacia') || name.includes('abastecimiento')) return 'mdi-medical-bag';
      if (name.includes('administrativ')) return 'mdi-briefcase-outline';
      if (name.includes('establecimiento')) return 'mdi-hospital-building';
      if (name.includes('utilitario')) return 'mdi-tools';
      if (name.includes('epidemi')) return 'mdi-virus-outline';
      if (name.includes('document') || name.includes('calidad')) return 'mdi-file-document-multiple-outline';
      if (name.includes('sivea')) return 'mdi-shield-alert-outline';
      return 'mdi-web';
    },
    cardTheme(cat, index) {
      const palettes = [
        ['#397db5', '#d5e7f6'], ['#258f7e', '#d4eee6'],
        ['#7964c5', '#e5dff5'], ['#bc7045', '#fce5d6'],
        ['#c65d7b', '#f8dee7'], ['#328ea5', '#d6eff4'],
        ['#579348', '#e2f0d8'], ['#ac8421', '#fcf0cf'],
        ['#5b63b3', '#e2e5f7'], ['#258f7e', '#d4eee6']
      ];
      const [accent, pastel] = palettes[index % palettes.length];
      return { '--card-accent': accent, '--card-pastel': pastel };
    },
     getCategorias(){
        axios.post('api/get-info')
        .then(response => {
            this.categorias = response.data.categorias         
        })
        .catch(error => {
            console.error('Error: ', error);
        });
    },
    async abrirModal(cat) {
        this.categoriaSeleccionada = cat.nombre || 'Aplicaciones hospitalarias';
        this.enlaces = Array.isArray(cat.enlaces) ? [...cat.enlaces] : [];
        await this.$nextTick();
        const modalElement = document.getElementById('modalEnlaces');
        const Modal = window.bootstrap.Modal;
        const modal = Modal.getInstance(modalElement) || new Modal(modalElement);
        modal.show();
    }
  }, 
  mounted(){
    this.getCategorias()
  }
}
</script>
