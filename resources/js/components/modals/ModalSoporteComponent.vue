<template>
    <div id="modalSoporte" class="modal fade bs-example-modal-xl" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Unidad de Transformación Digital</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div class="chat-leftsidebar card">
                        <div class="chat-leftsidebar-nav">

                            <div class="chat-message-list" data-simplebar>
                                <div class="pt-3">
                                    <div class="px-3">
                                        <h5 class="font-size-14 mb-3">Desarrolladores</h5>
                                    </div>

                                    <ul class="list-unstyled chat-list">
                                        <li class="unread"
                                            v-for="desarrollador in desarrolladores"
                                            :key="desarrollador.id">

                                            <!-- Tarjeta clicable -->
                                            <a href="#" class="full-link">
                                                <div class="d-flex align-items-start w-100">

                                                    <!-- Avatar -->
                                                    <div class="flex-shrink-0 user-img online me-3">
                                                        <div class="avatar-sm">
                                                            <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                                {{ desarrollador.nombre.charAt(0) }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- Información -->
                                                    <div class="overflow-hidden w-100">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h5 class="font-size-14 mb-1 text-truncate">
                                                                {{ desarrollador.nombre }}
                                                                {{ desarrollador.apellido_paterno }}
                                                                {{ desarrollador.apellido_materno }}
                                                            </h5>
                                                            <span class="badge bg-success rounded-pill">
                                                                08:00 a 17:00 | viernes 08:00 a 16:00
                                                            </span>
                                                        </div>

                                                        <!-- Sistemas -->
                                                        <div class="sistemas-list mt-1">
                                                            <span v-for="sistema in desarrollador.sistemas"
                                                                  :key="sistema.id"
                                                                  class="badge bg-info rounded-pill me-1 mb-1">
                                                                {{ sistema.nombre }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>

                                            <!-- Datos de contacto -->
                                            <div class="d-flex justify-content-center mt-1 px-2 datos_contact">
                                                <div class="d-flex flex-column">
                                                    <div>
                                                        <i class="bx bxs-envelope"></i>
                                                        <a class="info-email-dev ms-2"
                                                           :href="`mailto:${desarrollador.email}`">
                                                            {{ desarrollador.email }}
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <i class="bx bx-phone-call"></i>
                                                        <span class="ms-2 info-des">
                                                            {{ desarrollador.telefono }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            desarrolladores: []
        }
    },
    methods: {
        getFuncionarios() {
            axios.post('api/get-funcionarios')
                .then(response => {
                    this.desarrolladores = response.data.desarrolladores
                })
                .catch(error => {
                    console.error('Error:', error)
                })
        }
    },
    mounted() {
        this.getFuncionarios()
    }
}
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

.unread {
    position: relative;
}

.datos_contact {
    font-size: 1.1em;
    position: relative;
    top: -40px;
}

.info-email-dev {
    padding: 0;
    border: none;
}

.info-des {
    font-weight: 900;
}

.chat-leftsidebar .chat-leftsidebar-nav .nav .nav-link.active {
    background-color: #dfd4d4;
    color: #7a7fdc;
}
</style>
