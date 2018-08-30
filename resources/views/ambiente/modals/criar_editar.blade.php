<div id="criar_editar-modal" class="modal fade" role="dialog" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div> <!-- Fim de ModaL Header-->

      <div class="modal-body">

        <div class="callout callout-danger hidden">
          <p></p>
        </div>

       <form id="form" role="form" method="post">
         <div class="row" style="width: 100%">
         
           <!-- <div class="form-group col-md-12">
              <strong>Local:</strong>
                <input placeholder="Digite o nome do Local associado" maxlength="254" id="nome" class="form-control" name="nome" type="text">
            </div>-->

            <div class="form-group col-md-12">
              <strong>Tipo:</strong>
                <input placeholder="Digite o tipo de Ambiente" maxlength="254" id="tipo" class="form-control" name="tipo" type="text">
            </div>

            <div class="form-group col-xs-12">
              <strong>Descrição:</strong>
             <textarea name="descricao" id="descricao" maxlength="10000" rows="5" class="form-control " style="resize: none;"></textarea>
            </div>

            <div class="form-group col-md-12">
              <strong>Número do Ambiente:</strong>
              <div class="input-group">
                <!--<span class="input-group-addon"><i class="material-icons md-18">looks_two</i></span>-->
                <input placeholder="Digite o número do ambiente" maxlength="254" id="numero_ambiente" class="form-control" name="numero_ambiente" type="text">
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

</div> <!-- Fim de ModaL Locais-->