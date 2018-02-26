        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <img alt="image" style="max-width:64px;max-height:64px" class="img-circle" src="{{Gravatar::get(Auth::user()->email)}}" />
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth()->user()->name }}</strong>
                             </span> <span class="text-muted text-xs block">{{  Auth::user()->department->name ?? '' }} <b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="{{route('user', ['id' => Auth()->user()->id])}}">Perfil</a></li>
                                <li class="divider"></li>
                                <li><a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            MP+
                        </div>
                    </li>
                    <li>
                        <a href="{{route('home')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Painel</span> </a>
                    </li>
                    <li>
                        <a href="{{route('boards')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Board</span></a>
                    </li>
                    <li>
                        <a href="{{route('mappings')}}"><i class="fa fa-th-large"></i> <span class="nav-label">Mapeamentos</span></a>
                    </li>
                    <li>
                        <a href="{{route('departments')}}"><i class="fa fa-balance-scale"></i> <span class="nav-label">Departamentos</span></a>
                    </li>
                    <li>
                        <a href="{{route('processes')}}"><i class="fa fa-cogs"></i> <span class="nav-label">Processos</span></a>
                    </li>

                    <li>
                      <a href="{{route('tasks')}}"><i class="fa fa-calendar"></i> <span class="nav-label">Tarefas</span></a>
                    </li>

                    <li>
                        <a href="{{route('users')}}"><i class="fa fa-users"></i> <span class="nav-label">Usuarios</span></a>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-file-o"></i> <span class="nav-label">Relatórios e Desempenho</span></a>
                    </li>

                </ul>

            </div>
        </nav>
