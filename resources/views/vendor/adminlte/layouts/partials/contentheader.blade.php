<!-- Content Header (Page header) -->
@section('main-content')

  <section class="content-header">
    
    <h1>
      <span class='glyphicon glyphicon-stats'></span>
      @yield('contentheader_title', 'Painel de Controle')
      <small>@yield('contentheader_description')</small>
   	</h1>

  </section>

  @include('dashboards.administrador')
@endsection