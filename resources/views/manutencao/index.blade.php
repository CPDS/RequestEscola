@extends('adminlte::layouts.app')

<script src ="{{ asset('js/jquery-3.1.0.js') }}" type = "text/javascript" ></script>
<script src ="{{ asset('js/jquery.maskedinput.js') }}" type = "text/javascript" ></script>
<script src ="{{ asset('js/jquery-ui-1.12.0/jquery-ui.js') }}" type = "text/javascript" ></script>
<link href="{{ asset('js/jquery-ui-themes-1.12.0/themes/base/jquery-ui.css') }}" rel="stylesheet">
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}" type = "text/javascript"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/iziToast.min.css') }}">
<script src="{{ asset('js/iziToast.min.js') }}"></script>

<!-- SCRIPT Geral -->
<script src="{{ asset('js/manutencao/funcionarios.js') }}"></script>
<!--
-->
@section('main-content')

	<div class="row">
		<div class="col-lg-12 margin-tb">
			@section('contentheader_title')
			<div class="pull-left">
				<h2><i class="fa fa-wrench"></i> Equipamentos em Manutenção</h2>
			</div>
			@endsection
			
			<div class="pull-right">
				<!--@permission('manutencao-create')-->
				<a class="btnAdicionar btn btn-primary" title="Cadastrar Manutencão" data-toggle="tooltip"><span class="glyphicon glyphicon-plus"></span> Cadastrar Manutenção  de Equipamentos</a>
				<!--@endpermission-->
			</div>

		</div>
	</div>

<br>
	<div class="box">
		<div class="box-body">
			<table id="manutencao_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
				
			   <thead>
					<tr>
						 <th>No</th>
						 <th>Tombo</th>
						 <th>Data da Solicitação</th>
						 <th>Solicitante</th>
						 <th>Local de Destino</th>
						 <th>Status</th>
						 <th>Ação</th>
					 </tr>
				</thead>
				 
			</table>



		</div>
	</div>

	<!-- Modal Inserir/Editar Manutenção -->
	@include('manutencao.criar_editar')
	<!-- Fim Modal Inserir/Editar Manutenção -->
	
	<!-- Modal Visualizar Manutenção -->
	@include('manutencao.visualizar')
	<!-- Fim Modal Visualizar Manutenção -->

	<!-- Modal Confirmar Conserto -->
	@include('manutencao.conserto')
<!--
 Fim Modal Confirmar Conserto -->

	<!-- Modal Confirmar Manutenção -->
	@include('manutencao.manutencao')
	<!-- Fim Modal Confirmar Manutenção -->
   
@endsection