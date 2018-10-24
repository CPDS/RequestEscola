<div id="editar-modal" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <!-- Fim de ModaL Header-->

            <div class="modal-body">
                <div class="alertaError callout callout-danger hidden">
                    <p></p>
                </div>
           
                <form id="form" role="form" method="post">
                    <div class="row" style="width: 100%">
                            <div class="form-group col-md-12">
                                <div class="box box-solid box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title">
                                            <span>Ambientes Reservados</span>
                                        </h3>
                                    </div>
                                    <div class="box-body">
                                        <table id="equipamentos-reservados-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nome</th>
                                                    <th>Marca</th>
                                                    <th>Tombo</th>
                                                    <th>Código</th>
                                                    <th>Local</th>
                                                    <th>Adicionar</th>
                                                    <th>Remover</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                              <div class="form-group col-md-10">
                                <strong>Equipamentos Disponíveis: </strong>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-exchange"></i></span>
                                    <select name="equipamentos-selecionado" id="equipamentos-selecionado" class="form-control">
                                    </select>
                                </div>
                                
                            </div>
                            <div class="form-group col-md-2">
                                <br>
                                <div class="input-group">
                                    <a class="addEquipamento btn btn-primary" title="Adicionar Equipamento" data-toggle="tooltip"><span class="glyphicon glyphicon-plus"></a>
                                </div>
                            </div>
                             <div class="form-group col-md-12">
                             <hr>
                                <strong>Descrição do Pedido:</strong>
                                
                                <textarea class="form-control" rows="3" width="100%" placeholder="Exemplo: nome do monitor que irá retirar o equipamento" maxlength="254" id="observacao" class="form-control" name="observacao"></textarea> 
                            </div>
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
            </div>
            <!-- Fim de ModaL Footer-->

        </div>
        <!-- Fim de ModaL Content-->

    </div>
    <!-- Fim de ModaL Dialog-->

</div>
<!-- Fim de ModaL Usuario-->
