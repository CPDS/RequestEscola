<div id="criar-modal" class="modal fade" role="dialog" data-backdrop="static">
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
          <div class="row">

            <div class="form-group col-md-6">
              <strong>Tipo de equipamento: *</strong>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-bars"></i></span>
                  <select name="id_tipo_equipamento" id="id_tipo_equipamento" class="form-control">
                    <option value='' selected disabled>Selecione ...</option>
                    @foreach($tipoequipamentos as $tipoequipamento)
                      <option value="{{$tipoequipamento->id}}">{{$tipoequipamento->nome}}</option> 
                    @endforeach
                  </select>
                </div>
            </div>
             

          <div class="form-group col-md-6">
            <strong>Marca:</strong>
            <input placeholder="Informe a marca do equipamento" maxlength="254" class="form-control" id="marca" name="marca" type="text">
          </div>

          <div class="form-group col-md-6">
              <strong>Número de tombo:</strong>
              <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
              <input placeholder="Digite o numero de tombo" maxlength="8" class="form-control" id="num_tombo" name="num_tombo" type="text">
              </div>
          </div>

          <div class="form-group col-md-6">
            <strong>Descrição: *</strong>
            <div class="input-group">
              <span class="input-group-addon"></span>
              <input maxlength="140" class="form-control" id="descricao" name="descricao" type="text">
            </div>
          </div>

          <div class="form-group col-md-6">
              <strong>Código:</strong>
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
                  <input placeholder="Digite o codigo" maxlength="5" class="form-control" id="codigo" name="codigo" type="text">
                </div>
          </div>
          
           <div class="form-group col-md-12">
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
           
            <input type="hidden" id="id" name="id">
          </div> 

        </form>

      </div> 

      <!-- Fim de ModaL Body-->

      <div class="modal-footer">
        <button type="button" class="btn btn-action btn-success" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> &nbsp Aguarde...">
          <span class="glyphicon glyphicon-floppy-disk"> Salvar</span>
        </button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">
          <span class='glyphicon glyphicon-remove'></span> Cancelar
        </button>
      </div> <!-- Fim de ModaL Footer-->

    </div> <!-- Fim de ModaL Content-->

</div> <!-- Fim de ModaL Dialog-->

</div> <!-- Fim de ModaL Usuario-->