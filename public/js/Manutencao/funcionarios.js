$(document).ready(function($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var tabelaManutencao = $('#table').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            ajax: './manutencoes/list',
            columns: [
            { data: null, name: 'order' },
            { data: 'tombo', name: 'tombo' },
            { data: 'data', name: 'data' },
            { data: 'usuario.nome', name: 'usuario.nome' },
            { data: 'destino', name: 'destino' },
            { data: 'status', name: 'status' },
            { data: 'acao', name: 'acao' }
            ],
            createdRow : function( row, data, index ) {
                row.id = "item-" + data.id;   
            },
            paging: true,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
            scrollX: true,
            sorting: [[ 3, "asc" ]],
            responsive: true,
            lengthMenu: [
                [10, 15, -1],
                [10, 15, "Todos"]
            ],
            language: {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "<div><i class='fa fa-circle-o-notch fa-spin' style='font-size:38px;'></i> <span style='font-size:20px; margin-left: 5px'> Carregando...</span></div>",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
            },
            columnDefs : [
              { targets : [0,6], sortable : false },
              { "width": "4%", "targets": 0 },
              { "width": "6%", "targets": 1 },
              { "width": "20%", "targets": 2 },
              { "width": "15%", "targets": 3 },
              { "width": "25%", "targets": 4 },
              { "width": "10%", "targets": 5 },
              { "width": "20%", "targets": 6 },
            ]
    });

    tabelaManutencao.on('draw.dt', function() {
        tabelaManutencao.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = tabela.page.info().page * tabela.page.info().length + i + 1;
        });
    }).draw();

    
    
    //Adicionar
    $(document).on('click', '.btnAdicionar', function() {

        $('.modal-footer .btn-action').removeClass('edit');
        $('.modal-footer .btn-action').addClass('add');
        $('.tombo').removeClass("hidden");

        $('.modal-title').text('Novo Cadastro de Manutenção');
        $('.callout').addClass("hidden"); 
        $('.callout').find("p").text(""); 

        $('#form')[0].reset();

        jQuery('#criar_editar-modal').modal('show');
    });

}); //Fim do Documento