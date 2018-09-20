@extends('adminlte::layouts.app')

<script src ="{{ asset('plugins/jQuery/jQuery-3.1.0.min.js') }}" type = "text/javascript" ></script>

<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}" type = "text/javascript"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/iziToast.min.css') }}">
<script src="{{ asset('js/iziToast.min.js') }}"></script>

<script src=" {{ asset('js/Equipamento/equipamento.js') }} "> </script>

@section('main-content')

	<div class="row">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2><i class='fa fa-laptop'></i> Equipamentos</h2>
			</div>

			<br>	

			<div class="pull-right">
				<a class="btnFiltro btn btn-info" title="Filtro Equipamento" data-toggle="tooltip"><span class="fa fa-file-pdf-o"></span> Lista de Equipamentos (PDF)</a>

				<a class="btnAdicionar btn btn-primary" title="Adicionar Equipamento" data-toggle="tooltip"><span class="glyphicon glyphicon-plus"></span> Novo Equipamento</a>
			</div>
		</div>
	</div>

	<div class="box">
		<div class="box-body">
			<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
			   <thead>
					<tr>
						<th>ID</th>
						<th>Nome</th>
						<th>Tipo</th>
						<th>Código</th>
						<th>Marca</th>
						<th>Status</th>
						<th>Ação</th>
					 </tr>
				</thead>
			</table>
		</div>
	</div>

	@include('equipamento.modals.criar_editar')
	@include('equipamento.modals.defeito')
	@include('equipamento.modals.excluir')
	@include('equipamento.modals.visualizar')


@endsection
