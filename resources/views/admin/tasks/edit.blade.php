@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>Tarefa</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="/">Home</a>
                </li>
                <li class="active">
                    <strong>Editar Tarefa</strong>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Editar Tarefa</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" class="form-horizontal" action="{{route('task_update', ['id' => $task->id])}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Descrição</label>
                                <div class="col-sm-10">
                                    <input type="text" required name="description"
                                           placeholder="Uma nova Tarefa" class="form-control" value="{{$task->description}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Processo</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="process_id">
                                        @foreach($processes as $process)
                                            <option value="{{$process->id}}" {{$task->process_id == $process->id ? 'selected' : ''}}>{{$process->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Responsável</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="user_id" required>
                                        <option>Selecione um Responsável</option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}" {{ $user->id == $task->user_id ? 'selected' : '' }}>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Frequencia</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="frequency">

                                        <option value="">Nenhuma</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tempo</label>
                                <div class="col-sm-10">
                                    <input type="time" required name="time"
                                           placeholder="Uma nova Tarefa" class="form-control" value="{{$time}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Metodo</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="method">
                                        <option value="manual" {{ "manual" == $task->method ? 'selected' : '' }}>Manual</option>
                                        <option value="sistema" {{ "sistema" == $task->method ? 'selected' : '' }}>Sistema</option>
                                        <option value="internet" {{ "internet" == $task->method ? 'selected' : '' }}>Internet</option>
                                        <option value="outros" {{ "outros" == $task->method ? 'selected' : '' }}>Outros</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">indicador</label>
                                <div class="col-sm-10">
                                    <input type="text" name="indicator" placeholder="Sem Indicador" class="form-control" value="{{$task->indicator}}">
                                </div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label">Cliente</label>
                                <div class="col-sm-10"><select class="form-control m-b" name="client_id">
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}" {{ $department->id == $task->client_id ? 'selected' : '' }}>{{$department->name}}</option>
                                        @endforeach
                                    </select></div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label">Fornecedor</label>
                                <div class="col-sm-10"><select class="form-control m-b" name="vendor_id">
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}" {{ $department->id == $task->vendor_id ? 'selected' : '' }}>{{$department->name}}</option>
                                        @endforeach
                                    </select></div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Gravidade</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="severity">
                                        <option value="1" {{ 1 == $task->severity ? 'selected' : '' }}>1 (baixissima)</option>
                                        <option value="2" {{ 2 == $task->severity ? 'selected' : '' }}>2 (baixa)</option>
                                        <option value="3" {{ 3 == $task->severity ? 'selected' : '' }}>3 (moderada)</option>
                                        <option value="4" {{ 4 == $task->severity ? 'selected' : '' }}>4 (alta)</option>
                                        <option value="5" {{ 5 == $task->severity ? 'selected' : '' }}>5 (altissima)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Urgencia</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="urgency">
                                        <option value="1" {{ 1 == $task->urgency ? 'selected' : '' }}>1 (baixissima)</option>
                                        <option value="2" {{ 2 == $task->urgency ? 'selected' : '' }}>2 (baixa)</option>
                                        <option value="3" {{ 3 == $task->urgency ? 'selected' : '' }}>3 (moderada)</option>
                                        <option value="4" {{ 4 == $task->urgency ? 'selected' : '' }}>4 (alta)</option>
                                        <option value="5" {{ 5 == $task->urgency ? 'selected' : '' }}>5 (altissima)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Tendencia</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="trend">
                                        <option value="1" {{ 1 == $task->trend ? 'selected' : '' }}>1 (baixissima)</option>
                                        <option value="2" {{ 2 == $task->trend ? 'selected' : '' }}>2 (baixa)</option>
                                        <option value="3" {{ 3 == $task->trend ? 'selected' : '' }}>3 (moderada)</option>
                                        <option value="4" {{ 4 == $task->trend ? 'selected' : '' }}>4 (alta)</option>
                                        <option value="5" {{ 5 == $task->trend ? 'selected' : '' }}>5 (altissima)</option>
                                    </select>
                                </div>
                            </div>
                            <button class="btn btn-primary">Salvar</button>
                            <a href="{{route('task', ['id' => $task->id])}}" class="btn btn-danger">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
