<div id="filtro_relatorio-modal" class="modal fade" role="dialog" data-backdrop="static">
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

      
       <form id="formFiltroRelatorio"> <!--  role="form" method="get"  target="_blank" action="{{route('equipamento.realtorioEquipamentos')}}"-->
        <div class="row">

          <div class="form-group col-md-12">
              <strong>Tipo de equipamento:</strong>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-bars"></i></span>
                    <select name="id_tipo_equipamento" id="id_tipo_equipamento" class="form-control">
                    <option value='' selected disabled>Selecione ...</option>
                    <option value='Todos'>Todos os Equipamentos</option>
                    @foreach($tipoequipamentos as $tipoequipamento)
                    <option value="{{$tipoequipamento->id}}">{{$tipoequipamento->nome}}</option> 
                    @endforeach
                    </select>
                </div>
          </div>
<!--
          <div class="form-group col-md-12">
            <strong>Local:</strong>
              <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                  <select name="id_pavilhao" id="id_pavilhao" class="form-control">
                  <option value='' selected disabled>Selecione ...</option>
                  <option value='Todos'>Todos os Pavilhões</option>
                  @foreach($pavilhoes as $pavilhao)
                  <option value="{{$pavilhao->id}}">{{$pavilhao->nome}}</option> 
                  @endforeach
                  </select>
             </div>
          </div>
         -->
           <input type="hidden" id="id" name="id">
       
        </div>
      </form>

      </div> 

      <!-- Fim de ModaL Body-->

      <div class="modal-footer">
        <button type="submit" form="formFiltroRelatorio" class="Solicitar btn btn-action btn-success" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> &nbsp Aguarde...">
          <span class="glyphicon glyphicon-floppy-disk"> Solicitar</span>
        </button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">
          <span class='glyphicon glyphicon-remove'></span> Cancelar
        </button>
      </div> <!-- Fim de ModaL Footer-->

    </div> <!-- Fim de ModaL Content-->

  </div> <!-- Fim de ModaL Dialog-->

</div> <!-- Fim de ModaL Filtro-->