<template>
  <!-- Modal para Unidad de Informática -->
  <div id="modalInformatica" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
      <div class="modal-content">

        <!-- Header -->
        <div class="modal-header">
          <h5 class="modal-title">Unidad de Informática</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Body -->
        <div class="modal-body">
          <div class="chat-leftsidebar card">
            <div class="chat-leftsidebar-nav">

              <div class="chat-message-list" data-simplebar>
                <div class="pt-3">
                  <div class="px-3">
                    <h5 class="font-size-14 mb-3">
                      Mantenimiento, reparación y configuración de computadores, redes y dispositivos
                    </h5>
                  </div>

                  <ul class="list-unstyled chat-list">
                    <li v-for="tec in tecnicos" :key="tec.id">
                      <a href="#" class="d-flex align-items-center p-3 text-decoration-none">

                        <!-- Avatar -->
                        <div class="flex-shrink-0 avatar-sm me-3">
                          <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                            {{ tec.nombre.charAt(0) }}
                          </span>
                        </div>

                        <!-- Información -->
                        <div class="d-flex flex-grow-1 flex-column justify-content-center">
                          <h5 class="font-size-14 mb-1">
                            {{ tec.nombre }} {{ tec.apellido_paterno }} {{ tec.apellido_materno }}
                          </h5>

                          <div class="d-flex align-items-center">
                            <i class="bx bxs-envelope"></i>
                            <a class="info-email ms-2" :href="`mailto:${tec.email}`">{{ tec.email }}</a>
                          </div>

                          <div class="d-flex align-items-center mt-1">
                            <i class="bx bx-phone-call me-2"></i>
                            <span>{{ tec.telefono }}</span>
                          </div>
                        </div>

                        <!-- Badge de disponibilidad -->
                        <span v-if="tec.id === 10" class="badge bg-success rounded-pill">
                          Lunes a Domingo 24/7
                        </span>

                      </a>
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
  name: "ModalSoporteInformatica",
  data() {
    return {
      tecnicos: []
    };
  },
  methods: {
    getTecnicos() {
      axios
        .post("api/get-funcionarios")
        .then((response) => {
          this.tecnicos = response.data.tecnicos;
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    }
  },
  mounted() {
    this.getTecnicos();
  }
};
</script>

<style scoped>
.chat-list li {
  margin-bottom: 10px;
  border-radius: 5px;
  background-color: #f8f9fa;
  transition: background-color 0.2s ease;
}

.chat-list li:hover {
  background-color: #e9ecef;
}

.info-email {
  padding-top: 0.2em;
  border: none;
}

.avatar-sm {
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
}

.badge {
  font-size: 0.8rem;
}
</style>
