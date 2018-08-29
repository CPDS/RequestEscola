$(document).ready(function($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //tabela Ambiente
	var tabela = $('#table').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: './ambiente/list',
        columns: [
        { data: null, name: 'order' },
        { data: 'fk_local', name: 'fk_local' },
        { data: 'tipo', name: 'tipo' },
        { data: 'descricao', name: 'descricao' },
        { data: 'numero_ambiente', name: 'numero_ambiente' },
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
          { targets : [0,6], sortable : false },
          { "width": "5%", "targets": 0 }, //fk_local
          { "width": "10%", "targets": 1 },//tipo
          { "width": "15%", "targets": 2 },//descricao
          { "width": "5%", "targets": 3 },//num_ambiente
          { "width": "14%", "targets": 4 },//status
          { "width": "10%", "targets": 5 },//acao
        ]
    });

    tabela.on('draw.dt', function() {
        tabela.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = tabela.page.info().page * tabela.page.info().length + i + 1;
        });
    }).draw();


    $(document).on('click', '.btnAdicionar', function() {
        alert('agora sim');
        /*$('.modal-footer .btn-action').removeClass('edit');
        $('.modal-footer .btn-action').addClass('add');
        $('.modal-body .senha').removeClass("hidden");
        $('.modal-title').text('Novo Usuário');
        $('.callout').addClass("hidden"); 
        $('.callout').find("p").text(""); 

        $('#form')[0].reset();

        jQuery('#criar_editar-modal').modal('show'); */
    });


});
