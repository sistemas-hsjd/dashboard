<template>
     <!-- sample modal content -->
    <div id="modalCrearCuenta" class="modal fade" tabindex="-1" aria-labelledby="modalCrearCuentaLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearCuentaLabel">Solicitar Cuenta Hospital San Juan de Dios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="changeEstado(), borrarForm()"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-10">
                                <div v-if="mensaje=='registrado' || mensaje=='rut falso'" class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                    <template v-if="mensaje=='registrado'">
                                        <i class="mdi mdi-block-helper label-icon"></i><strong>Usuario Registrado</strong> -  El usuario ya se encuentra registrado
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </template>
                                    <template v-if="mensaje=='rut falso'">
                                        <i class="mdi mdi-block-helper label-icon"></i><strong>Rut Inválido</strong> - ¡El RUN ingresado es incorrecto!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </template>
                                </div>

                                <div v-if="authenticated">
                                    <div v-if="!estadoSolicitud" class="alert alert-info alert-top-border alert-dismissible fade show mb-0 mb-3" role="alert">
                                        <i class="mdi mdi-alert-circle-outline text-info align-middle me-3"></i>
                                        <strong>Importante</strong> - 
                                        Para las cuentas de <strong>San Juan de Dios y Plataformas de Apoyo</strong>,
                                        es fundamental que cada solicitud corresponda a un solo estamento
                                    </div>
                                </div>

                                <div v-if="estadoSolicitud" class="alert alert-success alert-top-border alert-dismissible fade show" role="alert">
                                    <i class="mdi mdi-check-all me-3 align-middle text-success"></i><strong>Solicitud enviada</strong> - Su solicitud fue enviada correctamente, se notificará por email al Jefe de la unidad solicitante.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                              
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-md-3 mb-2">
                                                <div class="d-flex">
                                                    <input v-model="run" class="form-control" type="text" id="run" placeholder="11111111-1" @input="validarRutEnTiempoReal($event)">
                                                    <button class="btn btn-primary ms-1" type="button" @click="getPersona()"><i class="bx bx-search-alt align-middle"></i></button>
                                                </div>
                                                 <span v-if="errors[`run`]" class="mensaje-error">
                                                    El RUN es obligatorio.
                                                 </span>
                                            </div>
                                        </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <div class="card border border-primary">
                                                            <div class="card-header bg-transparent border-primary header-card-cuenta d-flex justify-content-between">
                                                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>Datos Generales</h5>
                                                                <!-- <a v-if="btnAddDel" class="btn btn-outline-secondary btn-sm" title="Añadir Fila" @click="addUser()"><i class="fas fa-plus" title="Agregar"></i></a> -->
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row" v-for="(user, index) in usuarios" :key="index">
                                                                        <div class="col-md-2">
                                                                            <label :for="`run_${index}`" class="form-label">RUN</label>
                                                                            <input v-model="user.run" class="form-control form-control-sm" type="text" :id="`run_${index}`" readonly>
                                                                            <span v-if="errors[`run_${index}`]" class="mensaje-error">
                                                                                El RUN es obligatorio.
                                                                            </span>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label for="example-text-input" class="form-label">Nombre Completo</label>
                                                                            <input v-model="user.nombre_completo" class="form-control form-control-sm" type="text" :id="`nombre_completo_${index}`" readonly>
                                                                            <span v-if="errors[`nombre_completo_${index}`]" class="mensaje-error">
                                                                                El nombre es obligatorio.
                                                                            </span>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label for="example-text-input" class="form-label">Email</label>
                                                                            <input v-model="user.email" type="email" class="form-control form-control-sm"  :id="`email_${index}`">
                                                                            <span v-if="errors[`email_${index}`]" class="mensaje-error">
                                                                                El email es obligatorio.
                                                                            </span>
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label for="example-text-input" class="form-label">Teléfono</label>
                                                                            <input v-model="user.telefono" class="form-control form-control-sm" type="text" :id="`telefono_${index}`">
                                                                            <span v-if="errors[`telefono_${index}`]" class="mensaje-error">
                                                                                El teléfono es obligatorio.
                                                                            </span>
                                                                        </div>
                                                                        <div class="col-md-1 btn_eliminar_user">
                                                                            <button v-if="btnAddDel" type="button" class="btn-sm btn-soft-danger waves-effect waves-light" @click="removeParam(index)"><i class="mdi mdi-trash-can d-block font-size-14"></i></button>
                                                                        </div>
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
                                                                        <v-select v-model="servicio" :reduce="unidad => unidad.id" :options="servicios" label="tx_descripcion" id="unidad_id" placeholder="Seleccione..."></v-select>
                                                                        <span v-if="errors[`servicio`]" class="mensaje-error">
                                                                            El Servicio es obligatorio.
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="example-text-input" class="form-label">Estamento</label>
                                                                        <v-select v-model="estamento" :reduce="estamento => estamento.id" :options="estamentos" label="tx_descripcion" id="estamento_id" placeholder="Seleccione..." @update:model-value="selectedEstamento"></v-select>
                                                                         <span v-if="errors[`estamento`]" class="mensaje-error">
                                                                            El Estamento es obligatorio.
                                                                        </span>
                                                                    </div>
                                                                </div>

                                                                <!-- end row -->
                                                                <div class="row" v-if="estamento==39 || estamento==45">
                                                                    <div class="col-md-4">
                                                                        <label for="example-text-input" class="form-label">RUN Tutor</label>
                                                                        <input v-model="RUN_tutor" class="form-control form-control-sm" type="text" id="RUN_tutor" @input="validarRutEnTiempoReal($event)" @change="getTutor($event)">
                                                                        <span v-if="errors[`RUN_tutor`]" class="mensaje-error">
                                                                            El RUN Tutor es obligatorio.
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Inicio Rotación</label>
                                                                            <input v-model="inicio_rotacion" type="date" class="form-control form-control-sm" id="datepicker-basic">
                                                                            <span v-if="errors[`inicio_rotacion`]" class="mensaje-error">
                                                                                El Inicio rotación es obligatorio.
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Término Rotación</label>
                                                                            <input v-model="fin_rotacion" type="date" class="form-control form-control-sm" id="datepicker-basic">
                                                                            <span v-if="errors[`fin_rotacion`]" class="mensaje-error">
                                                                                El Fin rotación es obligatorio.
                                                                            </span>
                                                                            <span v-if="errors[`fin_rotacion_menor`]" class="mensaje-error">
                                                                                El Fin rotación no puede ser menor al inicio.
                                                                            </span>
                                                                            
                                                                        </div>
                                                                    </div>                                                                
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label for="example-text-input" class="form-label">Sistemas</label>
                                                                        <v-select multiple v-model="sistemasSolicitados" :reduce="sistema => sistema.id" :options="sistemas" label="tx_descripcion" id="sistema_users" placeholder="Seleccione..."></v-select>
                                                                        <span v-if="errors[`sistemasSolicitados`]" class="mensaje-error">
                                                                            Los Sistemas solicitados es obligatorio.
                                                                        </span>
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
        authenticated:'',
        errors:{},
        run:'',
        servicios:[],
        estamentos:[],
        sistemas:[],
        sistemasSolicitados:[],
        estamento:'',
        servicio:'',
        RUN_tutor:'',
        inicio_rotacion:'',
        fin_rotacion:'',
        usuarios: [
            {
                run: '',
                nombre_completo:'',
                telefono: '',
                email:''
            }
        ],
        telefono:'',
        email:'',
        user:[],
        jefatura:[],
        btnAddDel:false,
        estadoSolicitud: false,
        mensaje:''
    };
  },
  methods: {
    addUser(){
        if(this.usuarios.length<10){
            this.usuarios.push({
                run: '',
                nombre_completo:'',
                telefono: '',
                email:''  
            });
        }
    },
    removeParam(index) {
        if(this.usuarios.length>1){
            this.usuarios.splice(index, 1);
        }
    },
    getInfo(){
        axios.post('api/data-inicial')
        .then(response => {
            console.log(response.data);
            const { estamentos, servicios, sistemas } = response.data
            this.servicios = servicios
            this.estamentos = estamentos
            this.sistemas = sistemas
        })
        .catch(error => {
            console.error('Error: ', error);
        });
    },
    getPersona(){
        this.mensaje = ''
        var data = new FormData();
        data.append('run', this.run)
        axios.post('api/get-persona', data)
        .then(response => {
            console.log(response.data);

            if (response.data !== 'no hay rut' && response.data !== 'usuario registrado' &&  response.data !== 'rut falso') {
                if (this.jefatura) {
                        const persona = response.data;
                        
                        const existe = this.usuarios.some(u => u.run === persona.run);
                        if (!existe) {
                            const indexToFill = this.usuarios.findIndex(u => !u.run);
                            if (indexToFill !== -1) {
                                this.usuarios[indexToFill] = {
                                    run: persona.run || '',
                                    nombre_completo: persona.nombre_completo || '',
                                    telefono: persona.telefono || '',
                                    email: persona.email || ''
                                };
                            } else {
                                // Si no hay objeto vacío, agregamos uno nuevo
                                this.usuarios.push({
                                    run: persona.run || '',
                                    nombre_completo: persona.nombre_completo || '',
                                    telefono: persona.telefono || '',
                                    email: persona.email || ''
                                });
                            }
                        } else {
                            console.warn(`La persona con RUN ${persona.run} ya está en la lista.`);
                        }
                    } else {
                        this.mapearParametros(response.data);
                    }
                this.run = '';
            }else if(response.data == 'usuario registrado'){
                console.log('usuario registrado es una alerta')
                this.mensaje = 'registrado'
            }else if(response.data=='rut falso'){
                this.mensaje = 'rut falso'
            }
            
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
        this.RUN_tutor = ''
        this.inicio_rotacion = ''
        this.fin_rotacion = ''
    },
    solicitarCuenta(){
        if(this.validarErrores()){
            var data = new FormData()
            data.append('cuentas', JSON.stringify(this.usuarios))
            data.append('sistemas', JSON.stringify(this.sistemasSolicitados))
            data.append('run', this.run)
            data.append('estamento', this.estamento)
            data.append('servicio', this.servicio)
            if(this.estamento==39 || this.estamento==45){
                data.append('RUN_tutor', this.RUN_tutor)
                data.append('inicio_rotacion', this.inicio_rotacion) 
                data.append('fin_rotacion', this.fin_rotacion) 
            }
            axios.post('api/solicitar-cuenta', data)
            .then(response => {
                console.log(response.data)
                if(response.data=='El correo ha sido enviado'){
                    this.estadoSolicitud = true
                    this.borrarForm()
                }
            })
            .catch(error => {
                console.error('Error: ', error);
            });
        }
    },
    getTutor(input){
        var rut = input.srcElement.value;
        console.log(rut)
        if(rut.length>=9 && rut.length<=10){
            var data = new FormData()
            data.append('rut', rut)
            axios.post('api/get-tutor', data)
            .then(response => {
                // console.log(response.data.length)
                if(response.data.length==0){
                    this.RUN_tutor = ''
                }
            })
            .catch(error => {
                console.error('Error: ', error);
            });
        }
    },
    borrarForm(){
        this.usuarios = [
            {
                run: '',
                nombre_completo: '',
                telefono: '',
                email: ''
            }
        ];
        this.estamento='',
        this.servicio='',
        this.RUN_tutor = ''
        this.inicio_rotacion = ''
        this.fin_rotacion = ''
        this.sistemasSolicitados = [],
        this.mensaje = ''
      
    },
    changeEstado(){
        this.estadoSolicitud = false
    },
    validarErrores(){
        let validate = true
        this.errors = {}

        this.usuarios.forEach((val, index) => {
            if (val.run?.trim() === '') {
                this.errors[`run_${index}`] = true;
            }

            if (val.nombre_completo?.trim() === '') {
                this.errors[`nombre_completo_${index}`] = true;
            }
                
            if (val.telefono?.trim() === '') {
                this.errors[`telefono_${index}`] = true;
            }
            
            if (val.email?.trim() === '' || val.email==null) {
                this.errors[`email_${index}`] = true;
            }
       
        });

        if (!this.estamento) {
            this.errors[`estamento`] = true;
        }

        if (!this.servicio) {
            this.errors[`servicio`] = true;
        }

        if(this.sistemasSolicitados.length==0){
            this.errors[`sistemasSolicitados`] = true;
        }

         if(this.estamento==39 || this.estamento==45){
            if (!this.RUN_tutor) {
                this.errors[`RUN_tutor`] = true;
            }
            if (!this.inicio_rotacion) {
                this.errors[`inicio_rotacion`] = true;
            }
            if (!this.fin_rotacion) {
                this.errors[`fin_rotacion`] = true;
            }

            if (this.inicio_rotacion && this.fin_rotacion) {
                const inicio = new Date(this.inicio_rotacion);
                const fin = new Date(this.fin_rotacion);

                if (inicio > fin) {
                    this.errors['fin_rotacion_menor'] = true;
                }
            }
         }
       
        const numeroDeErrores = Object.keys(this.errors).length;
        console.log(numeroDeErrores)
        if(numeroDeErrores>0){
            validate = false
        }
        return validate
    },
    getAuthUser(){
        axios.post('data-auth')
        .then(response => {
            console.log(response.data);
            const { user, jefatura, authenticated } = response.data

            this.authenticated = authenticated
            this.jefatura = jefatura
            console.log(this.jefatura)
            this.user = user

            if(jefatura){
                this.btnAddDel = true
            }

        })
        .catch(error => {
            console.error('Error: ', error);
        });
    },
    validarRutEnTiempoReal(event) {
        const rut = event.target.value;
        document.getElementById(event.target.id).addEventListener('input', function (e) {
            let rut = e.target.value.replace(/[^\dkK]/gi, '').toUpperCase(); // Solo números y K
            if (rut.length > 1) {
                let cuerpo = rut.slice(0, -1);
                let dv = rut.slice(-1);
                e.target.value = `${cuerpo}-${dv}`;
            } else {
                e.target.value = rut;
            }
        });
    }
  },
  mounted() {
    this.getInfo()
    this.getAuthUser()
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
.btn_eliminar_user{
    margin-top: 27px;
}
</style>