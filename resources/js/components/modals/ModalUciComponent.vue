<template>
    <!--  Extra Large modal example -->
    <div id="modalUci" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalUci">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-white" id="modalUci">Links Fichas (UCI -  STI - UCIQ)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row mb-3">
                            <div class="col-xl-12">
                                <h4 class="mb-0 flex-grow-1 text-white">Links UCI</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-md-6">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                             <div class="col-6">
                                                <span class="text-muted mb-3 d-block text-truncate">Ingresar</span>
                                                <h2 class="mb-3">
                                                    <i class="dripicons-link"></i>
                                                </h2>
                                            </div>
        
                                            <div class="col-6">
                                               <div class="mt-1 pt-2">
                                                    <a class="btn btn-primary w-100" @click="fetchAccess('uci')">Acceso Access – Ficha UCI <i class="mdi mdi-arrow-right ms-1"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
        
                            <div class="col-xl-4 col-md-6">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                             <div class="col-6">
                                                <span class="text-muted mb-3 d-block text-truncate">Ingresar</span>
                                                <h2 class="mb-3">
                                                    <i class="dripicons-link"></i>
                                                </h2>
                                            </div>
                                            <div class="col-6">
                                               <div class="mt-1 pt-2">
                                                    <a class="btn btn-primary w-100" @click="fetchAccess('sti')">Acceso Access – Ficha STI<i class="mdi mdi-arrow-right ms-1"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
        
                            <div class="col-xl-4 col-md-6">
                                <!-- card -->
                                <div class="card card-h-100">
                                    <!-- card body -->
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <span class="text-muted mb-3 d-block text-truncate">Ingresar</span>
                                                <h2 class="mb-3">
                                                    <i class="dripicons-link"></i>
                                                </h2>
                                            </div>
        
                                            <div class="col-6">
                                               <div class="mt-1 pt-2">
                                                    <a class="btn btn-primary w-100" @click="fetchAccess('uciq')">Acceso Access – Ficha UCIQ <i class="mdi mdi-arrow-right ms-1"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
        
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