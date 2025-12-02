<template>
    <!--  Extra Large modal example -->
    <div id="modalVideo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalUci">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="modalVideoLetras">Cápsula</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                   <h1></h1>
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
    // props: {
    //     unidad: {
    //         type: Object,
    //         required: true
    //     }
    // },
  data() {
    return {

    };
  },
  computed: {

  },
  methods: {
    fetchAccess(tipo){
        var data = new FormData()
        data.append('tipo', tipo)
        axios.post('/api/abrir-access', data)
        .then(response => {
            console.log(response.data)
        })
        .catch(error => {
            console.error('Error: ', error);
        });
    }
  },
  mounted() {
  
  }
};
</script>
<style scoped>
.modal-backdrop.show {
  background-color: rgba(0, 0, 0, 0.6) !important;
}

.modal-content {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
  color: #fff;
}
</style>