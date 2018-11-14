$(document).ready(function($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    
    //tabela de Reserva Colaboradores
	var tabela_reservas = $('#reserva-table').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: './reserva-equipamento/list',
        columns: [
        { data: null, name: 'order' },
        { data: 'solicitante', name: 'solicitante' },
        { data: 'data', name: 'data' },
        { data: 'hora_inicial', name: 'hora_inicial' },
        { data: 'hora_final', name: 'hora_final' },
        { data: 'telefone', name: 'telefone' },
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
          { targets : [0,7], sortable : false },
          { "width": "5%" , "targets":  0 }, //nº
          { "width": "10%", "targets":  1 }, //Solicitante
          { "width": "5%" , "targets":  2 }, //Data
          { "width": "5%" , "targets":  3 }, //Hora incial
          { "width": "5%" , "targets":  4 }, //Hora Final
          { "width": "5%" , "targets":  5 }, //Telefone
          { "width": "10%", "targets":  6 }, //status
          { "width": "10%", "targets":  7 }, //Ação
        ]
    });

    tabela_reservas.on('draw.dt', function() {
        tabela_reservas.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = tabela_reservas.page.info().page * tabela_reservas.page.info().length + i + 1;
        });
    }).draw();

    //tabela de Atendidos Colaboradores
	var tabela_atendidos = $('#atendidos-table').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: './reserva-equipamento/atendidos',
        columns: [
        { data: null, name: 'order' },
        { data: 'data', name: 'data' },
        { data: 'solicitante', name: 'solicitante' },
        { data: 'hora_inicial', name: 'hora_inicial' },
        { data: 'hora_final', name: 'hora_final' },
        { data: 'telefone', name: 'telefone' },
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
            { targets : [0,7], sortable : false },
            { "width": "5%" , "targets":  0 }, //nº
            { "width": "10%", "targets":  1 }, //Solicitante
            { "width": "5%" , "targets":  2 }, //Data
            { "width": "5%" , "targets":  3 }, //Hora incial
            { "width": "5%" , "targets":  4 }, //Hora Final
            { "width": "5%" , "targets":  5 }, //Telefone
            { "width": "10%", "targets":  6 }, //status
            { "width": "10%", "targets":  7 }, //Ação
        ]
    });

    tabela_atendidos.on('draw.dt', function() {
        tabela_atendidos.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = tabela_atendidos.page.info().page * tabela_atendidos.page.info().length + i + 1;
        });
    }).draw();

    //tabela de Professores
	var tabela_professor = $('#tabela_professor').DataTable({
        processing: true,
        serverSide: true,
        deferRender: true,
        ajax: './reserva-equipamento/list',
        columns: [
        { data: null, name: 'order' },
        { data: 'data', name: 'data' },
        { data: 'hora_inicial', name: 'hora_inicial' },
        { data: 'hora_final', name: 'hora_final' },
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
            { "width": "5%" , "targets":  1 }, //Data
            { "width": "5%" , "targets":  2 }, //Hora incial
            { "width": "5%" , "targets":  3 }, //Hora Final
            { "width": "10%", "targets":  4 }, //status
            { "width": "10%", "targets":  5 }, //Ação
        ]
    });

    tabela_professor.on('draw.dt', function() {
        tabela_professor.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = tabela_professor.page.info().page * tabela_professor.page.info().length + i + 1;
        });
    }).draw();
    
    //select 2
    $('.js-example-basic-multiple').select2({
        placeholder: "Selecione",
        allowClear: true,
        tags: true,
      });

    //Ação checkbox do solicitante
    $(document).on('click','#ch_usuario_logado', function() {
        if($('#ch_usuario_logado').is(':checked')){
            $('#solicitante').prop("readonly",true);
            $('#solicitante').val($(this).data('nome'));
            $('#telefone').prop("readonly",true);
            $('#telefone').val($('.btnAdicionar').data('telefone'));
        }
        else{
            $('#solicitante').prop("readonly",false);
            $('#solicitante').val('');
            $('#telefone').prop("readonly",false);
            $('#telefone').val('');
            
        }
    });

    //Preencher select de ambiente
    $(document).on('change','#local', function(){

        //recuperando Valores do formulário
        var local = $("#local :selected").val();
        var data_inicial = $('#data').val()+' '+$('#hora_inicial').val()+':00';
        var data_final = $('#data').val()+' '+$('#hora_final').val()+':00';
       
        //array de dados
        var dados_form = [local,data_inicial,data_final];
         //Recuperando data e hora do inicio e final para coneverter em timestamps
         var data_hora_inicial = Date.parse(data_inicial);
         var data_hora_final = Date.parse(data_final);
         //recuperando horario atual
         var data_atual = Date.now();
        //Validacoes
        if($('#data').val() == '' || $('#hora_inicial').val() == ''
            || $('#hora_final').val() == '' )
            alert('É necessário informar o periodo de utilização');
        else if(data_hora_inicial  > data_hora_final)
            alert('A data de inicio da reserva deve ser posterior a data final!');
        else if(data_hora_inicial < data_atual)
            alert('A data inicial da reserva deve ser igual ou posterior a data atual');
        else{
            $.getJSON('./reserva-equipamento/reservados/'+dados_form, function(dados){
                var option = '';
                
                if(dados.tipoEquipamento.length > 0){
                    $.each(dados.tipoEquipamento, function(i,tipoEquipamento){
                        
                        option += '<optgroup label="'+tipoEquipamento.nome+'">';//agrupando ambientes por tipo

                        $.each(dados.equipamentos, function(i,equipamentos){
                            if(tipoEquipamento.id == equipamentos.fk_tipo){
                                option += '<option value="'+equipamentos.id+'">'+equipamentos.codigo+'</option>';
                            }
                        });

                        option += '</optgroup>';
                    });
                }

                $('#equipamentos').html(option).show();
        
            });
        }
    });

    //Visualizar
    $(document).on('click', '.btnVisualizar', function() {
        $('#telefone-visualizar').text($(this).data('telefone'));
        $('#ambiente-visualizar').text($(this).data('ambiente'));
        $('#retirada-visualizar').text('Retirado por: '+$(this).data('usuario_retirada')+' em: ' +$(this).data('hora_retirada'));
        $('#entrega-visualizar').text('Recolhido por: '+$(this).data('usuario_entrega')+' em: ' +$(this).data('hora_entrega'));
        $('#equipamentos-visualizar').text($(this).data('equipamentos'));        
        $('#responsavel-visualizar').text($(this).data('responsavel'));
        $('#observacao-visualizar').text($(this).data('observacao'));
        $('#local-visualizar').text($(this).data('local'));
        $('#feedback-visualizar').text($(this).data('feedback'));
        jQuery('#visualizar-modal').modal('show');
    });

    //Adicionar
    $(document).on('click', '.btnAdicionar', function() {
       // alert('agora sim');
        $('.modal-footer .btn-action').removeClass('edit');
        $('.modal-footer .btn-action').addClass('add');
        
        $('.modal-title').text('Cadastrar Nova Reserva');
        $('.modal-sub').text('PREENCHA TODAS AS INFORMAÇÕES CORRETAMENTE');
        $('.callout').addClass("hidden"); 
        $('.callout').find("p").text(""); 
        $('.dadosHora').removeClass("hidden");//Exibindo dados de horario
        $('#texto_observacao').text('Observações');
        
        $('#form')[0].reset();
        $('#solicitante').val($("#ch_usuario_logado").data('nome'));
        $('#solicitante').prop("readonly",true);
        $('#responsavel').val($(this).data('nome'));
        $('#telefone').val($(this).data('telefone'));
        $('#telefone').prop("readonly",true);
        $('#div_tel').removeClass("col-md-12");
        $('#div_tel').addClass("col-md-6");
        
        jQuery('#criar_editar-modal').modal('show');
    });

    //Editar
    $(document).on('click', '.btnEditar', function() {
        $('.modal-footer .btn-action').removeClass('add');
        $('.modal-footer .btn-action').addClass('edit');

        $('.modal-title').text('Editar Reserva de Ambiente');
        $('.callout').addClass("hidden"); //ocultar a div de aviso
        $('.callout').find("p").text(""); //limpar a div de aviso
        $('#div_tel').removeClass("col-md-6");
        $('#div_tel').addClass("col-md-12");
        $('.dadosHora').addClass("hidden");//Exibindo dados de horario
        $('#texto_observacao').text('Descrição do Pedido: ');
        
        var btnEditar = $(this);
        
        //condição para checkbox
        if(btnEditar.data('solicitante') != $('#ch_usuario_logado').data('nome')){
            $('#ch_usuario_logado').prop("checked",false);
            $('#solicitante').prop("readonly",false);
            $('#telefone').prop("readonly",false);
        }
        
        //preenchendo formulário
        $('#form :input').each(function(index,input){
            $('#'+input.id).val($(btnEditar).data(input.id));
        });

        jQuery('#editar-modal').modal('show'); //Abrir o modal
    });

    //Cancelar
    $(document).on('click', '.btnCancelar', function() {
        $('.callout').addClass("hidden"); //ocultar a div de aviso
        $('.callout').find("p").text(""); //limpar a div de aviso
        
        $('#ambiente-retirar').text($(this).data('descricao'));
        $('.id_can').val($(this).data('id')); 
        jQuery('#cancelar-modal').modal('show'); //Abrir o modal
    });

    //Excluir
    $(document).on('click', '.btnExcluir', function() {
        $('.modal-title').text('Excluir Reserva');
        $('.id_del').val($(this).data('id')); 
        jQuery('#excluir-modal').modal('show'); //Abrir o modal
    });

    //Retirar
    $(document).on('click', '.btnRetirar', function() {
        $('.callout').addClass("hidden"); //ocultar a div de aviso
        $('.callout').find("p").text(""); //limpar a div de aviso
        
        $('#equipamentos-retirar').text($(this).data('equipamentos'));
        $('.id_ret').val($(this).data('id')); 
        jQuery('#retirar-modal').modal('show'); //Abrir o modal
    });

    //modal feedback
    $(document).on('click', '.btnFeedback', function() {
        $('.modal-title').text('Novo Feedback');
        $('.callout').addClass("hidden"); 
        $('.callout').find("p").text(""); 

        var btnFeedback = $(this);
        
        $('#formulario :input').each(function(index,input){
            $('#'+input.id).val(btnFeedback.data(input.id));
        });
                
        jQuery('#feedback-modal').modal('show'); //Abrir o modal
    });

    //modal Finalizar
    $(document).on('click', '.btnFinalizar', function() {
        $('#equipamentos').text($(this).data('equipamentos'));
        $('.id_fin').val($(this).data('id')); 
        jQuery('#finalizar-modal').modal('show'); //Abrir o modal
    });

    //AJAX feedback
    $('.modal-footer').on('click', '.feed', function() {
        var dados = new FormData($("#formulario")[0]); //pega os dados do form

        $.ajax({
            type: 'post',
            url: "./reserva-equipamento/feedback",
            data: dados,
            processData: false,
            contentType: false,
            beforeSend: function(){
                jQuery('.feed').button('loading');
            },
            complete: function() {
                jQuery('.feed').button('reset');
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

                    jQuery('#feedback-modal').modal('hide');

                    $(function() {
                        iziToast.success({
                            title: 'OK',
                            message: 'Feedback enviado com Sucesso!',
                        });
                    });

                }
            },

            error: function() {
                jQuery('#feedback-modal').modal('hide'); //fechar o modal

                iziToast.error({
                    title: 'Erro Interno',
                    message: 'Operação Cancelada!',
                });
            },

        });
    });

    //AJAX Adicionar Ambiente
    $('.modal-footer').on('click', '.add', function() {
        
        var dados = new FormData($("#form")[0]); //pega os dados do form

        $.ajax({
            type: 'post',
            url: "./reserva-equipamento/create",
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

    //Evento ajax - cancelar AMBIENTE
     $('.modal-footer').on('click', '.can', function() {

        $.ajax({
            type: 'post',
            url: './reserva-equipamento/cancelar',
            data: {
                'id': $(".id_can").val(),
            },
            beforeSend: function(){
                jQuery('.can').button('loading');
            },
            complete: function() {
                jQuery('.can').button('reset');
                
            },
            success: function(data) {
                $('#table').DataTable().row('#item-' + data.id).remove().draw(); //remove a linha e ordena
                jQuery('#cancelar-modal').modal('hide'); //fechar o modal
                
                $(function() {
                    iziToast.success({
                        title: 'OK',
                        message: 'Reserva cancelada com Sucesso!',
                    });
                });
                
            },
            error: function() {

                jQuery('#cancelar-modal').modal('hide'); //fechar o modal

                iziToast.error({
                    title: 'Erro Interno',
                    message: 'Operação Cancelada!',
                });
            },
        });
    });

    //Evento ajax - Excluir AMBIENTE
    $('.modal-footer').on('click', '.del', function() {
        $.ajax({
            type: 'post',
            url: './reserva-equipamento/delete',
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
                        message: 'Reserva excluída com Sucesso!',
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

     //AJAX Retirar
     $('.modal-footer').on('click', '.ret', function() {

        $.ajax({
            type: 'post',
            url: '../reserva-equipamento/retirar',
            data: {
                'id': $(".id_ret").val(),
            },
            beforeSend: function(){
                jQuery('.ret').button('loading');
            },
            complete: function() {
                jQuery('.ret').button('reset');
            },
            success: function(data) {

                if ((data.errors)) {
                    $('.callout').removeClass('hidden'); //exibe a div de erro
                    $('.callout').find('p').text(""); //limpa a div para erros successivos

                    $.each(data.errors, function(nome, mensagem) {
                            $('.callout').find("p").append(mensagem + "</br>");
                    });
                } else {                    
                    $('#table').DataTable().draw(false); //remove a linha e ordena
                    jQuery('#retirar-modal').modal('hide'); //fechar o modal
                    
                    $(function() {

                        iziToast.success({
                            title: 'OK',
                            message: 'Equipamentos retirados com Sucesso!',
                        });
                    });
                    //window.location.reload();
                }               
            },
            error: function() {

                jQuery('#retirar-modal').modal('hide'); //fechar o modal

                iziToast.error({
                    title: 'Erro Interno',
                    message: 'Operação Cancelada!',
                });
            },

        });
    });

    $('.modal-footer').on('click', '.fin', function() {
        
        $.ajax({
            type: 'post',
            url: '../reserva-equipamento/finalizar',
            data: {
                'id': $(".id_fin").val(),
            },
            beforeSend: function(){
                jQuery('.fin').button('loading');
            },
            complete: function() {
                jQuery('.fin').button('reset');
            },
            success: function(data) {
                $('#table').DataTable().draw(false); //remove a linha e ordena
                jQuery('#finalizar-modal').modal('hide'); //fechar o modal
                
                $(function() {

                    iziToast.success({
                        title: 'OK',
                        message: 'Equipamentos devolvidos com Sucesso!',
                    });
                    
                });
                //window.location.reload();
            },
            error: function() {

                jQuery('#finalizar-modal').modal('hide'); //fechar o modal

                iziToast.error({
                    title: 'Erro Interno',
                    message: 'Operação Cancelada!',
                });
            },

        });
    });


    //Validação de dados
    $("#telefone").mask("(99) 99999-9999");

}); //FIM DOCUMENTO
