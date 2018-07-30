<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Pesquisar..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header"><strong>MENU</strong></li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="{{ url('home') }}"><i class='fa fa-home'></i> <span>Início</span></a></li>

            <li class="treeview">
                <a href="#"><i class='fa fa-user'></i> <span>Gestão de Usuários</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('users') }}">Usuários</a></li>
                    <li><a href="#">Tipos de Usuários</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-television'></i> <span>Gestão de Equipamentos</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class='fa fa-calendar'></i>Reservas e Retiradas</a></li>
                    <li><a href="#">Equipamentos</a></li>
                    <li><a href="#">Tipos de Equipamentos</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#"><i class='fa fa-university'></i><span>Gestão de Laboratórios</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class='fa fa-calendar'></i>Reservas de Laboratórios</a></li>
                    <li><a href="#">Laboratórios</a></li>
                </ul>
            </li>

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
