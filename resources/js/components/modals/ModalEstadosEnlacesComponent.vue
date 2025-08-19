<template>
     <!-- sample modal content -->
    <div id="modalEditEnlaces" class="modal fade" tabindex="-1" aria-labelledby="modalEditEnlacesLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearCuentaLabel">Enlaces Portal San Juan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="changeEstado()"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                           
                                        </div>
                                         <div class="table-responsive">
                                            <table class="table" id="tabla_enlaces" style="width: 100%; font-size: .9em;">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">ID</th>
                                                        <th width="3%">
                                                            <input type="checkbox" class="form-check-input checkbox-grande" id="check-all">
                                                        </th>
                                                        <th width="10%">Categoría</th>
                                                        <th>Nombre</th>
                                                        <th>Enlace</th>
                                                        <th style="width: 200px;">Categoría / Enlace</th>
                                                        <!-- <th style="width: 200px;">Desactivar Categoría</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                    
                                                </tbody>
                                            </table>
                                        </div>
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
import 'datatables.net';
import 'datatables.net-dt/css/dataTables.dataTables.min.css';
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
        estadoRegistro:false,
        lenguaje : {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "No se encontraron resultados",
            "sInfo": "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 hasta 0 de 0 registros",
            "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "oPaginate": {
                "sFirst": "Primero",
                "sPrevious": "Anterior",
                "sNext": "Siguiente",
                "sLast": "Último"
            },
            "sEmptyTable": "No hay registros disponibles",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "paginate": {
                "previous": "Anterior",
                "next": "Siguiente"
            }
        },
    };
  },
  methods: {
      initFiltros() {
            var params = {
                meses: '',
            };

            axios.get('api/get-enlaces', { params: params })
            .then(response => {
                console.log('desde la tabla',response.data)
                $('#tabla_enlaces').DataTable({
                    "responsive": true,
                    "autoWidth": false, 
                    "pageLength": 10,
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                    "order": [[0, "desc"]],
                    "processing": true,
                    "destroy": true,
                    "data": response.data,
                    "responsive": true,
                    language: this.lenguaje,
                    "drawCallback": function(settings) {
                        // Aquí va el código que deseas ejecutar cada vez que la tabla se dibuja
                        $('#check-all').off('click').on('click', function() {
                            const isChecked = $(this).is(':checked');
                            $('.checkbox-tabla').prop('checked', isChecked);
                        });

                        $('#tabla_eventos tbody').off('change', '.checkbox-tabla').on('change', '.checkbox-tabla', function() {
                            if (!$(this).is(':checked')) {
                                $('#check-all').prop('checked', false);
                            } else {
                                const allChecked = $('.checkbox-tabla').length === $('.checkbox-tabla:checked').length;
                                $('#check-all').prop('checked', allChecked);
                            }
                        });
                    },
                    "columns": [
                                {
                                    "data": "id",
                                    "render": function(data, type, row, meta) {
                                        return `${row.id}`;
                                    }
                                },
                                {        
                                    "data": "id",
                                    "orderable": false,
                                    "render": function(data, type, row, meta) {
                                        return ` <input class="form-check-input checkbox-tabla" type="checkbox" id="${row.id}">`;
                                    }
                                },
                               
                                {
                                    "data": "categoria",
                                    "render": function(data, type, row, meta) {
                                        return `${row.categoria.nombre}`;
                                    }
                                },
                                {
                                    "data": "nombre",
                                    "render": function(data, type, row, meta) {
                                        return ` <div class="badge badge-soft-info font-size-12">${row.nombre}</div>`;
                                    }
                                },
                                {
                                    "data": "enlace",
                                    "render": function(data, type, row, meta) {
                                        if(row.paciente){
                                            return `<span>${row.paciente.nr_run}-${row.paciente.tx_digito_verificador}</span>`;
                                        }else{
                                            return `<a>${row.enlace}</a>`;
                                        }
                                       
                                    }
                                },
                                {
                                    "data": "id",
                                    "sortable": false,
                                    "render": function(data, type, row, meta) {
                                        let html = ``
                                        if(row.categoria.estado == 1){
                                             html += `
                                                <input type="checkbox" class="editarCategoria" id="switchCat${row.id}" switch="dark" checked/>
                                                <label for="switchCat${row.id}" data-on-label="Sí" data-off-label="No"></label>
                                            `;
                                        }else{
                                             html += `
                                                <input type="checkbox" class="editarCategoria" id="switchCat${row.id}" switch="dark"/>
                                                <label for="switchCat${row.id}" data-on-label="Sí" data-off-label="No"></label>                                               
                                            `;
                                        }
                                        if(row.estado==1){
                                            html += `
                                                <input type="checkbox" class="editarEnlace" id="switchEnlace${row.id}" switch="bool" checked/>
                                                <label for="switchEnlace${row.id}" data-on-label="Sí" data-off-label="No"></label>
                                            `;
                                        }else{
                                            html += `
                                                <input type="checkbox" class="editarEnlace" id="switchEnlace${row.id}" switch="bool"/>
                                                <label for="switchEnlace${row.id}" data-on-label="Sí" data-off-label="No"></label>
                                            `;
                                        }
                                        
                                        return html;
                                    }
                                }
                    ]
                });
          
            })
            .catch(error => {
                console.error('Error: ', error);
            });
    },
    changeEstado(id, cat, enlace){
        var data = new FormData()  
        data.append('id', id)
        data.append('cat', cat)
        data.append('enlace', enlace)
        axios.post('api/desactivar-enlaces', data)
        .then(response => {
            //this.estadoRegistro = false
            console.log(response.data)
            if(response.data == 'ok'){
                this.initFiltros()    
            }
          
        })
        .catch(error => {
            console.error('Error: ', error);
        });
    },
  },
  mounted() {
    const vm = this;
    vm.initFiltros()    
    $('#tabla_enlaces tbody').on('click', '.editarEnlace, .editarCategoria', function(event) {
        event.stopPropagation();

        var $fila = $(this).closest('tr');
        var id = $(this).closest('tr').find('td').eq(0).text().trim();
        // Estado del switch editarCategoria
        var catSeleccionado = $fila.find('.editarCategoria').is(':checked');
        var catTexto = catSeleccionado ? 'Sí' : 'No';

        // Estado del switch editarEnlace
        var enlaceSeleccionado = $fila.find('.editarEnlace').is(':checked');
        var enlaceTexto = enlaceSeleccionado ? 'Sí' : 'No';
        vm.changeEstado(id, catTexto, enlaceTexto)
       
    });
  }
};
</script>
<style scoped>

</style>