<template>
  <div>
     <div v-if="iniciarPupUP">
        <div v-if="showImagePopup" class="image-popup" @click.self="cerrarPopup">
          <img :src="popupImage" class="popup-img" />
          <button class="close-btn" @click="cerrarPopup">✕</button>
        </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "PopupComponent",

  data() {
    return {
        iniciarPupUP: false,
        // popup
        showImagePopup: false,
        popupImage: '', 
        popupActivo:[]
    }
  },

  computed: {

  },

  methods: {
     mostrarImagenPopup(img) {
        this.popupImage = img;
        this.showImagePopup = true;
      },

    cerrarPopup() {
      this.showImagePopup = false;

      // CLAVE: guardar que el usuario lo cerró
      //localStorage.setItem('popup_cerrado', '1');
    },
    getPermisoPopup(){
        axios.post('api/get-permiso-pop-up')
        .then(response => {
            console.log('Permiso PopUp:', response.data);
            this.popupActivo = response.data;
            if(this.popupActivo && this.popupActivo.mostrar_popup) {
                this.iniciarPupUP = true;
            }
            console.log('Popup Activo:', this.popupActivo);
     
        })
        .catch(error => {
            console.error('Error al obtener el permiso del PopUp:', error);
            return null;
        });
    },
  },

  mounted() {
    this.getPermisoPopup()
        // revisar si el usuario ya lo cerró
    const cerrado = localStorage.getItem('popup_cerrado');
    if (!cerrado) {
        setTimeout(() => {
            this.mostrarImagenPopup('assets/images/1777389396-AFICHES PROMO-01.jpg');
        }, 1000);
    }

  }
}
</script>

<style scoped>
.image-popup {
  position: fixed;
  bottom: 20px;   /* distancia desde abajo */
  right: 20px;    /* distancia desde la derecha */
  z-index: 9999;

  background: #000;
  padding: 10px;
  border-radius: 12px;

  box-shadow: 0 10px 25px rgba(0,0,0,0.4);
}

/* imagen */
.popup-img {
  max-width: 325px;
  border-radius: 8px;
  display: block;
}

/* botón cerrar */
.close-btn {
  position: absolute;
  top: -10px;
  right: -10px;

  background: red;
  border: none;
  color: white;

  border-radius: 50%;
  width: 25px;
  height: 25px;

  cursor: pointer;
}
</style>