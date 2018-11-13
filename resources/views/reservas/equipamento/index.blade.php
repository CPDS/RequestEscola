@extends('adminlte::layouts.app')

<script src ="{{ asset('plugins/jQuery/jQuery-3.1.0.min.js') }}" type = "text/javascript" ></script>

<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}" type = "text/javascript"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/iziToast.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
<script src="{{ asset('js/iziToast.min.js') }}"></script>
<script src=" {{ asset('js/Reserva/Equipamento/equipamento.js') }} "> </script>
<script src=" {{ asset('js/jquery.maskedinput.js') }} "> </script>
<script src="{{ asset('plugins/select2/select2.min.js') }}" type = "text/javascript"></script>

@section('main-content')

	<div class="row">
		<div class="col-lg-12 margin-tb">
			
			<div class="pull-left">
				<h2><i class="fa fa-calendar"></i> Gerenciamento de Reservas</h2>
			</div>
			<div class="pull-right">
				@role('Administrador|Funcionário')
					<a class="btnReservaExterna btn btn-sm btn-warning" title="Reserva externa" data-toggle="tooltip"><i class="fa fa-external-link"></i> Reserva Externa</a>
					<a class="btnRelatorio btn btn-sm btn-primary" title="Relatorio reservas" data-toggle="tooltip"><i class="fa fa-download"></i> Relatório de reservas</a>
				@endrole
					<a class="btnAdicionar btn btn-sm btn-primary" data-nome="{{Auth::user()->name}}" data-telefone="{{Auth::user()->telefone}}" data-id="{{Auth::user()->id}}" title="Cadastrar Reserva" data-toggle="tooltip"><span class="glyphicon glyphicon-plus"></span> Adicionar</a>
			</div>
			
			
		</div>
	</div>

<br>
@role('Administrador|Funcionário')
	<div class="box box-solid box-primary">
		<div class="box-header">
	      <h3 class="box-title">
	      	<strong>Reservas</strong> 
	      		<span>(Aguardando Retirada)</span>
	      </h3>
	   </div><!-- /.box-header -->
		<div class="box-body">
			<table id="reserva-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
				
			   <thead>
					<tr>
						 <th>No</th>
						 <th>Solicitante</th>
						 <th>Data</th>
						 <th>Horário Inicial</th>
						 <th>Horário Final</th>
						 <th>Telefone</th>
						 <th>Status</th>
						 <th>Ação</th>
					 </tr>
				</thead>
				 
			</table>
		</div>
	</div>

	<br>
	<div class="box box-solid box-success">
		<div class="box-header">
	      <h3 class="box-title">
	      <strong>Retiradas</strong>
	      	<span>(Aguardando Devolução)</span>
	      </h3>
	   </div><!-- /.box-header -->
		<div class="box-body">
			<table id="atendidos-table" class="table table-striped table-bordered" cellspacing="0" width="100%">
				
			   <thead>
					<tr>
						<th>No</th>
						<th>Solicitante</th>
						<th>Data</th>
						<th>Horário Inicial</th>
						<th>Horário Final</th>
						<th>Telefone</th>
						<th>Status</th>
						<th>Ação</th>
					 </tr>
				</thead>
				 
			</table>
		</div>
	</div>
@else
<!--Tabela professores-->
<div class="box">
			<div class="box-body">
				<table id="tabela_professor" class="table table-striped table-bordered" cellspacing="0" width="100%">				
				<thead>
						<tr>
							<th>No</th>						 
							<th>Data</th>
							<th>Hora Inicial</th>
							<th>Hora Final</th>
							<th>Status</th>
							<th>Ação</th>
						</tr>
					</thead>
					
				</table>
			</div>
		</div>
		<!-- fim tabela profesores-->
@endrole

@include('reservas.equipamento.modals.criar_editar')
@include('reservas.equipamento.modals.visualizar')
@role('Administrador|Funcionário')
	@include('reservas.equipamento.modals.retirar')
	@include('reservas.equipamento.modals.finalizar')
@endrole

   
@endsection