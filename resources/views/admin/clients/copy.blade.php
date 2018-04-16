@extends('layouts.layout')

@push('stylesheets')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.3/chosen.min.css">
@endpush

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Processo</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/">Home</a>
                </li>
                <li class="active">
                    <strong>Gerar Tarefas</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">

                @include('flash::message')

                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Gerar Tarefas</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal" action="{{route('process_copy')}}">
                            {{csrf_field()}}

                            <div class="row">

                                <div class="col-lg-12 col-md-6">
                                    <div class="form-group"><label class="col-sm-2 control-label">Nome</label>
                                        <div class="col-sm-10">
                                          <input type="hidden" name="process_id" value="{{ $process->id }}">
                                          <input type="text" disabled value="{{ $process->name }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group"><label class="col-sm-2 control-label">Clientes</label>
                                      <div class="col-sm-10">
                                      <div class="ibox-content">

                                          <div class="project-list">
                                              @if($clients->isNotEmpty())
                                                  <table class="table table-hover">
                                                      <tbody>
                                                          @foreach($clients as $client)
                                                              <tr>
                                                                <td class="project-title" style="width:20px">
                                                                    <input name="clients[]" type="checkbox" {{ \App\Http\Controllers\TaskController::existsTaskByClient($client, $process) ? 'disabled' : '' }} value="{{ $client->id }}">
                                                                </td>
                                                                  <td class="project-title">
                                                                      <a href="#">{{$client->name}}</a>
                                                                  </td>
                                                              </tr>
                                                          @endforeach
                                                      </tbody>
                                                  </table>
                                              @else
                                                  <div class="alert alert-warning text-center">Nenhum cliente registrado até o momento.</div>
                                              @endif
                                          </div>

                                      </div>
                                      </div>
                                    </div>

                                </div>
                            </div>
                            @if($clients->isNotEmpty())
                            <button class="btn btn-primary">Salvar</button>
                            @endif
                            <a href="{{route('processes')}}" class="btn btn-white">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.pt-BR.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.3/chosen.jquery.min.js"></script>

  <script>

      var periodo = $(".periodo");
      var semana = $(".semana");
      var horario = $(".horario");

      periodo.hide();
      semana.hide();
      horario.hide();

      $('.clockpicker').clockpicker();

      $(".select-date").chosen();

      $(document).ready(function() {
          $('.input-daterange').datepicker({
            format: "dd/mm/yyyy",
            clearBtn: true,
            todayHighlight: true,
            autoclose: true,
            language: "pt-BR"
          });
      });

      var tempo = new Date();
      var hora = tempo.getHours();
      var minutos = tempo.getMinutes();

      $("#frequencia").change(function() {

          var self = $(this);
          var frequencia = self.val();

          if(self.val() === '2') {

              horario.show();
              $("#time").val(hora + ':' + minutos);

          } else {
              horario.hide();
              $("#time").val("");
          }

          if(self.val() === '3') {
              semana.show();
              horario.show();
              $("#time").val(hora + ':' + minutos);
          } else {
              semana.hide();
          }

          if(self.val() === '4') {
              periodo.show();
          } else {
              periodo.hide();
          }

      });

  </script>

@endpush
