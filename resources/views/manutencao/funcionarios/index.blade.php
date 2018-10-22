@extends('adminlte::layouts.app')

<script src ="{{ asset('plugins/jQuery/jQuery-3.1.0.min.js') }}" type = "text/javascript" ></script>

<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}" type = "text/javascript"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/iziToast.min.css') }}">
<script src="{{ asset('js/iziToast.min.js') }}"></script>

<script src="{{ asset('js/jquery.maskedinput.js') }}"></script>
<script src=" {{ asset('js/Manutencao/funcionarios.js') }} "> </script>
<<<<<<< HEAD

=======
>>>>>>> 973c7997fee0a391119f2e7c8c67dff820444692


@section('main-content')

<div class="row">
	<div class="col-lg-12 margin-tb">
		
		<div class="pull-left">
			<h2><i class="fa fa-wrench"></i> @yield('contentheader_title', 'Equipamentos em Manutenção')</h2>
		</div>
		
		<br>
		
		<div class="pull-right">
			<!--@permission('manutencao-create')-->
			<a class="btnAdicionar btn btn-primary" title="Cadastrar Manutenção" data-toggle="tooltip"><span class="glyphicon glyphicon-plus"></span> Adicionar</a>
			<!--@endpermission-->
		</div>

	</div>
</div>

<div class="box">
	<div class="box-body">
		<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
			
			<thead>
				<tr>
					<th>Nº</th>
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
@include('manutencao.funcionarios.criar_editar')
<!-- Fim Modal Inserir/Editar Manutenção -->

<!-- Modal Visualizar Manutenção -->
@include('manutencao.funcionarios.visualizar')
<!-- Fim Modal Visualizar Manutenção -->

<!-- Modal Confirmar Conserto -->
@include('manutencao.funcionarios.conserto')
<!--
	Fim Modal Confirmar Conserto -->

	<!-- Modal Confirmar Manutenção -->
	@include('manutencao.funcionarios.manutencao')
	<!-- Fim Modal Confirmar Manutenção -->
	
	@endsection