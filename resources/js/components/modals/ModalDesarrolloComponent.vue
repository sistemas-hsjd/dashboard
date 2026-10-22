<template>
  <div id="modalDesarrollo" class="modal fade" tabindex="-1" aria-labelledby="digitalTeamTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content digital-team">
        <div class="modal-header">
          <div class="team-heading"><span class="team-icon" aria-hidden="true"><i class="mdi mdi-monitor-dashboard"></i></span><div><h5 id="digitalTeamTitle" class="modal-title">Unidad de Transformación Digital</h5><p>Equipo de desarrollo y soporte de aplicaciones</p></div></div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <p class="team-description">Desarrollo, mantenimiento y mejora continua de sistemas informáticos y plataformas <strong>SJDigital</strong>.</p>
          <Transition name="lunch-alert">
            <div v-if="personasEnColacion.length" class="team-lunch-alert" role="status" aria-live="polite">
              <i class="mdi mdi-silverware-fork-knife lunch-alert-icon" aria-hidden="true"></i>
              <div class="lunch-alert-content">
                <div class="lunch-alert-heading"><strong>Pausa de atención por colación</strong><span class="lunch-alert-count"><span aria-hidden="true" class="lunch-status-dot"></span>{{ personasEnColacion.length }} {{ personasEnColacion.length === 1 ? 'persona en colación' : 'personas en colación' }}</span></div>
                <p>La atención individual se retoma al finalizar el horario indicado.</p>
                <ul class="lunch-alert-people"><li v-for="persona in personasEnColacion" :key="persona.id">{{ persona.nombre }} {{ persona.apellido_paterno }}<span>{{ horarioColacion(persona) }}</span></li></ul>
              </div>
            </div>
          </Transition>
          <ul class="team-list">
            <li v-for="persona in desarrolladores" :key="persona.id" class="team-member" :class="{ 'member-on-lunch': enColacion(persona) }">
              <div class="member-avatar" aria-hidden="true">{{ (persona.nombre || '').charAt(0) }}</div>
              <div class="member-details">
                <div class="member-heading">
                  <div><h6>{{ persona.nombre }} {{ persona.apellido_paterno }} {{ persona.apellido_materno }}</h6><span v-if="persona.id == 4 || persona.id == 14" class="member-role">{{ persona.estamento }}</span></div>
                </div>
                <div v-if="persona.sistemas?.length" class="member-systems"><span v-for="sistema in persona.sistemas" :key="sistema.id">{{ sistema.nombre }}</span></div>
                <div class="member-contact">
                  <a v-if="persona.email" :href="`mailto:${persona.email}`"><i class="mdi mdi-email-outline" aria-hidden="true"></i>{{ persona.email }}</a>
                  <span v-if="persona.telefono"><i class="mdi mdi-phone-outline" aria-hidden="true"></i><span>Anexo <strong>{{ persona.telefono }}</strong></span></span>
                </div>
                <div class="member-schedule">
                  <span class="work-hours"><i class="mdi mdi-clock-outline" aria-hidden="true"></i><span><strong>Atención</strong> Lun–Jue 08:00–17:00 · Vie 08:00–16:00</span></span>
                  <span v-if="horarioColacion(persona)" class="lunch-hours" :class="{ 'lunch-active': enColacion(persona) }"><i class="mdi mdi-silverware-fork-knife" aria-hidden="true"></i><span><strong>{{ enColacion(persona) ? 'En colación' : 'Colación' }}</strong> {{ horarioColacion(persona) }}</span></span>
                </div>
              </div>
            </li>
          </ul>
        </div>
        <div class="modal-footer"><span>Los horarios de colación indican una pausa en la atención individual.</span><button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cerrar</button></div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
    data() {
        return {
            desarrolladores: [],
            ahora: new Date(),
            colacionTimer: null
        }
    },
    computed: {
        personasEnColacion() {
            return this.desarrolladores.filter(persona => this.enColacion(persona));
        },
        horaLocal() {
            const partes = new Intl.DateTimeFormat('en-US', {
                timeZone: 'America/Santiago', weekday: 'short',
                hour: '2-digit', minute: '2-digit', hourCycle: 'h23'
            }).formatToParts(this.ahora);
            const valor = tipo => partes.find(parte => parte.type === tipo).value;
            return {
                diaHabil: !['Sat', 'Sun'].includes(valor('weekday')),
                minutos: Number(valor('hour')) * 60 + Number(valor('minute'))
            };
        }
    },
    methods: {
        actualizarHora() {
            this.ahora = new Date();
        },
        enColacion(persona) {
            const horario = this.horarioColacion(persona);
            if (!horario || !this.horaLocal.diaHabil) return false;
            const [inicio, fin] = horario.split('–').map(hora => {
                const [horas, minutos] = hora.split(':').map(Number);
                return horas * 60 + minutos;
            });
            return this.horaLocal.minutos >= inicio && this.horaLocal.minutos < fin;
        },
        horarioColacion(persona) {
            const horarios = {
                'paolo.vilches@redsalud.gob.cl': '14:00–15:00',
                'jose.gajardoa@redsalud.gob.cl': '14:00–15:00',
                'giovanni.patirro@redsalud.gob.cl': '13:00–14:00',
                'nicolas.acevedo@redsalud.gob.cl': '13:00–14:00',
                'nelson.serrano@redsalud.gob.cl': '14:00–15:00'
            };
            return horarios[(persona.email || '').trim().toLowerCase()] || '';
        },
        getFuncionarios() {
            axios.post('/api/get-funcionarios')
                .then(response => {
                    this.desarrolladores = response.data.desarrolladores
                })
                .catch(error => {
                    console.error('Error:', error)
                })
        }
    },
    mounted() {
        this.colacionTimer = setInterval(this.actualizarHora, 1000);
        this.$el.addEventListener('show.bs.modal', this.actualizarHora);
        this.getFuncionarios()
    },
    beforeUnmount() {
        clearInterval(this.colacionTimer);
        this.$el.removeEventListener('show.bs.modal', this.actualizarHora);
    }
}
</script>


<style scoped>
.digital-team { border: 1px solid #dbe7ef; border-radius: 16px; overflow: hidden; }
.modal-header { padding: 20px 24px; background: #edf6fa; border-bottom: 1px solid #dce8f0; }
.team-heading { display: flex; align-items: center; gap: 12px; }
.team-icon { display: grid; place-items: center; width: 44px; height: 44px; background: #dceef4; color: #287c98; border-radius: 13px; font-size: 25px; flex-shrink: 0; }
.modal-title { color: #253e52; font-size: 18px; font-weight: 700; }
.team-heading p { margin: 4px 0 0; color: #5b7588; font-size: 12px; }
.modal-body { padding: 20px 24px; background: #f6fafc; }
.team-description { margin: 0 0 16px; font-size: 12px; line-height: 1.6; color: #526b7d; }
.team-description strong { color: #287c98; }
.team-list { list-style: none; padding: 0; margin: 0; display: grid; gap: 12px; }
.team-member { display: flex; gap: 14px; padding: 16px; border: 1px solid #dce7ef; border-radius: 12px; background: #fff; }
.member-avatar { display: grid; place-items: center; flex-shrink: 0; width: 42px; height: 42px; background: #e9f3f8; color: #297b9b; border-radius: 13px; font-size: 16px; font-weight: 700; }
.member-details { flex: 1; min-width: 0; display: grid; grid-template-columns: minmax(0, 1fr) auto; column-gap: 14px; align-content: start; }
.member-heading, .member-systems, .member-contact { grid-column: 1; }
.member-heading { display: flex; justify-content: space-between; align-items: flex-start; gap: 14px; }
.member-heading h6 { margin: 0; font-size: 14px; line-height: 1.5; font-weight: 700; color: #263d50; }
.member-role { display: inline-block; margin-top: 5px; font-size: 10px; color: #267461; background: #edf7f2; padding: 3px 7px; border-radius: 5px; font-weight: 600; }
.member-schedule { grid-column: 2; grid-row: 1 / 4; align-self: start; display: flex; flex-direction: column; align-items: flex-end; gap: 6px; flex-shrink: 0; }
.member-schedule > span { display: inline-flex; align-items: center; gap: 6px; padding: 4px 8px; border-radius: 6px; font-size: 10px; line-height: 1.4; }
.member-schedule .mdi { font-size: 14px; }
.member-schedule strong { margin-right: 4px; font-weight: 600; }
.work-hours { background: #edf6f2; color: #286651; }
.lunch-hours { background: #fff5df; color: #8a610c; }
.team-lunch-alert { display: flex; align-items: flex-start; gap: 16px; margin-bottom: 20px; padding: 20px; border: 1px solid #dca73e; border-left: 6px solid #b8790b; border-radius: 12px; background: linear-gradient(120deg, #ffe6a6, #fff5dc); color: #725016; box-shadow: 0 6px 20px #92630e24; animation: lunch-glow 2.6s ease-in-out infinite; }
.lunch-alert-content { flex: 1; min-width: 0; }
.lunch-alert-heading { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px 16px; }
.lunch-alert-heading > strong { color: #62400b; font-size: 15px; line-height: 1.4; }
.lunch-alert-count { display: inline-flex; align-items: center; gap: 7px; font-size: 11px; font-weight: 600; }
.lunch-status-dot { width: 7px; height: 7px; border-radius: 50%; background: #b8790b; box-shadow: 0 0 0 4px #c486161a; }
.team-lunch-alert p { margin: 6px 0 12px; font-size: 12px; line-height: 1.6; }
.lunch-alert-icon { display: grid; place-items: center; flex-shrink: 0; width: 46px; height: 46px; border: 1px solid #d6a03b; border-radius: 14px; background: #ffda83; color: #805008; font-size: 25px; }
.lunch-alert-people { display: flex; flex-wrap: wrap; gap: 8px; list-style: none; margin: 0; padding: 0; }
.lunch-alert-people li { display: flex; align-items: center; flex-wrap: wrap; gap: 4px 10px; padding: 6px 10px; border: 1px solid #e9d4a7; border-radius: 7px; background: #ffffffb3; color: #67491b; font-size: 11px; font-weight: 600; }
.lunch-alert-people li span { color: #886a36; font-size: 10px; font-weight: 400; }
.team-member.member-on-lunch { border-color: #e9d4a7; box-shadow: inset 3px 0 #c48616; background: linear-gradient(90deg, #fffcf4, #fff 45%); }
.member-on-lunch .member-avatar { background: #fff0cd; color: #99620b; }
.lunch-hours.lunch-active { border: 1px solid #d5a140; background: #ffedbf; color: #795009; font-weight: 600; }
.lunch-alert-enter-active { transition: opacity .4s ease, transform .4s cubic-bezier(.2,.8,.2,1); }
.lunch-alert-leave-active { transition: opacity .2s ease, transform .2s ease; }
.lunch-alert-enter-from, .lunch-alert-leave-to { opacity: 0; transform: translateY(-10px); }
@keyframes lunch-glow { 0%, 100% { box-shadow: 0 6px 20px #92630e24, 0 0 0 0 #c4861600; } 50% { box-shadow: 0 8px 26px #92630e40, 0 0 0 4px #c486162b; } }
@media (max-width: 575px) { .team-lunch-alert { gap: 10px; padding: 14px 12px; } .lunch-alert-icon { width: 34px; height: 34px; border-radius: 10px; font-size: 21px; } .lunch-alert-heading > strong { font-size: 13px; } }
@media (prefers-reduced-motion: reduce) { .team-lunch-alert { animation: none; } .lunch-alert-enter-active, .lunch-alert-leave-active { transition: none; } }
.member-systems { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 10px; }
.member-systems span { border: 1px solid #e0e9f0; background: #f6f9fc; color: #506b7e; border-radius: 5px; padding: 3px 7px; font-size: 10px; }
.member-contact { display: flex; flex-wrap: wrap; align-items: center; gap: 8px 20px; margin-top: 10px; font-size: 12px; color: #526b7d; }
.member-contact a, .member-contact > span { display: inline-flex; align-items: center; gap: 6px; min-width: 0; }
.member-contact a { color: #326e8a; text-decoration: none; overflow-wrap: anywhere; }
.member-contact a:hover { text-decoration: underline; }
.member-contact a:focus-visible { outline: 2px solid #287c98; outline-offset: 3px; }
.modal-footer { padding: 12px 24px; justify-content: space-between; border-top: 1px solid #dce8f0; }
.modal-footer > span { font-size: 11px; color: #657d8e; }
@media (max-width: 767px) { .modal-header, .modal-body { padding: 16px; } .modal-title { font-size: 16px; } .member-heading { flex-direction: column; gap: 10px; } .member-schedule { align-items: flex-start; flex-shrink: 1; } .team-member { padding: 12px; gap: 10px; } .member-avatar { width: 34px; height: 34px; } }
@media (max-width: 767px) { .member-details { grid-template-columns: minmax(0, 1fr); } .member-schedule { grid-column: 1; grid-row: auto; margin-top: 10px; } }
</style>
