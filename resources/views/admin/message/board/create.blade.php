@extends('layouts.layout')

@section('content')

      <div class="row wrapper border-bottom white-bg page-heading">
          <div class="col-lg-12">
              <h2>Mural de Recados</h2>
              <ol class="breadcrumb">
                  <li>
                      <a href="{{ route('home') }}">Painel Principal</a>
                  </li>
                  <li>
                      <a href="{{ route('message-board.index') }}">Mural de Recados</a>
                  </li>
                  <li class="active">
                      <strong>Novo</strong>
                  </li>
              </ol>
          </div>

      </div>

      <div class="wrapper wrapper-content animated fadeInUp">

      <div class="row">
          <div class="col-lg-3">
              <div class="ibox ">
                  <div class="ibox-content mailbox-content">
                      <div class="file-manager">
                          <h5>Folders</h5>
                          <ul class="folder-list m-b-md" style="padding: 0">
                              <li><a href="mailbox.html"> <i class="fa fa-inbox "></i> Inbox <span class="label label-warning float-right">16</span> </a></li>
                              <li><a href="mailbox.html"> <i class="fa fa-envelope-o"></i> Send Mail</a></li>
                              <li><a href="mailbox.html"> <i class="fa fa-certificate"></i> Important</a></li>
                              <li><a href="mailbox.html"> <i class="fa fa-file-text-o"></i> Drafts <span class="label label-danger float-right">2</span></a></li>
                              <li><a href="mailbox.html"> <i class="fa fa-trash-o"></i> Trash</a></li>
                          </ul>
                          <h5>Categories</h5>
                          <ul class="category-list" style="padding: 0">
                              <li><a href="#"> <i class="fa fa-circle text-navy"></i> Work </a></li>
                              <li><a href="#"> <i class="fa fa-circle text-danger"></i> Documents</a></li>
                              <li><a href="#"> <i class="fa fa-circle text-primary"></i> Social</a></li>
                              <li><a href="#"> <i class="fa fa-circle text-info"></i> Advertising</a></li>
                              <li><a href="#"> <i class="fa fa-circle text-warning"></i> Clients</a></li>
                          </ul>

                          <h5 class="tag-title">Labels</h5>
                          <ul class="tag-list" style="padding: 0">
                              <li><a href=""><i class="fa fa-tag"></i> Family</a></li>
                              <li><a href=""><i class="fa fa-tag"></i> Work</a></li>
                              <li><a href=""><i class="fa fa-tag"></i> Home</a></li>
                              <li><a href=""><i class="fa fa-tag"></i> Children</a></li>
                              <li><a href=""><i class="fa fa-tag"></i> Holidays</a></li>
                              <li><a href=""><i class="fa fa-tag"></i> Music</a></li>
                              <li><a href=""><i class="fa fa-tag"></i> Photography</a></li>
                              <li><a href=""><i class="fa fa-tag"></i> Film</a></li>
                          </ul>
                          <div class="clearfix"></div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-lg-9 animated fadeInRight">
          <div class="mail-box-header">
              <h2>
                  Novo Recado
              </h2>
          </div>
          <div class="mail-box">

              <div class="mail-body">

                  <form method="post" action="{{ route('message-board.store') }}">
                      {{ csrf_field() }}

                      <div class="form-group row"><label class="col-sm-2 col-form-label">Departamento:</label>
                          <div class="col-sm-10">

                            <select class="form-control select2" id="select-department" data-route="{{ route('departments_users_search') }}" name="to[]" multiple="multiple" required>
                              <option value="">Toda Empresa</option>
                              @foreach($departments as $department)
                                  <option value="{{ $department->id }}">{{ $department->name }}</option>
                              @endforeach
                            </select>

                          </div>
                      </div>

                      <div class="form-group row"><label class="col-sm-2 col-form-label">Para:</label>
                          <div class="col-sm-10">

                            <select class="form-control select2" id="select-user" name="to[]" multiple="multiple">
                              <option value="">Todas</option>
                            </select>

                          </div>
                      </div>

                      <div class="form-group row"><label class="col-sm-2 col-form-label">Assunto:</label>
                          <div class="col-sm-10"><input required type="text" class="form-control" value=""></div>
                      </div>

                      <div class="hr-line-dashed"></div>

                      <div class="mail-text h-200">
                            <div class="summernote" style="display: none;">
                                <h3>Hello Jonathan! </h3>
                                dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
                                when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
                                typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
                            </div>
                        <div class="clearfix"></div>
                            <div class="mail-body text-right tooltip-demo">
                                <button type="submit" class="btn btn-sm btn-primary">Enviar</button>
                                <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Discard email"><i class="fa fa-times"></i> Descartar</a>
                                <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Move to draft folder"><i class="fa fa-pencil"></i> Rascunho</a>
                            </div>
                        <div class="clearfix"></div>
                      </div>

                  </form>

              </div>

          </div>
      </div>

      </div>

      </div>

@endsection
