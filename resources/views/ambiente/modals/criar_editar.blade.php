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
            <strong>Tipo:</strong>
            <input placeholder="Digite o tipo de Ambiente" maxlength="254" id="tipo" class="form-control" name="tipo" type="text">
          </div>

          <div class="form-group col-xs-12">
            <strong>Descrição:</strong>
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
              <textarea placeholder="Descreva o ambiente" maxlength="254" class="form-control" id="descricao" name="descricao" type="text"style="resize: none;"></textarea> 
            </div> 
          </div>

          <div class="form-group col-md-6">
            <strong>Local:</strong>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
              <select name="id_local" id="id_local" class="form-control">
                <option value='' selected disabled>Selecione ...</option>
                @foreach($locais as $local)
                <option value="{{$local->id}}">{{$local->nome}}</option> 
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group col-md-6">
            <strong>Número do Ambiente:</strong>
            <div class="input-group">
              <!--<span class="input-group-addon"><i class="material-icons md-18">looks_two</i></span>-->
              <input placeholder="Digite o número" maxlength="254" id="numero_ambiente" class="form-control" name="numero_ambiente" type="text">
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

</div> <!-- Fim de ModaL Ambiente-->