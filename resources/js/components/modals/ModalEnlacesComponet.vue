<template>
    <!--  Extra Large modal example -->
    <div id="modalEnlaces" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalEnlaces">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEnlaces"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row" v-for="(row, rowIndex) in chunkedEnlaces" :key="'row-' + rowIndex">
                        <div class="col-sm-6 col-xl-3" v-for="enlace in row" :key="enlace.id">
                            <!-- {{ enlace.url }} -->
                            <div class="card">
                                <img class="card-img-top img-fluid img_modal_enl" :src="enlace.url" alt="Card image cap">
                                <div class="card-body">
                                    <h6 class="card-title title_enlaces">{{ enlace.nombre }}</h6>
                                    <p class="card-text mb-0">{{ enlace.descripcion }}</p>
                                </div>
                                <div class="card-footer">
                                    <a v-if="enlace.enlace" class="btn btn-outline-success waves-effect waves-light" :href="enlace.enlace" target="_blank">Ingresar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</template>
<script>
export default {
    props: {
        enlaces: {
            type: Object,
            required: true
        }
    },
  data() {
    return {
        // enlaces:[],
    };
  },
  computed: {
    chunkedEnlaces() {
      const chunkSize = 4;
      const chunks = [];
      for (let i = 0; i < this.enlaces.length; i += chunkSize) {
        chunks.push(this.enlaces.slice(i, i + chunkSize));
      }
      return chunks;
    }
  },
  methods: {

  },
  mounted() {
  
  }
};
</script>
<style scoped>
.title_enlaces{
    font-size: .9em !important;
}

.img_modal_enl {
    width: 100%;
    height: 109px;     
    object-fit: cover;
}
</style>