<template>
  <section class="login-shell recovery-shell" aria-labelledby="recovery-title">
    <div class="login-form-panel">
      <span class="login-icon" aria-hidden="true"><i class="mdi mdi-lock-reset"></i></span>
      <span class="recovery-label">CUENTA INSTITUCIONAL</span>
      <h2 id="recovery-title">Recupera tu contraseña</h2>
      <p class="login-subtitle">Ingresa el correo asociado a tu cuenta. Te enviaremos una clave temporal para que puedas recuperar el acceso.</p>
      <form @submit.prevent="solicitarCodigo">
        <div class="login-field">
          <label for="email_recuperacion">Correo electrónico</label>
          <div class="login-input"><i class="mdi mdi-email-outline" aria-hidden="true"></i><input type="email" v-model.trim="email_recuperacion" id="email_recuperacion" name="email_recuperacion" placeholder="nombre@ejemplo.cl" autocomplete="email" required :disabled="estadoRegistro" :aria-invalid="!!errores.email_recuperacion" aria-describedby="recovery-feedback"></div>
        </div>
        <div id="recovery-feedback" aria-live="polite">
          <p v-if="errores.email_recuperacion" class="login-error" role="alert">{{ errores.email_recuperacion }}</p>
          <p v-if="respuesta.respuesta" class="recovery-success" role="status">{{ respuesta.respuesta }} Te llevaremos al inicio de sesión.</p>
        </div>
        <button class="login-submit" type="submit" :disabled="estadoRegistro || !!respuesta.respuesta">
          <template v-if="estadoRegistro">Enviando solicitud...</template>
          <template v-else>Solicitar clave temporal <i class="mdi mdi-arrow-right" aria-hidden="true"></i></template>
        </button>
      </form>
      <a href="/login" class="recovery-back"><i class="mdi mdi-arrow-left" aria-hidden="true"></i> Volver a iniciar sesión</a>
      <div class="login-account-note recovery-help"><i class="mdi mdi-lifebuoy" aria-hidden="true"></i><p>Si no tienes acceso a tu correo, comunícate con soporte al <strong>242234</strong>.</p></div>
    </div>
  </section>
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
            if (this.estadoRegistro || this.respuesta.respuesta) return;
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
                axios.post('/api/enviar-codigo', data)
                .then(response => {
                   
                    this.estadoRegistro = false
                    const redirectUrl = response.data.redirect;
                    this.respuesta.respuesta = response.data.respuesta
                    if (redirectUrl) {
                        setTimeout(() => {
                            window.location.href = '/login';
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

})
</script>

<style scoped>
.bg-primary {
    background-color: #080a2c !important;
}
</style>


