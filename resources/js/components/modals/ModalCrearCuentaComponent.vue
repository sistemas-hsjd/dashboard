<template>
     <!-- sample modal content -->
    <div id="modalCrearCuenta" class="modal fade" tabindex="-1" aria-labelledby="modalCrearCuentaLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearCuentaLabel">Solicitar Cuenta Hospital San Juan de Dios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-10">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-3 mb-2">
                                                <div class="d-flex">
                                                    <input v-model="run" class="form-control" type="text" id="run" placeholder="11111111-1">
                                                    <button class="btn btn-primary ms-1" type="button" @click="getPersona()"><i class="bx bx-search-alt align-middle"></i></button>
                                                </div>
                                                 <span v-if="errors[`run`]" class="mensaje-error">
                                                    El RUN es obligatorio.
                                                 </span>
                                            </div>
                                        </div>

                                        <div v-for="(user, index) in usuarios" :key="index">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <div class="card border border-primary">
                                                            <div class="card-header bg-transparent border-primary header-card-cuenta">
                                                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>Datos Generales</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                        <div class="col-md-4">
                                                                            <label for="example-text-input" class="form-label">Nombre Completo</label>
                                                                            <input v-model="user.nombre_completo" class="form-control form-control-sm" type="text" id="nombre">
                                                                            <span v-if="errors[`nombre_completo_${index}`]" class="mensaje-error">
                                                                                El nombre es obligatorio.
                                                                            </span>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="example-text-input" class="form-label">Email</label>
                                                                            <input v-model="user.email" type="email" class="form-control form-control-sm"  id="apellido_materno">
                                                                            <span v-if="errors[`email_${index}`]" class="mensaje-error">
                                                                                El email es obligatorio.
                                                                            </span>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="example-text-input" class="form-label">Teléfono</label>
                                                                            <input v-model="user.telefono" class="form-control form-control-sm" type="text" id="apellido_paterno">
                                                                            <span v-if="errors[`telefono_${index}`]" class="mensaje-error">
                                                                                El teléfono es obligatorio.
                                                                            </span>
                                                                        </div>
                                                                        <!-- <div class="col-md-1">
                                                                        <a class="btn btn-outline-secondary btn-sm edit btn-add-cuenta" title="Añadir Fila"><i class="fas fa-plus" title="Agregar"></i></a>
                                                                        </div> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end row -->

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <div class="card border border-primary">
                                                            <div class="card-header bg-transparent border-primary header-card-cuenta">
                                                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>Datos cuenta San Juan de Dios</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row mb-3">
                                                                    <div class="col-md-6">
                                                                        <label for="example-text-input" class="form-label">Servicio</label>
                                                                        <v-select v-model="user.servicio" :reduce="unidad => unidad.tx_descripcion" :options="unidades" label="tx_descripcion" id="unidad_id" placeholder="Seleccione..."></v-select>
                                                                        <span v-if="errors[`servicio_${index}`]" class="mensaje-error">
                                                                            El Servicio es obligatorio.
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="example-text-input" class="form-label">Estamento</label>
                                                                        <v-select v-model="user.estamento" :reduce="estamento => estamento.tx_descripcion" :options="estamentos" label="tx_descripcion" id="estamento_id" placeholder="Seleccione..." @update:model-value="selectedEstamento"></v-select>
                                                                         <span v-if="errors[`estamento_${index}`]" class="mensaje-error">
                                                                            El Estamento es obligatorio.
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <!-- end row -->

                                                                <div class="row" v-if="user.estamento=='BECADO'">
                                                                    <div class="col-md-4">
                                                                        <label for="example-text-input" class="form-label">RUN Tutor</label>
                                                                        <input v-model="user.RUN_tutor" class="form-control form-control-sm" type="text" id="apellido_materno">
                                                                        <span v-if="errors[`RUN_tutor_${index}`]" class="mensaje-error">
                                                                            El RUN Tutor es obligatorio.
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Inicio Rotación</label>
                                                                            <input v-model="user.inicio_rotacion" type="date" class="form-control form-control-sm" id="datepicker-basic">
                                                                            <span v-if="errors[`inicio_rotacion_${index}`]" class="mensaje-error">
                                                                                El Inicio rotación es obligatorio.
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Término Rotación</label>
                                                                            <input v-model="user.fin_rotacion" type="date" class="form-control form-control-sm" id="datepicker-basic">
                                                                            <span v-if="errors[`fin_rotacion_${index}`]" class="mensaje-error">
                                                                                El Fin rotación es obligatorio.
                                                                            </span>
                                                                        </div>
                                                                    </div>                                                                
                                                                </div>
                                                                <!-- end row -->
                                                            </div>
                                                            <!-- end card-body -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end row -->
                                        </div>
                                        <a class="btn btn-primary" @click="solicitarCuenta()">Solicitar Cuenta</a>
                                    </div>
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light">Crear Cuenta</button>
                </div> -->
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</template>
<script>
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import { Spanish } from "flatpickr/dist/l10n/es.js";
export default {
    components:{
        flatpickr,
         vSelect
    },
  data() {
    return {
        errors:{},
        run:'',
        desarrolladores:[],
        unidades:[],
        estamentos:[],
        tecnicos:[],
        usuarios: [
            {
                run: '',
                nombre_completo:'',
                telefono: '',
                email:'',
                servicio:'',
                estamento:'',
                RUN_tutor: '',
                inicio_rotacion:'',
                fin_rotacion:''
            }
        ],
        telefono:'',
        email:''
    };
  },
  methods: {
    getInfo(){
        axios.post('api/data-inicial')
        .then(response => {
            console.log(response.data);
            const { estamentos, unidades } = response.data
            this.unidades = unidades
            this.estamentos = estamentos
        
        })
        .catch(error => {
            console.error('Error: ', error);
        });
    },
    getPersona(){
        var data = new FormData();
        data.append('run', this.run)
        axios.post('api/get-persona', data)
        .then(response => {
            console.log(response.data);
            this.mapearParametros(response.data)
        })
        .catch(error => {
            console.error('Error: ', error);
        });
    },
    mapearParametros(respuesta) {
        let datos = Array.isArray(respuesta) ? respuesta : [respuesta];
        this.usuarios = datos.map(item => ({
            run: item.run || '', 
            nombre_completo: item.nombre_completo || '', 
            telefono: item.telefono || ''
        }));
    },
    selectedEstamento(value){
        this.usuarios[0].RUN_tutor = ''
        this.usuarios[0].inicio_rotacion = ''
        this.usuarios[0].fin_rotacion = ''
        //this.usuarios[0].email = ''
    },
    solicitarCuenta(){
        if(this.validarErrores()){
            var data = new FormData()
            data.append('cuentas', JSON.stringify(this.usuarios))
            data.append('run', this.run)
            axios.post('api/solicitar-cuenta', data)
            .then(response => {
                console.log(response.data)
            })
            .catch(error => {
                console.error('Error: ', error);
            });
        }
    },
    validarErrores(){
        let validate = true
        this.errors = {}

        if(!this.run){
            this.errors[`run`] = true;
        }

        this.usuarios.forEach((val, index) => {
            if (val.nombre_completo?.trim() === '') {
                this.errors[`nombre_completo_${index}`] = true;
            }
                
            if (val.telefono?.trim() === '') {
                this.errors[`telefono_${index}`] = true;
            }
            
            if (val.email?.trim() === '' || val.email==null) {
                this.errors[`email_${index}`] = true;
            }

            if (val.servicio?.trim() === '' || val.servicio == null) {
                this.errors[`servicio_${index}`] = true;
            }
            if (val.estamento?.trim() === '' || val.estamento == null) {
                this.errors[`estamento_${index}`] = true;
            }

            if(val.estamento=='BECADO'){
                if (val.RUN_tutor?.trim() === '') {
                    this.errors[`RUN_tutor_${index}`] = true;
                }
                if (val.inicio_rotacion?.trim() === '') {
                    this.errors[`inicio_rotacion_${index}`] = true;
                }
                if (val.fin_rotacion?.trim() === '') {
                    this.errors[`fin_rotacion_${index}`] = true;
                }
            }
        });

       
        const numeroDeErrores = Object.keys(this.errors).length;
        console.log(numeroDeErrores)
        if(numeroDeErrores>0){
            validate = false
        }
        return validate
    }
    
  },
  mounted() {
    this.getInfo()
  }
};
</script>
<style scoped>
.header-card-cuenta{
    padding: .2em;
}
.btn-add-cuenta{
    margin-top: 2.5em;
}
</style>