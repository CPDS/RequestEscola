$(document).ready(function($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //tabela de Reserva
	var tabela = $('#reserva-table').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: './reserva-ambiente/list/1',
        columns: [
        { data: null, name: 'order' },
        { data: 'ambiente', name: 'ambiente' },
        { data: 'responsavel', name: 'responsavel' },
        { data: 'data', name: 'data' },
        { data: 'turno', name: 'turno' },
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
          { targets : [0,5], sortable : false },
          { "width": "5%" , "targets":  0 }, //nº
          { "width": "10%", "targets":  1 }, //ambiente
          { "width": "5%" , "targets":  2 }, //Responsavel
          { "width": "5%" , "targets":  3 }, //data
          { "width": "5%" , "targets":  4 }, //turno
          { "width": "5%" , "targets":  5 }, //Status
          { "width": "10%", "targets":  6 }, //acao
        ]
    });

    tabela.on('draw.dt', function() {
        tabela.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = tabela.page.info().page * tabela.page.info().length + i + 1;
        });
    }).draw();


    //tabela de Atendidos
	var tabela = $('#atendidos-table').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: './reserva-ambiente/list/2',
        columns: [
        { data: null, name: 'order' },
        { data: 'ambiente', name: 'ambiente' },
        { data: 'responsavel', name: 'responsavel' },
        { data: 'data', name: 'data' },
        { data: 'turno', name: 'turno' },
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
          { targets : [0,5], sortable : false },
          { "width": "5%" , "targets":  0 }, //nº
          { "width": "10%", "targets":  1 }, //ambiente
          { "width": "5%" , "targets":  2 }, //Responsavel
          { "width": "5%" , "targets":  3 }, //data
          { "width": "5%" , "targets":  4 }, //turno
          { "width": "5%" , "targets":  5 }, //Status
          { "width": "10%", "targets":  6 }, //acao
        ]
    });

    tabela.on('draw.dt', function() {
        tabela.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = tabela.page.info().page * tabela.page.info().length + i + 1;
        });
    }).draw();
    
    //Ação checkbox do solicitante
    $(document).on('click','#ch_usuario_logado', function() {
        if($('#ch_usuario_logado').is(':checked')){
            $('#solicitante').prop("readonly",true);
            $('#solicitante').val($(this).data('nome'));
        }
        else{
            $('#solicitante').prop("readonly",false);
            $('#solicitante').val('');
        }
    });

    //Visualizar
    $(document).on('click', '.btnVisualizar', function() {
        $('#telefone-visualizar').text($(this).data('telefone'));
        $('#horaInicial-visualizar').text($(this).data('horaInicial'));
        $('#horaFinal-visualizar').text($(this).data('horaFinal'));
        $('#numero_ambiente-visualizar').text($(this).data('numero_ambiente'));        
        $('#solicitante-visualizar').text($(this).data('solicitante'));
        $('#observacao-visualizar').text($(this).data('observacao'));
        jQuery('#visualizar-modal').modal('show');
    });

    //Adicionar
    $(document).on('click', '.btnAdicionar', function() {
       // alert('agora sim');
        $('.modal-footer .btn-action').removeClass('edit');
        $('.modal-footer .btn-action').addClass('add');

        $('.modal-title').text('Cadastrar nova Reserva');
        $('.modal-sub').text('PREENCHA TODAS AS INFORMAÇÕES CORRETAMENTE');
        $('.callout').addClass("hidden"); 
        $('.callout').find("p").text(""); 

        $('#form')[0].reset();
        $('#solicitante').val($("#ch_usuario_logado").data('nome'));
        $('#responsavel').val($(this).data('nome'));
        $('#telefone').val($(this).data('telefone'));

        jQuery('#criar_editar-modal').modal('show');
    });

    //Editar
    $(document).on('click', '.btnEditar', function() {
        $('.modal-footer .btn-action').removeClass('add');
        $('.modal-footer .btn-action').addClass('edit');

        $('.modal-title').text('Editar Reserva');
        $('.callout').addClass("hidden"); //ocultar a div de aviso
        $('.callout').find("p").text(""); //limpar a div de aviso

        var btnEditar = $(this);

        $('#form :input').each(function(index,input){
            $('#'+input.id).val($(btnEditar).data(input.id));
        });

        jQuery('#criar_editar-modal').modal('show'); //Abrir o modal
    });

    //Retirar
    $(document).on('click', '.btnRetirar', function() {
        $('.callout').addClass("hidden"); //ocultar a div de aviso
        $('.callout').find("p").text(""); //limpar a div de aviso
        
        $('#equipamentos-retirar').text($(this).data('equipamentos'));
        $('.id_ret').val($(this).data('id')); 
        jQuery('#retirar-modal').modal('show'); //Abrir o modal
    });

    
    //AJAX Adicionar Ambiente
    $('.modal-footer').on('click', '.add', function() {
        
        var dados = new FormData($("#form")[0]); //pega os dados do form

        $.ajax({
            type: 'post',
            url: "./ambiente/create",
            data: dados,
            processData: false,
            contentType: false,
            beforeSend: function(){
                jQuery('.add').button('loading');
            },
            complete: function() {
                jQuery('.add').button('reset');
            },
            success: function(data) {
                 //Verificar os erros de preenchimento
                if ((data.errors)) {

                    $('.callout').removeClass('hidden'); //exibe a div de erro
                    $('.callout').find('p').text(""); //limpa a div para erros sucessivos

                    $.each(data.errors, function(nome, mensagem) {
                            $('.callout').find("p").append(mensagem + "</br>");
                    });

                } else {
                    
                    $('#table').DataTable().draw(false);

                    jQuery('#criar_editar-modal').modal('hide');

                    $(function() {
                        iziToast.success({
                            title: 'OK',
                            message: 'Ambiente Adicionado com Sucesso!',
                        });
                    });
                }
            },

            error: function() {
                jQuery('#criar_editar-modal').modal('hide'); //fechar o modal

                iziToast.error({
                    title: 'Erro Interno',
                    message: 'Operação Cancelada!',
                });
            },

        });
    });

    //AJAX Editar Ambiente
    $('.modal-footer').on('click', '.edit', function() {
        var dados = new FormData($("#form")[0]); //pega os dados do form

        $.ajax({
            type: 'post',
            url: "./ambiente/edit",
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
                if ((data.errors)) {

                    $('.callout').removeClass('hidden'); //exibe a div de erro
                    $('.callout').find('p').text(""); //limpa a div para erros successivos

                    $.each(data.errors, function(nome, mensagem) {
                            $('.callout').find("p").append(mensagem + "</br>");
                    });

                } else {
                    
                    $('#table').DataTable().draw(false);

                    jQuery('#criar_editar-modal').modal('hide');

                    $(function() {
                        iziToast.success({
                            title: 'OK',
                            message: 'Ambiente Atualizado com Sucesso!',
                        });
                    });

                }
            },

            error: function() {
                jQuery('#criar_editar').modal('hide'); //fechar o modal

                iziToast.error({
                    title: 'Erro Interno',
                    message: 'Operação Cancelada!',
                });
            },
        });
    });

    //Evento ajax - Desativar AMBIENTE
     $('.modal-footer').on('click', '.del', function() {

        $.ajax({
            type: 'post',
            url: './ambiente/delete',
            data: {
                'id': $(".id_del").val(),
            },
            beforeSend: function(){
                jQuery('.del').button('loading');
            },
            complete: function() {
                jQuery('.del').button('reset');
            },
            success: function(data) {
                $('#table').DataTable().row('#item-' + data.id).remove().draw(); //remove a linha e ordena
                jQuery('#excluir-modal').modal('hide'); //fechar o modal

                $(function() {

                    iziToast.success({
                        title: 'OK',
                        message: 'Ambiente Desativado com Sucesso!',
                    });
                });
            },
            error: function() {

                jQuery('#excluir-modal').modal('hide'); //fechar o modal

                iziToast.error({
                    title: 'Erro Interno',
                    message: 'Operação Cancelada!',
                });
            },
        });
    });

    //Evento ajax - ATIVAR AMBIENTE
    $('.modal-footer').on('click', '.ativ', function() {
        $.ajax({
            type: 'post',
            url: './ambiente/ativar',
            data: {
                'id': $(".id_ativ").val(),
            },
            beforeSend: function(){
                jQuery('.ativ').button('loading');
            },
            complete: function() {
                jQuery('.ativ').button('reset');
            },
            success: function(data) {
                $('#table').DataTable().row('#item-' + data.id).remove().draw(); //remove a linha e ordena
                jQuery('#ativar-modal').modal('hide'); //fechar o modal

                $(function() {

                    iziToast.success({
                        title: 'OK',
                        message: 'Ambiente Ativado com Sucesso!',
                    });
                });
            },
            error: function() {

                jQuery('#ativar-modal').modal('hide'); //fechar o modal

                iziToast.error({
                    title: 'Erro Interno',
                    message: 'Operação Cancelada!',
                });
            },

        });
    });

    //Validação de dados
    //$("#numero_ambiente").mask("999");

}); //FIM DOCUMENTO
