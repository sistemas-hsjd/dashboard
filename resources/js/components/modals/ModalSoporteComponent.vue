<template>
    <!--  Extra Large modal example -->
    <div id="modalSoporte" class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="chat-leftsidebar card">
                        <div class="chat-leftsidebar-nav">
                            <ul class="nav nav-pills nav-justified bg-soft-light p-1">
                                <li class="nav-item">
                                    <a href="#chat" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                                        <i class="bx bx-chat font-size-20 d-sm-none"></i>
                                        <span class="d-none d-sm-block">Sistemas</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#groups" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        <i class="bx bx-group font-size-20 d-sm-none"></i>
                                        <span class="d-none d-sm-block">Equipos Redes</span>
                                    </a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="#contacts" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                                        <i class="bx bx-book-content font-size-20 d-sm-none"></i>
                                        <span class="d-none d-sm-block">Contacts</span>
                                    </a>
                                </li> -->
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane show active" id="chat">
                                    <div class="chat-message-list" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: -15px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
                                        <div class="pt-3">
                                            <div class="px-3">
                                                <h5 class="font-size-14 mb-3">Recent</h5>
                                            </div>
                                         <ul class="list-unstyled chat-list">
                                                <li class="unread" v-for="desarrollador in desarrolladores" :key="desarrollador.id">
                                                    <!-- Toda la tarjeta es clicable -->
                                                    <a href="#" class="full-link">
                                                    <div class="d-flex align-items-start w-100">
                                                        <!-- Avatar -->
                                                        <div class="flex-shrink-0 user-img online align-self-center me-3">
                                                        <div class="avatar-sm align-self-center">
                                                            <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                            {{ desarrollador.nombre.charAt(0) }}
                                                            </span>
                                                        </div>
                                                        <span class="user-status"></span>
                                                        </div>

                                                        <!-- Info -->
                                                        <div class="overflow-hidden w-100">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <h5 class="text-truncate font-size-14 mb-1">
                                                                {{ desarrollador.nombre }} {{ desarrollador.apellido_paterno }} {{ desarrollador.apellido_materno }}
                                                                </h5>
                                                                <!-- <div class="alert alert-info alert-dismissible alert-outline fade show mb-0" role="alert">
                                                                    <strong>{{ desarrollador.email }}</strong>
                                                                   
                                                                </div> -->
                                   
                                                                <span class="badge bg-success rounded-pill">disponible</span>
                                                            </div>

                                                            <!-- Sistemas como badges -->
                                                            <div class="sistemas-list mt-1">
                                                                <span v-for="sistema in desarrollador.sistemas" :key="sistema.id"
                                                                    class="font-size-13 badge bg-info rounded-pill me-1 mb-1">
                                                                    {{ sistema.nombre }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </a>

                                                    <!-- Datos de contacto -->
                                                    <div class="d-flex justify-content-center mt-1 px-2 small font-size-13 datos_contact">
                                                        <div class="d-flex flex-column">
                                                            <div class="ms-1">
                                                                <i class="bx bxs-envelope"></i>
                                                                <span class="info-des ms-3">{{ desarrollador.email }}</span>
                                                            </div>
                                                            <div>
                                                                <i class="bx bx-phone-call"></i>
                                                                <span class="info-des  ms-3">{{ desarrollador.telefono }}</span>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 686px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 423px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
                                </div>

                                <div class="tab-pane" id="groups">
                                    <div class="chat-message-list" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; overflow: hidden;"><div class="simplebar-content" style="padding: 0px;">
                                        <div class="pt-3">
                                            <div class="px-3">
                                                <h5 class="font-size-14 mb-3">Groups</h5>
                                            </div>
                                            <ul class="list-unstyled chat-list">
                                                <li v-for="tec in tecnicos" :key="tec.id">
                                                    <a href="#">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0 avatar-sm me-3">
                                                                <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                                    {{ tec.nombre.charAt(0) }}
                                                                </span>
                                                            </div>

                                                            <div class="flex-grow-1">
                                                                <h5 class="font-size-14 mb-0">{{ tec.nombre }} {{ tec.apellido_paterno }} {{ tec.apellido_materno }}</h5>
                                                                  <i class="bx bxs-envelope"></i>
                                                                <h5 class="font-size-14 mb-0">{{ tec.email }}</h5>
                                                                 <i class="bx bx-phone-call"></i>
                                                                <h5 class="font-size-14 mb-0">{{ tec.telefono }}</h5>
                                                            </div>
                                                      
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div></div></div></div><div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div></div>
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
  data() {
    return {
        desarrolladores:[],
        tecnicos:[]
    };
  },
  methods: {
    getFuncionarios(){
        axios.post('api/get-funcionarios')
        .then(response => { 
            const { desarrolladores, tecnicos } = response.data
            this.desarrolladores = desarrolladores
            this.tecnicos = tecnicos 

        })
        .catch(error => {
            console.error('Error: ', error);
        });
    }
  },
  mounted() {
    this.getFuncionarios()
  }
};
</script>
<style scoped>
.chat-list li {
  width: 100%;
  margin-bottom: 10px;
  border-radius: 5px;
  background-color: #f8f9fa;
  transition: background-color 0.2s ease;
}

.chat-list li:hover {
  background-color: #e9ecef;
}

.chat-list li a.full-link {
  display: block;
  width: 100%;
  padding: 10px 15px;
  color: inherit;
  text-decoration: none;
}

.sistemas-list {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
}
.info-des{
    font-weight: 900;
}
.unread{
    position: relative;
}

.datos_contact{
    font-size: 1.5em;
    position: relative;
    top:-50px
}
</style>