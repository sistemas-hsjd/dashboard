<template>
<div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center py-4 py-sm-5">
                   
                    <div class="mb-5">
                        <a href="#">
                            <img src="" alt="" height="30" class="me-1"><span class="logo-txt text-white font-size-22">Recuperación de contraseña</span>
                        </a>
                    </div>
                    
                    <h3 class="text-white mt-5">
                        Para restablecer su contraseña, 
                        por favor ingrese la dirección de correo electrónico asociada a su cuenta.
                        Se enviará un clave de acceso temporal a su correo,  para continuar con el proceso de recuperación.
                    </h3>
                    
                    <div class="mb-3">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-5">
                                <div class="mb-1">
                                    <label class="form-label text-white font-size-16">Email</label>
                                    <input type="email" v-model="email_recuperacion" class="form-control" id="email_recuperacion" name="email_recuperacion" placeholder="Ingrese email">
                                    <span v-if="errores.email_recuperacion" class="text-white font-size-14">* {{ errores.email_recuperacion }}</span>
                                    <span v-if="respuesta.respuesta" class="text-white font-size-15">* {{ respuesta.respuesta }}</span>
                                </div>
                                <div class="mt-3">
                                    <button v-if="!estadoRegistro" class="btn btn-primary w-100 waves-effect waves-light" @click="solicitarCodigo">Solicitar clave</button>
                                    <button type="button" class="btn btn-primary waves-effect" v-if="estadoRegistro">
                                        <i class="bx bx-hourglass bx-spin font-size-16 align-middle me-2"></i> 
                                        Solicitando clave de acceso...
                                    </button>
                                </div>  
                            </div>                        
                        </div>
                    </div>
                       
                </div>
            </div>
            <!-- end col -->
        </div>
</template>
<script>
import { defineComponent } from 'vue';

export default defineComponent({
    components: {
      
    },
    data() {
        return {
            email_recuperacion:'',
            errores:{},
            respuesta:{},
            estadoRegistro: false,
            user:[],
            codigo: ''
        }
    },
    methods: {
        solicitarCodigo(){
            this.estadoRegistro = true
            this.errores = {}
            this.respuesta = {}
          
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(this.email_recuperacion)) {
                this.errores.email_recuperacion = 'Por favor, ingrese un correo electrónico válido';
            }
            const numeroDeErrores = Object.keys(this.errores).length;
            if(numeroDeErrores==0){
                var data = new FormData();
                data.append('email', this.email_recuperacion)
                axios.post('api/enviar-codigo', data)
                .then(response => {
                   
                    this.estadoRegistro = false
                    const redirectUrl = response.data.redirect;
                    this.respuesta.respuesta = response.data.respuesta
                    if (redirectUrl) {
                        setTimeout(() => {
                            window.location.href = redirectUrl;
                        }, 5000);
                        
                    } else if(response.data=='no encontrado'){
                        this.errores.email_recuperacion = 'Usuario no encontrado, favor comunicarse al 242234';
                    }else{
                        this.errores.email_recuperacion = 'Usuario no encontrado, favor comunicarse al 242234';
                    }
                })
                .catch(error => {
                    
                    this.errores.email_recuperacion = 'Usuario no encontrado, favor comunicarse al 242234';
                    this.estadoRegistro = false              
                });    
            }else{
                this.estadoRegistro = false
            }
        },
        getAuthUser(){
            axios.post('data-auth')
            .then(response => {
               
                const { user, jefatura, authenticated } = response.data
                // this.authenticated = authenticated
                // this.jefatura = jefatura
                this.user = user
            })
            .catch(error => {
                console.error('Error: ', error);
            });
        },
    }, 
    computed:{

    },
    watch:{

    },
    mounted() {
        this.getAuthUser()
    }
})
</script>

<style scoped>
.bg-primary {
    background-color: #080a2c !important;
}
</style>


