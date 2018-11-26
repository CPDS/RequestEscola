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
			<strong>Solicitante</strong>
			<div class="input-group">
				<span class="input-group-addon"><input title="Proprio Usuário Logado" data-nome="{{Auth::user()->name}}" checked type="checkbox" id="ch_usuario_logado" name="ch_usuario_logado"/> </span>
				<input maxlength="254" id="solicitante" readonly class="form-control" name="solicitante" type="text">
			</div>
		</div>
          <div class="form-group col-md-12">
            <strong>Funcionário Responsável </strong>
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input maxlength="254" id="responsavel" readonly="true" class="form-control" name="responsavel" type="text">
            </div>
          </div>

          <div class="form-group col-md-6" id="div_tel">
            <strong>Telefone:</strong>
            <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
              <input id="telefone" maxlength="254" readonly class="form-control" name="telefone" type="text">
            </div>
          </div>
          <div class="dadosHora" >  
            <div class="form-group col-md-6">
                <strong>Data</strong>
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  <input class="form-control" id="data" name="data" type="date">
                </div>
            </div>

            <div class="form-group col-md-6">
                  <strong>Hora Inicial:</strong>
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                      <input class="form-control" id="hora_inicial" name="hora_inicial" type="time">
                  </div>
            </div>
            
            <div class="form-group col-md-6">
                <strong>Hora Final</strong>
                  <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                      <input class="form-control" id="hora_final" name="hora_final" type="time">
                  </div>
            </div>
          </div>
          
          <div class="form-group col-md-12 ">
            <strong>Ambiente</strong>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-university"></i></span>
                <select name="ambiente" id="ambiente" class="form-control">
                  @foreach($tipoAmbientes as $tipoAmbiente)
                    <optgroup label="{{$tipoAmbiente->nome}}">
                      @foreach($ambientes as $ambiente)    
                        @if($ambiente->fk_tipo == $tipoAmbiente->id)
                          <option value='{{$ambiente->id}}'>{{$ambiente->numero_ambiente}}</option>
                        @endif
                      @endforeach
                    </optgroup>
                  @endforeach
                </select>
              </div>  
            </div>

            <div class="form-group col-md-6 ">
            <strong>Local</strong>
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
                <select name="local" id="local" class="form-control">
                  <option value=''>Selecione ...</option>
                  @foreach($locais as $local)
                    <option value='{{$local->id}}'>{{$local->nome}}</option>
                  @endforeach
                </select>
              </div>  
            </div>

            <div class="form-group">
              <div class="col-md-6">
                <strong>Equipamentos</strong>
                  <div class="input-group"  style="width:100%">
                    <select name="equipamentos[]" id="equipamentos" class="form-control js-example-basic-multiple" style="width:100%" multiple="multiple">
                    
                    </select>
                  </div>       
              </div>
            </div>

            <div class="form-group col-md-12">
              <strong id="texto_observacao">Observações</strong>
              <textarea class="form-control" rows="3" width="100%" maxlength="254" id="observacao" class="form-control" name="observacao" style="resize: none;"></textarea> 
            </div>

        <input type="hidden" id="id" name="id">
        <input type="hidden" id="data_hora_inicio" name="data_hora_inicio">
        <input type="hidden" id="data_hora_termino" name="data_hora_termino">

      </div> 

    </form>


  </div> <!-- Fim de ModaL Body-->

  <div class="modal-footer">
    <button type="button" class="edit btn btn-action btn-success" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> &nbsp Aguarde...">
      <span class="glyphicon glyphicon-floppy-disk"> Salvar</span>
    </button>
    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
      <span class='glyphicon glyphicon-remove'></span> Cancelar
    </button>
  </div> <!-- Fim de ModaL Footer-->

</div> <!-- Fim de ModaL Content-->

</div> <!-- Fim de ModaL Dialog-->

</div> <!-- Fim de ModaL Usuario-->