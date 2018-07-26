$(document).ready(function($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    //tabela Usuarios
    var tabela = $('#table').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            ajax: './users/list',
            columns: [
            { data: null, name: 'order' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email'},
            { data: 'funcao', name: 'funcao' },
            { data: 'telefone', name: 'telefone'},
            { data: 'rua', name: 'rua' },
            { data: 'status', name: 'status'},
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
              { "width": "5%", "targets": 0 }, //nº
              { "width": "10%", "targets": 1 },//nome
              { "width": "10%", "targets": 2 },//email
              { "width": "6%", "targets": 3 },//função
              { "width": "6%", "targets": 3 },//telefone
              { "width": "14%", "targets": 4 },//Rua
              { "width": "14%", "targets": 5 },//status
              { "width": "10%", "targets": 6 },//ação
            ]
    });

    tabela.on('draw.dt', function() {
        tabela.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = tabela.page.info().page * tabela.page.info().length + i + 1;
        });
    }).draw();

    //Visualizar
    $(document).on('click', '.btnVisualizar', function() {
        
        $('#nome-visualizar').text($(this).data('nome'));
        $('#email-visualizar').text($(this).data('email'));
        $('#funcao-visualizar').text($(this).data('funcao'));
        $('#telefone-visualizar').text($(this).data('telefone'));
        $('#rua-visualizar').text($(this).data('rua'));
        $('#status-visualizar').text($(this).data('status'));
        
        jQuery('#visualizar-modal').modal('show');
    });
    
    // Editar
    $(document).on('click', '.btnEditar', function() {
        
        $('.modal-footer .btn-action').removeClass('add');
        $('.modal-footer .btn-action').addClass('edit');
        $('.modal-body .senha').addClass("hidden");
        $('.modal-title').text('Editar Usuário');
        $('.callout').addClass("hidden"); //ocultar a div de aviso
        $('.callout').find("p").text(""); //limpar a div de aviso

        var btnEditar = $(this);

        $('#form :input').each(function(index,input){
            $('#'+input.id).val($(btnEditar).data(input.id));
        });

        
        jQuery('#editar-modal').modal('show'); //Abrir o modal
    });

    //Excluir
    $(document).on('click', '.btnExcluir', function() {
        
        $('.modal-title').text('Excluir Usuário');
        $('.id_del').val($(this).data('id')); 
        jQuery('#excluir-modal').modal('show'); //Abrir o modal
    });

    
    $('.modal-footer').on('click', '.edit', function() {
        
        var dados = new FormData($("#form")[0]); //pega os dados do form

        $.ajax({
            type: 'post',
            url: "./users/edit",
            data: dados,
            processData: false,
            contentType: false,
            beforeSend: function(){
                jQuery('.edit').button('loading');
            },
            complete: function() {
                jQuery('.edit').button('reset');
            },
            success: function(data) {
                 //Verificar os erros de preenchimento
                if ((data.errors)){

                    $('.callout').removeClass('hidden'); //exibe a div de erro
                    $('.callout').find('p').text(""); //limpa a div para erros successivos

                    $.each(data.errors, function(nome, mensagem) {
                        $('.callout').find("p").append(mensagem + "</br>");
                    });

                }
                else {
                    
                    $('#table').DataTable().draw(false);

                    jQuery('#editar-modal').modal('hide');

                    $(function() {
                        iziToast.success({
                            title: 'OK',
                            message: 'Usuário Atualizado com Sucesso!',
                        });
                    });

                }
            },

            error: function() {
                jQuery('#editar-modal').modal('hide'); //fechar o modal

                iziToast.error({
                    title: 'Erro Interno',
                    message: 'Operação Cancelada!',
                });
            },

        });
    });

});