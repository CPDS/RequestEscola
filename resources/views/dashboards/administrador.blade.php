@extends('layouts.app')
<head>    
	<meta http-equiv="refresh" content="30">  
</head> 

@section('htmlheader_title', 'Painel de Controle')

@section('main-content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        @section('contentheader_title')
        <div class="pull-left">
            <h2><i class="fa fa-gear"> Painel de Controle</i></h2>
            
        </div>
        @endsection
    </div>
</div>
<br>


<section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      	<br><br>
      </div>

      <div class="row">
	        <div class="col-lg-4 col-xs-6">
	          <!-- small box -->
	          <div class="small-box bg-yellow">
	            <div class="inner">
	              <h3>Geral</h3>
	              <br>
	              <strong><p>descrição...</p></strong>
	            </div>

	            <div class="icon">
	              <i class="glyphicon glyphicon-eye-open"></i>
	            </div>
	          </div>
	        </div>

	        <!-- ./col -->
	        <div class="col-lg-4 col-xs-6">
	          <!-- small box -->
	          <div class="small-box bg-green">
	            <div class="inner">
	              <h3>X</h3>

	              <strong><p>Reserva(s) de laboratório(s)<br> agendadas para hoje</p></strong>
	            </div>
	            <div class="icon">
	            	<i class="fa fa-calendar-check-o"></i>
	            </div>
	            <a href="#" class="small-box-footer">Exibir reserva(s) <i class="fa fa-arrow-circle-right"></i></a>
	          </div>
	        </div>
	        <!-- ./col -->
	        <div class="col-lg-4 col-xs-6">
	          <!-- small box -->
	          <div class="small-box bg-aqua">
	            <div class="inner">
	              <h3>X</h3>

	              <strong><p>Reserva(s) de equipamento(s)<br> aguardando retirada hoje</p></strong>
	            </div>
	            <div class="icon">
	              <i class="fa fa-calendar-check-o "></i>
	            </div>
	            <a href="#" class="small-box-footer">Exibir reserva(s) <i class="fa fa-arrow-circle-right"></i></a>
	          </div>
	        </div>

	        <!-- ./col -->
	        <div class="col-lg-4 col-xs-6">
	          <!-- small box -->
	          <div class="small-box bg-red">
	            <div class="inner">
	              <h3>X</h3>
	              <br>
	              <strong><p>Equipamento(s) com defeito</p></strong>
	            </div>
	            <div class="icon">
	              <i class="glyphicon glyphicon-thumbs-down"></i>
	            </div>
	            <a href="#" class="small-box-footer">Exibir <i class="fa fa-arrow-circle-right"></i></a>
	          </div>
	        </div>
	    	
	        <div class="col-lg-4 col-xs-6">
	          <!-- small box -->
	          <div class="small-box bg-aqua">
	            <div class="inner">
	              <h3>X</h3>
	              <br>
	              <strong><p>Retirada(s) de equipamento em andamento</p></strong>
	            </div>
	            <div class="icon">
	              <i class="glyphicon glyphicon-check"></i>
	            </div>
	            <a href="#" class="small-box-footer">Exibir Retirada(s) <i class="fa fa-arrow-circle-right"></i></a>
	          </div>
	        </div>

        	<div class="col-lg-4 col-xs-6">
	          	<!-- small box -->
	          	<div class="small-box bg-green">
	            	<div class="inner">
	              		<h3>X</h3>
	              		<br>
	              		<strong><p>Laboratório(s) em uso</p></strong>
	            	</div>
	            	
	            	<div class="icon">
	              		<i class="glyphicon glyphicon-ok"></i>
	            	</div>
	            	<a href="#" class="small-box-footer">Exibir <i class="fa fa-arrow-circle-right"></i></a>
	          	</div>
        	</div>
    	</div>
	</section>
