        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <img alt="image" style="max-width:64px;max-height:64px" class="img-circle" src="{{Auth::user()->avatar}}" />
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ Auth()->user()->person->name }}</strong>
                            </span> <span class="text-muted text-xs block">{{  Auth::user()->person->department->name ?? '' }} <b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="{{route('user')}}">Perfil</a></li>
                                <li class="divider"></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            MP+
                        </div>
                    </li>

                    @permission('view.painel.principal')

                      <li>
                          <a href="{{route('home')}}" ><i class="fa fa-th-large"></i> <span class="nav-label">Painel Principal</span> </a>
                      </li>

                    @endpermission


                    @permission('view.clientes')

                      <li>
                          <a href="{{route('clients.index')}}" ><i class="fa fa-users"></i> <span class="nav-label">Clientes</span></a>
                      </li>

                    @endpermission

                      <li>
                          <a href="{{route('clients.index')}}" ><i class="fa fa-building"></i> <span class="nav-label">Comercial</span></a>
                      </li>

                      <li>
                          <a href="{{route('clients.index')}}" ><i class="fa fa-money"></i> <span class="nav-label">Financeiro</span></a>
                      </li>

                      <li>
                          <a href="{{route('clients.index')}}" ><i class="fa fa-car"></i> <span class="nav-label">Frota</span></a>
                      </li>

                    @permission('view.treinamentos')

                    <li class="">
                        <a href="#" data-step="3" data-intro="Aqui você vai encontrar o seu painel de Gestão de Entregas">
                          <i class="fa fa-gear"></i> <b class="nav-label">Treinamentos </b><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse" style="height: 0px;">

                          @permission('view.cursos')

                            <li>
                                <a href="{{route('courses.index')}}" ><i class="fa fa-book"></i> <span class="nav-label">Cursos</span> </a>
                            </li>

                          @endpermission

                          @permission('view.alunos')

                            <li>
                                <a href="{{route('students.index')}}" ><i class="fa fa-users"></i> <span class="nav-label">Alunos</span> </a>
                            </li>

                          @endpermission

                          @permission('view.turmas')

                            <li>
                                <a href="{{route('teams.index')}}" ><i class="fa fa-users"></i> <span class="nav-label">Turmas</span> </a>
                            </li>

                          @endpermission

                          @permission('view.agenda')

                            <li>
                                <a href="{{route('teams.index')}}" ><i class="fa fa-calendar"></i> <span class="nav-label">Agenda</span> </a>
                            </li>

                          @endpermission

                        </ul>
                    </li>

                    @endpermission

                    @permission('view.gestao.de.entregas')

                    <li class="">
                        <a href="#" data-step="3" data-intro="Aqui você vai encontrar o seu painel de Gestão de Entregas">
                          <i class="fa fa-truck"></i> <b class="nav-label">Gestão de Entregas </b><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse" style="height: 0px;">

                          @permission('view.documentos')

                            <li>
                                <a href="{{route('documents.index')}}" ><i class="fa fa-file-o"></i> <span class="nav-label">Documentos</span> </a>
                            </li>

                          @endpermission

                          @permission('view.ordem.entrega')

                            <li>
                                <a href="{{route('delivery-order.index')}}" ><i class="fa fa-archive"></i> <span class="nav-label">Entregas</span> </a>
                            </li>

                          @endpermission

                        </ul>
                    </li>

                    @endpermission

                    @permission('view.gestao.de.processos')

                    <li class="">
                        <a href="#" data-step="3" data-intro="Aqui você vai encontrar o seu painel de Gestão de Processos">
                          <i class="fa fa-cogs"></i> <b class="nav-label">Gestão de Processos </b><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse" style="height: 0px;">
                          @permission('view.board')
                            <li>
                                <a href="{{route('boards')}}" ><i class="fa fa-th-large"></i> <span class="nav-label">Board</span></a>
                            </li>
                          @endpermission
                          @permission('view.mapeamentos')
                            <li>
                                <a href="{{route('mappings')}}" ><i class="fa fa-th-large"></i> <span class="nav-label">Mapeamentos</span></a>
                            </li>
                          @endpermission
                          @permission('view.processos')
                            <li>
                                <a href="{{route('processes')}}" ><i class="fa fa-cogs"></i> <span class="nav-label">Processos</span></a>
                            </li>
                          @endpermission
                          @permission('view.tarefas')
                            <li>
                              <a href="{{route('tasks')}}" ><i class="fa fa-calendar"></i> <span class="nav-label">Tarefas</span></a>
                            </li>
                          @endpermission
                        </ul>
                    </li>

                    @endpermission

                    @permission('view.administrativo')

                        <li class="">
                            <a href="#" data-step="3" data-intro="Aqui você vai encontrar o seu painel Administrativo">
                              <i class="fa fa-list-alt"></i> <b class="nav-label">Administrativo </b><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse" style="height: 0px;">
                              @permission('view.departamentos')
                              <li>
                                  <a href="{{route('departments')}}" ><i class="fa fa-balance-scale"></i> <span class="nav-label">Departamentos</span></a>
                              </li>
                              @endpermission

                              @permission('view.cargos')
                              <li>
                                  <a href="{{route('occupations.index')}}" ><i class="fa fa-balance-scale"></i> <span class="nav-label">Cargos</span></a>
                              </li>
                              @endpermission

                              @permission('view.usuarios')
                              <li>
                                  <a href="{{route('users')}}" ><i class="fa fa-users"></i> <span class="nav-label">Usuarios</span></a>
                              </li>
                              @endpermission
                              @permission('view.privilegios')
                              <li>
                                  <a href="{{route('roles.index')}}" ><i class="fa fa-users"></i> <span class="nav-label">Privilégios</span></a>
                              </li>
                              @endpermission
                              @permission('view.permissoes')
                              <li>
                                  <a href="{{route('permissions.index')}}" ><i class="fa fa-key"></i> <span class="nav-label">Permissões</span></a>
                              </li>
                              @endpermission

                              <li>
                                  <a href="{{route('types.index')}}" ><i class="fa fa-file-o"></i> <span class="nav-label">Tipos de Documentos</span></a>
                              </li>


                            </ul>
                        </li>

                      @endpermission

                      <li>

                        <a class="btnRedirectSoc"><i class="fa fa-key"></i> <span class="nav-label">SOC</span></a>

                        <form method="post" action="https://www.soc.com.br/WebSoc/LoginAction.do" id="formularioLoginSoc" target="_blank" class="hidden">
                          <input required="" name="usu" id="usu" value="{{ \Auth::user()->login_soc }}" type="text" class="FormatForm hidden" placeholder="Usuário">
                          <input required="" name="senha" id="senha" value="{{ \Auth::user()->password_soc }}" type="password" class="FormatForm hidden" placeholder="Senha">
                          <div class="row">
                            <div class="column column-8">
                              <input required="" name="empsoc" id="empsoc" value="{{ \Auth::user()->id_soc }}" type="text" class="FormatForm hidden" placeholder="ID">
                            </div>
                          </div>
                        </form>
                      </li>

                      <li>
                          <a href="http://webmail.provider-es.com.br/?zinitmode=http" target="_blank" ><i class="fa fa-envelope-o"></i> <span class="nav-label">Webmail</span></a>
                      </li>


                      <li>
                        <a href="{{route('task_calendar')}}"><i class="fa fa-calendar"></i> <span class="nav-label">Calendário</span></a>
                      </li>

                </ul>

            </div>
        </nav>
