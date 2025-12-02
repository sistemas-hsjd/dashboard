<template>
<div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center py-4 py-sm-5">
                   
                    <div class="mb-5">
                        <a href="#">
                            <img src="" alt="" height="30" class="me-1"><span class="logo-txt text-white font-size-22">¡Bienvenido/a!</span>
                        </a>
                    </div>
                    <h3 class="text-white mt-5">Para continuar, es necesario que actualices tu contraseña por motivos de seguridad.</h3>
                    <p class="text-white font-size-16">
                        Por favor, elige una contraseña segura que incluya letras mayúsculas, minúsculas, números o símbolos y evite usar datos personales o patrones fáciles de adivinar.
                    </p>
 
                    <div class="mb-3">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-5">
                                  <!-- Primera contraseña -->
                                <div class="mb-1">
                                    <label class="form-label text-white font-size-16">Nueva Contraseña</label>
                                    <div class="input-group auth-pass-inputgroup">
                                        <input
                                        :type="mostrarContrasena1 ? 'text' : 'password'"
                                        v-model="contrasena1"
                                        class="form-control"
                                        id="contrasena1"
                                        name="contrasena1"
                                        placeholder="Ingrese contraseña"
                                        />
                                        <button
                                        class="btn btn-light ms-0"
                                        type="button"
                                        id="password-addon1"
                                        @click="verContrasena('1')"
                                        >
                                        <i :class="mostrarContrasena1 ? 'mdi mdi-eye-off-outline' : 'mdi mdi-eye-outline'"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-1">
                                    <label class="form-label text-white font-size-16">Reingrese nueva contraseña</label>
                                    <div class="input-group auth-pass-inputgroup">
                                            <input
                                            :type="mostrarContrasena2 ? 'text' : 'password'"
                                            v-model="contrasena2"
                                            class="form-control"
                                            id="contrasena2"
                                            name="contrasena2"
                                            placeholder="Reingrese contraseña"
                                            />
                                            <button
                                            class="btn btn-light ms-0"
                                            type="button"
                                            id="password-addon2"
                                            @click="verContrasena('2')"
                                            >
                                            <i :class="mostrarContrasena2 ? 'mdi mdi-eye-off-outline' : 'mdi mdi-eye-outline'"></i>
                                            </button>
                                    </div>
                                </div>
                                 <div class="mb-1">
                                    <span v-if="errores.contrasena1" class="text-white font-size-13">* {{ errores.contrasena1 }}</span>
                                </div>
                                <div class="mt-3">
                                    <button v-if="!estadoRegistro" class="btn btn-primary w-100 waves-effect waves-light" @click="cambiarContrasena">Cambiar contraseña</button>
                                    <button type="button" class="btn btn-primary waves-effect" v-if="estadoRegistro">
                                        <i class="bx bx-hourglass bx-spin font-size-16 align-middle me-2"></i> 
                                        Cambiando contraseña...
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
            mostrarContrasena1: false,
            mostrarContrasena2: false,
            contrasena1:'',
            contrasena2:'',
            errores:{},
            estadoRegistro: false,
            user:[]
        }
    },
    methods: {
        cambiarContrasena(){
            this.estadoRegistro = true
            this.errores = {}
            if(this.contrasena1!==this.contrasena2){
                this.errores.contrasena1 = 'Las contraseñas no coinciden.';
            }
            if(this.contrasena1.length < 8){
                this.errores.contrasena1 = 'La contraseña debe tener al menos 8 caracteres';
            } 
            
            const regex = /^(?=.*[0-9])(?=.*[a-zA-Z!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).+$/;
            if (!regex.test(this.contrasena1)) {
                this.errores.contrasena1 = 'La contraseña debe contener al menos un número y un carácter (letra o símbolo)';
            }
            const numeroDeErrores = Object.keys(this.errores).length;
            if(numeroDeErrores==0){
                var data = new FormData();
                if(this.user){
                    data.append('rut', this.user.rut)
                }
                data.append('password', this.contrasena1)
                axios.post('api/cambiar-contrasena', data)
                .then(response => {
                    this.estadoRegistro = false
                    const redirectUrl = response.data.redirect;
                    if (redirectUrl) {
                        window.location.href = redirectUrl;
                    } else {
                        alert('Redirección no recibida desde el servidor');
                    }
                })
                .catch(error => {
                    this.estadoRegistro = false              
                });    
            }else{
                this.estadoRegistro = false
            }
        },
        verContrasena(numero) {
            if (numero === '1') {
                this.mostrarContrasena1 = !this.mostrarContrasena1;
            } else if (numero === '2') {
                this.mostrarContrasena2 = !this.mostrarContrasena2;
            }
        },
        getAuthUser(){
            axios.post('data-auth')
            .then(response => {
                // console.log(response.data);
                const { user } = response.data
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

</style>