@extends('adminlte::layouts.app')

<script src ="{{ asset('plugins/jQuery/jQuery-3.1.0.min.js') }}" type = "text/javascript" ></script>
<script src=" {{ asset('js/Equipamento/equipamento.js') }} "> </script>

<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}" type = "text/javascript"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/iziToast.min.css') }}">
<script src="{{ asset('js/iziToast.min.js') }}"></script>


@section('main-content')
<div class="box">
		<div class="box-body">
			<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
				
			   <thead>
					<tr>
						 <th>Nome</th>
						 <th>Nº tombo</th>
						 <th>Código</th>
						 <th>Status</th>
						 <th>Tipo</th>
						 <th>Marca</th>
						 <th>Ação</th>
					 </tr>
				</thead>
				 
			</table>
		</div>
	</div>
    
    @endsection