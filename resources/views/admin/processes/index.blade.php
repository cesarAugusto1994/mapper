@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Processos <a href="{{route('process_create')}}" class="btn btn-lg bottom-right btn-primary pull-right">Novo</a></h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{route('home')}}">Painel</a>
                </li>
                <li class="active">
                    <strong>Processos</strong>
                </li>
            </ol>
        </div>
    </div>


    <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">

                @include('flash::message')

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Processos</h5>
                        <div class="ibox-tools">
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="project-list">

                            @if($processes->isNotEmpty())
                            <table class="table table-hover">
                                <tbody>
                                @foreach($processes as $process)
                                <tr>
                                    <td class="project-title">
                                        <a href="{{route('process', ['id' => $process->id])}}">{{$process->name}}</a>
                                        <br/>
                                        <small><a class="text-navy" href="{{ route('department', ['id' => $process->department_id]) }}">{{$process->department->name}}</a></small>
                                    </td>
                                    <td class="project-actions">
                                        <a data-id="{{ $process->id }}" class="btn btn-white btnCopiarProcesso" data-toggle="modal" data-target="#copiar-processo-modal"><i class="fa fa-copy"></i> Copiar </a>
                                        <a href="{{route('process_edit', ['id' => $process->id])}}" class="btn btn-white"><i class="fa fa-pencil"></i> Editar </a>

                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @else
                                <div class="alert alert-warning">Nenhum processo registrado até o momento.</div>
                            @endif
                        </div>
                    </div>
                </div>

                </div>
            </div>
        </div>

        <div class="modal inmodal" id="copiar-processo-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Copiar Processo</h4>
                    </div>
                    <form action="{{route('process_copy')}}" method="post">
                        {{csrf_field()}}
                        <div class="modal-body">
                            <input type="hidden" name="process_id" id="processId"/>
                            <div class="form-group"><label>Novo Processo</label>
                              <input type="text" required autofocus name="name" placeholder="Informe um nome à este processo" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

@endsection

@push('scripts')

  <script>

      $(document).ready(function() {
          $(".btnCopiarProcesso").click(function() {
              console.log($(this).data('id'));
              $("#processId").val($(this).data('id'));
          });
      });

  </script>

@endpush
