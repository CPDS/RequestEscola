$(document).ready(function($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var tabela = $('#table').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: './equipamentos/list',
        columns: [
        { data: null, name: 'order' },
        { data: 'id', name: 'id' },
        { data: 'nome', name: 'nome' },
        { data: 'fk_tipo_equipamento', name: 'fk_tipo_equipamento' },
        { data: 'fk_local', name: 'fk_local'},
        { data: 'num_tombo', name: 'num_tombo' },
        { data: 'codigo', name: 'codigo' },
        { data: 'status', name: 'status' },
        { data: 'marca', name: 'marca' },
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
        sorting: [[ 1, "asc" ]],
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
          { targets : [8], sortable : false },
          { "width": "5%", "targets": 0 },  //ID
          { "width": "10%", "targets": 1 },  //nome
          { "width": "5%", "targets": 2 }, //fk_tipo_equipamento
          { "width": "10%", "targets": 3 },//fk_local
          { "width": "5%", "targets": 4 },//num_tombo
          { "width": "6%", "targets": 5},//codigo
          { "width": "15%", "targets": 6 },//status
          { "width": "15%", "targets": 7 },//marca
          { "width": "14%", "targets": 8 }//ação
        ]
    });

    tabela.on('draw.dt', function() {
        tabela.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
        cell.innerHTML = tabela.page.info().page * tabela.page.info().length + i + 1;
        });
    }).draw();

    $(document).on('click', '.btnAdicionar', function() {
        //alert('OK');
        $('.modal-footer .btn-action').removeClass('edit');
        $('.modal-footer .btn-action').addClass('add');

        $('.modal-title').text('Novo Equipamento');
        $('.callout').addClass("hidden"); 
        $('.callout').find("p").text(""); 

        $('#form')[0].reset();

        jQuery('#criar_editar-modal').modal('show');
    });

}); //FIM DOCUMENTO