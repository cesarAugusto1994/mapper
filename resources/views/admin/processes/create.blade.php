@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Departamento</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li class="active">
                    <strong>Novo Processo</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Novo Processo</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal" action="{{route('processes_store')}}">
                            {{csrf_field()}}

                            <div class="row">

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group"><label class="col-sm-4 control-label">Nome</label>
                                        <div class="col-sm-8"><input type="text" name="name" required class="form-control"></div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                      <label class="col-sm-4 control-label">Departamento</label>
                                        <div class="col-sm-8">
                                          <select class="form-control m-b" required name="department_id" {{ !Auth::user()->isAdmin() ? 'readonly="readonly"' : '' }}>
                                                @foreach($departments as $department)
                                                    <option value="{{$department->id}}" @if(Auth::user()->isAdmin()) {{ Auth::user()->department->id == $department->id ? 'selected' : '' }} @endif>{{$department->name}}</option>
                                                @endforeach
                                            </select></div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Tempo Previsto</label>
                                        <div class="col-sm-8">
                                            <input type="time" required name="time" value="00:30" class="form-control"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                      <label class="col-sm-4 control-label">Frequencia</label>
                                        <div class="col-sm-8"><select class="form-control m-b" name="frequency_id">
                                                @foreach($frequencies as $frequency)
                                                    <option value="{{$frequency->id}}">{{$frequency->name}}</option>
                                                @endforeach
                                            </select></div>
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                              <div class="col-lg-1">
                              </div>
                              <div id="education_fields" class="col-lg-10">
                              </div>
                              <div class="col-lg-1">
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-lg-12 col-md-12 text-center">
                                <a class="btn btn-link" onclick="education_fields();"><i class="fa fa-plus"></i> Adicionar outro Processo</a>
                              </div>
                            </div>



                            <button class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

  <script>
      var room = 1;
      function education_fields() {

        room++;
        var objTo = document.getElementById('education_fields')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "form-group removeclass"+room);
        var rdiv = 'removeclass'+room;
        divtest.innerHTML = '<div class="col-xs-12"><div class="ibox float-e-margins">' +
                              '<div class="ibox-title">'+
                                  '<h5>Outro Processo</h5>'+
                                  '<div class="ibox-tools">'+
                                      '<button class="btn btn-danger btn-xs btn-block" type="button" onclick="remove_education_fields('+ room +');"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </button>'+
                                  '</div>'+
                              '</div>'+
                              '<div class="ibox-content">'+
                              '<div class="row">'+
                              "<div class='col-lg-3 col-md-6'>" +
                                  '<div class="form-group"><label class="col-sm-4 control-label">Nome</label>' +
                                      '<div class="col-sm-8"><input type="text" name="name" required class="form-control"></div>' +
                                  '</div>' +
                              '</div>' +

                              '<div class="col-lg-3 col-md-6">' +
                                  '<div class="form-group">' +
                                    '<label class="col-sm-4 control-label">Departamento</label>' +
                                      '<div class="col-sm-8">' +
                                        '<select class="form-control m-b" required name="department_id" {{ !Auth::user()->isAdmin() ? 'readonly="readonly"' : '' }}>' +
                                              @foreach($departments as $department)
                                                  '<option value="{{$department->id}}" @if(Auth::user()->isAdmin()) {{ Auth::user()->department->id == $department->id ? 'selected' : '' }} @endif>{{$department->name}}</option>' +
                                              @endforeach
                                          '</select></div>' +
                                  '</div>' +
                              '</div>' +

                              '<div class="col-lg-3 col-md-6">' +
                                  '<div class="form-group">' +
                                      '<label class="col-sm-4 control-label">Tempo Previsto</label>' +
                                      '<div class="col-sm-8">' +
                                          '<input type="time" required name="time" value="00:30" class="form-control"/>' +
                                      '</div>' +
                                  '</div>' +
                              '</div>' +

                              '<div class="col-lg-3 col-md-6">' +
                                  '<div class="form-group">' +
                                    '<label class="col-sm-4 control-label">Frequencia</label>' +
                                      '<div class="col-sm-8"><select class="form-control m-b" name="frequency_id">' +
                                              @foreach($frequencies as $frequency)
                                                  '<option value="{{$frequency->id}}">{{$frequency->name}}</option>' +
                                              @endforeach
                                          '</select></div>' +
                                  '</div>' +
                              '</div>'
                              + '<div class="col-xs-12"><div class="input-group-btn">' +
                               '</div></div></div></div></div></div>';

        objTo.appendChild(divtest)
      }
      function remove_education_fields(rid) {
       $('.removeclass'+rid).remove();
      }
  </script>

@endpush
