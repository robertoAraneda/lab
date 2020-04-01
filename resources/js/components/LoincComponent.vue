<template>
    <div>
        <!--lista de secciones-->
        <div class="card mt-2">
            <div class="card-header">
                <h4 class="text-muted">
                    <strong>L</strong>ogical <strong>O</strong>bservation
                    <strong>I</strong>dentifiers <strong>N</strong>ames and
                    <strong>C</strong>odes
                </h4>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive">
                <table id="tableServerSide" class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Código</th>
                            <th scope="col">Tipo muestra</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Unidades</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import datatables from 'datatables'

export default {
    created() {
        this.myTable()
    },
    methods: {
        myTable() {
            $(function() {
                $('#tableServerSide').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '/admin/fetch',
                        dataType: 'json',
                        type: 'GET'
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'loinc_num' },
                        { data: 'system_' },
                        { data: 'long_common_name' },
                        { data: 'example_units' }
                    ],
                    language: {
                        processing: 'Procesando...',
                        search: 'Buscar&nbsp;:',
                        lengthMenu: 'Mostrar _MENU_ registros',
                        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                        infoEmpty: 'Mostrando 0 a 0 de 0 registros',
                        infoFiltered: '(filtrado de _MAX_ registros totales)',
                        infoPostFix: '',
                        loadingRecords: 'Cargando registros...',
                        zeroRecords:
                            'No se encontraron registros para la b&uacute;squeda',
                        emptyTable: 'No hay registros para mostrar',
                        paginate: {
                            first: 'Primero',
                            previous: 'Anterior',
                            next: 'Siguiente',
                            last: '&Uacute;ltimo'
                        },
                        aria: {
                            sortAscending: ': orden ascentente',
                            sortDescending: ': orden descendente'
                        }
                    },
                    destroy: true
                })
            })
        }
    }
}
</script>
