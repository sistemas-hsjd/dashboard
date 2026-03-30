<template>
    <div id="modalDesarrollo" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Unidad de Transformación Digital</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">

                    <div class="px-2">
                        <h6 class="mb-3 text-muted">Desarrolladores</h6>

                        <ul class="p-0 m-0">
                            <li class="contact-card"
                                v-for="desarrollador in desarrolladores"
                                :key="desarrollador.id">

                                <div class="card-body d-flex gap-3">

                                    <!-- Avatar -->
                                    <div class="avatar">
                                        {{ desarrollador.nombre.charAt(0) }}
                                    </div>

                                    <!-- Info -->
                                    <div class="flex-grow-1">
                                        <!-- Nombre + horario -->
                                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                            <div>
                                                <h6 class="mb-1 fw-semibold">
                                                    {{ desarrollador.nombre }}
                                                    {{ desarrollador.apellido_paterno }}
                                                    {{ desarrollador.apellido_materno }}
                                                </h6>
                                                <span v-if="desarrollador.id == 4" class="badge badge-horario" style="font-size: .7rem;">
                                                    Jefe de Desarrollo
                                                </span>

                                                <span v-if="desarrollador.id == 14" class="badge badge-horario" style="font-size: .7rem;">
                                                    Jefe de Unidad
                                                </span>
                                            </div>

                                            <span class="badge badge-horario">
                                                08:00 - 17:00 | Vie 08:00 - 16:00
                                            </span>
                                        </div>

                                        <!-- Sistemas -->
                                        <div class="mt-2 sistemas-list">
                                            <span v-for="sistema in desarrollador.sistemas"
                                                  :key="sistema.id"
                                                  class="badge badge-sistema">
                                                {{ sistema.nombre }}
                                            </span>
                                        </div>

                                        <!-- Contacto -->
                                        <div class="contact-info mt-2">
                                            <div>
                                                <i class="bx bxs-envelope"></i>
                                                <a :href="`mailto:${desarrollador.email}`">
                                                    {{ desarrollador.email }}
                                                </a>
                                            </div>
                                            <div v-if="desarrollador.telefono">
                                                <i class="bx bx-phone-call"></i>
                                                <span>{{ desarrollador.telefono }}</span>
                                            </div>
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

/* Card general */
.contact-card {
    list-style: none;
    margin-bottom: 12px;
}

.contact-card .card-body {
    background: #ffffff;
    border-radius: 10px;
    padding: 15px;
    border: 1px solid #e9ecef;
    transition: all 0.2s ease;
}

.contact-card .card-body:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transform: translateY(-2px);
}

/* Avatar */
.avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: #e7f1ff;
    color: #0d6efd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    flex-shrink: 0;
}

/* Sistemas */
.sistemas-list {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.badge-sistema {
    background: #e9f7ef;
    color: #198754;
    font-weight: 500;
}

/* Horario */
.badge-horario {
    background: #d1f7e1;
    color: #0f5132;
    font-weight: 600;
}

/* Contacto */
.contact-info {
    display: flex;
    gap: 20px;
    font-size: 0.9rem;
    color: #6c757d;
    flex-wrap: wrap;
}

.contact-info i {
    margin-right: 5px;
}

.contact-info a {
    color: inherit;
    text-decoration: none;
}

.contact-info a:hover {
    text-decoration: underline;
}

</style>