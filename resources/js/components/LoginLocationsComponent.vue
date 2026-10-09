<template>
  <section class="access-audit">
    <div class="audit-heading"><div><h1>Registro de accesos</h1><p>IP, usuario, unidades y ubicación registrada al iniciar sesión. Horarios de Chile.</p></div><button type="button" class="btn btn-outline-primary btn-sm" @click="reload">Actualizar</button></div>
    <div class="audit-filters">
      <label>Desde<input v-model="from" type="date" class="form-control form-control-sm" @change="reload"></label>
      <label>Hasta<input v-model="to" type="date" class="form-control form-control-sm" @change="reload"></label>
      <label>Estado de ubicación<select v-model="status" class="form-select form-select-sm" @change="reload"><option value="">Todos</option><option v-for="(label, key) in statuses" :key="key" :value="key">{{ label }}</option></select></label>
    </div>
    <p class="audit-note">Sin coordenadas: consulta el estado para saber si faltó HTTPS, se denegó el permiso o el navegador no pudo obtener la ubicación.</p>
    <p v-if="error" class="alert alert-danger" role="alert">{{ error }}</p>
    <div class="table-responsive"><table ref="table" class="display audit-table" style="width:100%"><thead><tr><th>ID</th><th>Fecha</th><th>Nombre completo</th><th>RUN</th><th>Unidades</th><th>IP</th><th>Estado</th><th>Latitud</th><th>Longitud</th><th>Precisión (m)</th><th>Mapa</th></tr></thead></table></div>
  </section>
</template>
<script>
import DataTable from 'datatables.net-dt';
import 'datatables.net-dt/css/dataTables.dataTables.min.css';
const statuses = {success: 'Ubicación obtenida', denied: 'Permiso denegado', unavailable: 'No disponible', timeout: 'Tiempo agotado', unsupported: 'Navegador incompatible', insecure: 'Requiere HTTPS'};
export default {
  data() { return {from: '', to: '', status: '', statuses, error: ''}; },
  mounted() {
    const text = DataTable.render.text();
    this.auditTable = new DataTable(this.$refs.table, {
      processing: true, serverSide: true, searchDelay: 400, pageLength: 25,
      lengthMenu: [10, 25, 50, 100], order: [[1, 'desc']], autoWidth: false,
      ajax: async (data, callback) => {
        this.error = '';
        try {
          const response = await axios.get('/registro-accesos/data', {params: {...data, from: this.from || undefined, to: this.to || undefined, status: this.status || undefined}});
          callback(response.data);
        } catch (error) {
          this.error = error.response?.status === 403 ? 'No tienes permiso para consultar los accesos.' : 'No se pudieron cargar los datos. Revisa las fechas o intenta nuevamente.';
          callback({draw: data.draw, recordsTotal: 0, recordsFiltered: 0, data: []});
        }
      },
      columns: [
        {data: 'id'}, {data: 'logged_in_at', render: text},
        {data: 'nombre_completo', defaultContent: '', render: text}, {data: 'rut', defaultContent: '', render: text},
        {data: 'unidades', orderable: false, render: value => text.display(value === null ? 'Pendiente' : (value || []).map(unit => unit.nombre + (unit.active ? '' : ' (inactiva)')).join(', ') || 'Sin unidades')},
        {data: 'ip_address', render: text}, {data: 'location_status', render: value => text.display(statuses[value] || value)},
        {data: 'latitude', defaultContent: '—'}, {data: 'longitude', defaultContent: '—'}, {data: 'accuracy_meters', defaultContent: '—'},
        {data: null, orderable: false, searchable: false, render: row => {
          if (row.latitude === null || row.longitude === null) return '—';
          const lat = Number(row.latitude), lon = Number(row.longitude);
          return Number.isFinite(lat) && Number.isFinite(lon) ? `<a href="https://www.openstreetmap.org/?mlat=${lat}&mlon=${lon}#map=16/${lat}/${lon}" target="_blank" rel="noopener noreferrer">Ver mapa</a>` : '—';
        }}
      ],
      language: {search: 'Buscar:', lengthMenu: 'Mostrar _MENU_ registros', info: '_START_ a _END_ de _TOTAL_ registros', infoEmpty: 'Sin registros', infoFiltered: '(de _MAX_ registros)', emptyTable: 'No hay accesos registrados', zeroRecords: 'No se encontraron resultados', processing: 'Cargando...', paginate: {first: 'Primero', last: 'Último', next: 'Siguiente', previous: 'Anterior'}}
    });
  },
  beforeUnmount() { this.auditTable?.destroy(); },
  methods: { reload() { this.auditTable?.ajax.reload(); } }
};
</script>
<style scoped>
.access-audit { padding: 20px; margin-bottom: 16px; border: 1px solid #d5e1e9; border-radius: 14px; background: #fff; color: #253e52; }
.audit-heading { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 16px; }
.audit-heading h1 { font-size: 20px; margin-bottom: 5px; }
.audit-heading p, .audit-note { font-size: 12px; color: #526779; }
.audit-filters { display: flex; flex-wrap: wrap; gap: 14px; margin-bottom: 14px; }
.audit-filters label { font-size: 12px; display: grid; gap: 5px; }
.audit-table { font-size: 12px; }
.audit-table :deep(td) { vertical-align: top; }
</style>
