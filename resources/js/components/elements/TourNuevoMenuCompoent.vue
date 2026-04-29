<template>
  <div>
    <!-- OVERLAY -->
    <div v-if="activo" class="tour-overlay" @click="cerrarTour">
      
      <!-- SPOTLIGHT -->
      <div class="spotlight" :style="spotlightStyle">
        Solicitar Nuevo Desarrollo
      </div>

      <!-- TOOLTIP -->
      <div 
        class="glass-tooltip"
        :style="tooltipStyle">

        <div class="arrow"></div>

        <strong>Nuevo 🚀</strong><br>
        Aquí puedes solicitar desarrollos o reportar errores.
      </div>

    </div>
  </div>
</template>

<script>
export default {
  name: "TourNuevoMenu",

  data() {
    return {
      activo: false,
      target: null,
      rect: null
    }
  },

  computed: {
    spotlightStyle() {
      if (!this.rect) return {}

      return {
        top: this.rect.top + window.scrollY - 8 + "px",
        left: this.rect.left + window.scrollX - 8 + "px",
        width: this.rect.width + 16 + "px",
        height: this.rect.height + 16 + "px"
      }
    },

    tooltipStyle() {
      if (!this.rect) return {}

      return {
        top: this.rect.bottom + window.scrollY + 15 + "px",
        left: (this.rect.left + this.rect.width / 2 - 130) + "px"
      }
    }
  },

  methods: {
    iniciarTour() {
      const intentar = () => {
        // 🔥 BUSCAR EL <a> REAL DEL MENÚ
        const el = document.querySelector("#menu-nuevo a")

        if (!el) {
          setTimeout(intentar, 300)
          return
        }

        this.target = el
        this.rect = el.getBoundingClientRect()

        // Scroll automático
        el.scrollIntoView({ behavior: "smooth", block: "center" })

        // Abrir dropdown correctamente (Bootstrap 5)
        setTimeout(() => {
          try {
            const dropdown = new bootstrap.Dropdown(el)
            dropdown.show()
          } catch (e) {
            console.warn("No se pudo abrir dropdown", e)
          }
        }, 400)

        this.activo = true

        window.addEventListener("scroll", this.actualizarPosicion)
        window.addEventListener("resize", this.actualizarPosicion)
      }

      intentar()
    },

    actualizarPosicion() {
      if (!this.target) return
      this.rect = this.target.getBoundingClientRect()
    },

    cerrarTour() {
      this.activo = false
      localStorage.setItem("tour_visto", "1")

      window.removeEventListener("scroll", this.actualizarPosicion)
      window.removeEventListener("resize", this.actualizarPosicion)
    }
  },

  mounted() {
    const visto = localStorage.getItem("tour_visto")

    if (!visto) {
      setTimeout(() => {
        this.iniciarTour()
      }, 700)
    }
  }
}
</script>

<style scoped>


/* OVERLAY OSCURO */
.tour-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(15, 23, 42, 0.5);
  backdrop-filter: blur(4px);
  z-index: 9998;
  pointer-events: auto; /* permitir click en tooltip si quieres */
}

/* SPOTLIGHT */
.spotlight {
  position: absolute;
  border-radius: 10px;
   display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-weight: 900;
  font-size: 16px;
  box-shadow: 
    0 0 0 9999px rgba(15, 23, 42, 0.5),
    0 0 15px rgba(255, 255, 255, 0.6); /* brillo alrededor */
  pointer-events: none;
  transition: all 0.2s ease;

  /* IMPORTANTE: el texto del enlace se ve por encima del overlay */
  z-index: 10000; 
}

/* TOOLTIP VIDRIO */
.glass-tooltip {
  position: absolute;
  z-index: 10001;
  padding: 16px 20px;
  border-radius: 14px;

  background: rgba(15, 23, 42, 0.65);  
  backdrop-filter: blur(18px);
  -webkit-backdrop-filter: blur(18px);

  border: 1px solid rgba(255,255,255,0.3);
  box-shadow: 0 10px 40px rgba(0,0,0,0.4);

  color: #fff;
  text-shadow: 0 1px 2px rgba(0,0,0,0.5);
  max-width: 260px;
}

/* FLECHA DEL TOOLTIP */
.glass-tooltip .arrow {
  position: absolute;
  width: 14px;
  height: 14px;
  background: inherit;
  top: -7px;
  left: 50%;
  transform: translateX(-50%) rotate(45deg);
  border-radius: 2px;
  z-index: 10002;
}

/* ANIMACIÓN */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* TEXTO FUERTE EN TOOLTIP */
.glass-tooltip strong {
  display: block;
  margin-bottom: 6px;
  font-size: 15px;
}

</style>