<div id="criar_editar-modal" class="modal fade" role="dialog" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
        <small class="modal-sub" style="color: red;"></small>
      </div> <!-- Fim de ModaL Header-->

      <div class="modal-body">

        <div class="callout callout-danger hidden">
          <p></p>
        </div>

        
        <form id="form" role="form" method="post">
         <div class="row" style="width: 100%">
           
          <div class="form-group col-md-12">
            <strong>Nome do tipo:</strong>
            <input placeholder="Digite o tipo de equipamento" maxlength="254" id="nome" class="form-control" name="nome" type="text">
          </div>

          <div class="form-group col-xs-12">
            
            <strong>Observação:</strong>
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
              <textarea placeholder="Digite a descrição do defeito" maxlength="254" class="form-control" id="observacao" name="observacao" type="text"></textarea> 
            </div> 
          </div>
          <input type="hidden" id="id" name="id">

        </div> 
      </form>

    </div> <!-- Fim de ModaL Body-->

    <div class="modal-footer">
      <button type="button" class="edit btn btn-action btn-success" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> &nbsp Aguarde...">
        <span class="glyphicon glyphicon-floppy-disk"> Salvar</span>
      </button>
      <button type="button" class="btn btn-danger" data-dismiss="modal">
        <span class='glyphicon glyphicon-remove'></span> Cancelar
      </button>
    </div> <!-- Fim de ModaL Footer-->

  </div> <!-- Fim de ModaL Content-->

</div> <!-- Fim de ModaL Dialog-->

</div> <!-- Fim de ModaL-->