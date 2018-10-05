@section('main-content')
  
  <section class="content-header">
   
    <h1>
      <span class='glyphicon glyphicon-stats'></span>
      @yield('contentheader_title', 'Painel de Controle')
      
      <small>
        @yield('contentheader_description')
      </small>
    </h1>

  </section>
  

  <!-- Small boxes (Stat box) -->
  <!-- row -->
    <div class="row">
     <br><br>
    </div>
    <!-- row -->
    <div class="row">
      <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-disabled" style="color: black;">
          <div class="inner">
            <h3>Geral</h3>
            <p>Equipamentos Total/Disponíveis: </p>
            <p>Ambientes Total/Disponíveis: </p>
          </div>

          <div class="icon">
            <i class="glyphicon glyphicon-eye-open"></i>
          </div>
          <span class="small-box-footer" ><br></span>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-6 col-xs-6">
      <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>X</h3>
              <p>Reserva(s) de laboratório(s) agendadas para hoje</p>
            <br>
          </div>
          <div class="icon">
            <i class="fa fa-calendar-check-o"></i>
          </div>
          <a href="{{url('reserva-ambiente')}}" class="small-box-footer">Exibir reserva(s) <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
    
    <!-- row -->
    <div class="row">
      <!-- ./col -->
      <div class="col-lg-6 col-xs-6">
      <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>X</h3>
            <p>Equipamento(s) com defeito</p>
          </div>
          <div class="icon">
            <i class="glyphicon glyphicon-thumbs-down"></i>
          </div>
          <a href="{{ url('equipamentos') }}" class="small-box-footer">Exibir <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>X</h3>
            <p>Reserva(s) de equipamento(s) aguardando retirada hoje</p>
          </div>
          <div class="icon">
            <i class="fa fa-calendar-check-o "></i>
          </div>
          <a href="#" class="small-box-footer">Exibir reserva(s) <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>  
    </div>

    <!-- row -->
    <div class="row">
      <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>X</h3>
            <p>Retirada(s) de equipamento em andamento</p>
          </div>
          <div class="icon">
            <i class="glyphicon glyphicon-check"></i>
          </div>
          <a href="#" class="small-box-footer">Exibir Retirada(s) <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>X</h3>
            <p>Laboratório(s) em uso</p>
          </div>
          <div class="icon">
            <i class="glyphicon glyphicon-ok"></i>
          </div>
          <a href="{{ url('equipamentos') }}" class="small-box-footer">Exibir <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
@endsection