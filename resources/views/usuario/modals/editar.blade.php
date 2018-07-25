<div id="editar-modal" class="modal fade" role="dialog" data-backdrop="static">
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
         
            <div class="form-group col-md-12">
              <strong>Nome Completo:</strong>
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input placeholder="Digite o nome completo do usuário" maxlength="254" id="nome" class="form-control" name="nome" type="text">
              </div>
            </div>

            <div class="form-group col-md-12">
              <strong>Email:</strong>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                  <input placeholder="Digite um email" maxlength="254" class="form-control" id="email" name="email" type="text">
              </div>
            </div>

            <div class="form-group col-md-6 senha">
              <strong>Senha:</strong>
              <input placeholder="Digite uma senha" id="senha" maxlength="32" class="form-control" name="senha" type="password">
            </div>

            <div class="form-group col-md-6 senha ">
              <strong>Confirmar Senha:</strong>
              <input placeholder="Digite a senha novamente" maxlength="32" id="confirmarsenha" class="form-control"  name="confirmarsenha" type="password">
            </div>

            <div class="form-group col-xs-6">
              <strong>Telefone:</strong>
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                <input placeholder="Digite o telefone" id="telefone" maxlength="254" class="form-control" name="telefone" type="text">
              </div>
            </div>
            <div class="form-group col-md-6">
             <strong>Função:</strong>
                <select name="funcao" id="funcao" class="form-control">
                  <option value='' selected disabled>Selecione ...</option>
                  @role('Administrador')
                  <option value="1">Administrador</option> 
                  @endrole
                  <option value="2">Secretário</option>
                  <option value="3">Coordenador</option> 
                  <option value="4">Estagiário</option> 
                  <option value="5">Professor</option>
                </select>
            </div>
            <div class="form-group col-md-12">
                    <strong>Rua:</strong>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="material-icons md-18">add_location</i></span>
                      <input placeholder="Digite o endereço" maxlength="254" id="rua" class="form-control" name="rua" type="text">
                    </div>
            </div>
            <div class="form-group col-md-6">
                    <strong>Matrícula: (para professores)</strong>
                    <input placeholder="Digite a matrícula" maxlength="254" id="matricula" class="form-control" name="matricula" type="text">
            </div>
            <div class="form-group col-md-6">
                    <strong>Departamento: (para professores)</strong>
                    <input placeholder="Digite o departamento" maxlength="254" id="departamento" class="form-control" name="departamento" type="text">
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
          <span class='glyphicon glyphicon-remove'></span> Cancelar
        </button>
      </div> <!-- Fim de ModaL Footer-->

    </div> <!-- Fim de ModaL Content-->

  </div> <!-- Fim de ModaL Dialog-->

</div> <!-- Fim de ModaL Usuario-->