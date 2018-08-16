@extends('adminlte::layouts.app')

<script src ="{{ asset('plugins/jQuery/jQuery-3.1.0.min.js') }}" type = "text/javascript" ></script>

<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}" type = "text/javascript"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/iziToast.min.css') }}">
<script src="{{ asset('js/iziToast.min.js') }}"></script>

<script src=" {{ asset('js/tipoequipamentos/tipoequipamentos.js') }} "> </script>

@section('main-content')

	<div class="row">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2><i class='fa fa-tasks'></i> Tipos de Equipamentos</h2>
			</div>

			<br><br><br>	

			<div class="pull-right">
				<a class="btn btn-primary btnAdicionar" title="Novo Tipo" data-toggle="tooltip"><span class="fa fa- fa-plus"></span> Novo Tipo</a>
			</div>

		</div>
	</div>

	<br>
	<div class="box">
		<div class="box-body">
			<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
				
			   <thead>
					<tr>
						<th>Nome</th>
						<th>Observação</th>
						<th>Status</th>
						<th>Ação</th>
					 </tr>
				</thead>
				 
			</table>
		</div>
	</div>

	@include('tipoEquipamento.modals.criar_editar')

@endsection