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

      
       <form id="form" role="form" method="post" enctype="multipart/form-data">
         <div class="row" style="width: 100%">

            <div class="form-group col-md-12 tombo">
              <strong>Nº de Tombo ou Código:</strong>
              <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                <select name="id_equipamento" id="id_equipamento" class="form-control">
                    <option value='' selected disabled>Selecione ...</option>
                    @foreach($equipamentos as $equipamento)
                      @if($equipamento->num_tombo != '')
                        <option value="{{$equipamento->id}}">{{$equipamento->num_tombo}}</option>
                      @else
                        <option value="{{$equipamento->id}}">{{$equipamento->codigo}}</option>
                      @endif
                    @endforeach
                </select>
              </div>
            </div>

            <div class="form-group col-md-12">
              <strong>Local de Destino:</strong>
              <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
              <input maxlength="254" id="destino" name="destino" class="form-control"  type="text">
              </div>
            </div>

            <div class="form-group col-md-12">
              <strong> Descrição sumária do defeito:</strong>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                  <textarea placeholder="Digite a descrição do defeito" maxlength="254" class="form-control" id="descricao" name="descricao" type="text"></textarea> 
              </div> 
            </div>
            
             <input type="hidden" id="id" name="id">
          
            </div> 

      </form>

      </div> <!-- Fim de ModaL Body-->

      <div class="modal-footer">
        <button type="button" class="btn btn-action btn-success" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> &nbsp Aguarde...">
          <span class="glyphicon glyphicon-floppy-disk"> Salvar</span>
        </button>

        <button type="button" class="btn btn-danger" data-dismiss="modal">
          <span class='glyphicon glyphicon-remove'></span>Cancelar</span>
        </button>

      </div> <!-- Fim de ModaL Footer-->

    </div> <!-- Fim de ModaL Content-->

  </div> <!-- Fim de ModaL Dialog-->

</div> <!-- Fim de ModaL-->