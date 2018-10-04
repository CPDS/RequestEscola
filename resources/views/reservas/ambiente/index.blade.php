@extends('adminlte::layouts.app')

<script src ="{{ asset('plugins/jQuery/jQuery-3.1.0.min.js') }}" type = "text/javascript" ></script>

<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}" type = "text/javascript"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/iziToast.min.css') }}">
<script src="{{ asset('js/iziToast.min.js') }}"></script>


@section('main-content')
	<div class="row">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2><i class='fa fa-calendar'></i> Gerenciamento de Reservas</h2>
			</div>
			<br>

			<div class="pull-right">
				@role('Administrador|Funcionário')
					<a class="btnReservaExterna btn btn-sm btn-warning" title="Nova Reserva Externa" data-toggle="tooltip"><span class="fa fa-external-link"></span> Reserva Externa</a>
					<a class="btnRelatorio btn btn-sm btn-primary" title="Relatorio reservas" data-toggle="tooltip"><i class="fa fa-download"></i> Relatório de reservas</a>
				@endrole
			</div>

		</div>
	</div>
	
	<br>

	<!--Tabela de Reservados-->
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
						 <th>Ambiente</th>
						 <th>Solicitante</th>
						 <th>Data</th>
						 <th>Turno</th>
						 <th>Status</th>
						 <th>Ação</th>
					 </tr>
				</thead>	 
			</table>
		</div>
	</div>
	<!--Fim de Tabela de Reservados-->
	<br>
	<!--Tabela de Retirados-->
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
						 <th>Ambiente</th>
						 <th>Solicitante</th>
						 <th>Data</th>
						 <th>Turno</th>
						 <th>Status</th>
						 <th>Ação</th>
					 </tr>
				</thead>
				 
			</table>
		</div>
		<!--Fim de Tabela de Retirados-->
	</div>



@endsection
