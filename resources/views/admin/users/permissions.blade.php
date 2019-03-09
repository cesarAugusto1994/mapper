@extends('layouts.layout')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <h2>Regras de Acesso </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('home') }}">Painel Principal</a>
                </li>
                <li>
                    <a href="{{ route('users') }}">Usuários</a>
                </li>
                <li class="active">
                    <strong>Permissões</strong>
                </li>
            </ol>
        </div>

    </div>


    <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">

                  <div class="row">

                  @foreach($permissionsGroupedByModule as $keyModuleName =>  $module)

                    <div class="col-lg-4">

                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>{{$keyModuleName}}</h5>
                            <div class="ibox-tools">

                            </div>
                        </div>
                        <div class="ibox-content">

                            <div class="project-list">

                                @if($module)
                                <table class="table table-hover">
                                    <tbody>
                                    @foreach($module as $permission)

                                    @php
                                        $hasPermission = $user->hasPermission($permission->slug);
                                    @endphp

                                    <tr>
                                        <td class="project-title">
                                            <p>Acesso:</p>
                                            <a href="#">{{$hasPermission ? 'SIM' : 'NÃO'}}</a>
                                        </td>
                                        <td class="project-title">
                                            <p>Nome:</p>
                                            <a href="#">{{$permission->name}}</a>
                                        </td>
                                        <td class="project-title">
                                            <p>Descrição:</p>
                                            <a href="#">{{$permission->description}}</a>
                                        </td>
                                        <td class="project-actions">
                                          @if($hasPermission)
                                            <a data-route="{{route('user_permissions_revoke', [$user->uuid, $permission->id])}}" class="btn btn-danger dim btnPermissionRevoke"><i class="fa fa-close"></i> </a>
                                          @else
                                            <a data-route="{{route('user_permissions_grant', [$user->uuid, $permission->id])}}" class="btn btn-primary dim btnPermissionGrant"><i class="fa fa-check"></i>  </a>
                                          @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                    <div class="alert alert-warning">Nenhum sub-processo registrado até o momento.</div>
                                @endif
                            </div>
                        </div>
                    </div>

                  </div>

                  @endforeach

                  </div>

                </div>
            </div>
        </div>

@endsection

@push('scripts')
    <script>

      $(".btnPermissionGrant").click(function(e) {

          var self = $(this);

          swal({
            title: 'Conceder esta Permissão?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.value) {

              e.preventDefault();

              $.ajax({
                headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                url: self.data('route'),
                type: 'POST',
                dataType: 'json',
                data: {}
              }).done(function(data) {

                if(data.success) {

                  const toast = swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                  });

                  toast({
                    type: 'success',
                    title: 'Ok!, o registro foi removido com sucesso.'
                  });

                  window.location.reload();

                } else {

                  Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: data.message,
                  })

                }

              });
            }
          });

      });

      $(".btnPermissionRevoke").click(function(e) {

          var self = $(this);

          swal({
            title: 'Revogar esta Permissão?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
            if (result.value) {

              e.preventDefault();

              $.ajax({
                headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                url: self.data('route'),
                type: 'POST',
                dataType: 'json',
                data: {}
              }).done(function(data) {

                if(data.success) {

                  const toast = swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                  });

                  toast({
                    type: 'success',
                    title: 'Ok!, o registro foi removido com sucesso.'
                  });

                  window.location.reload();

                } else {

                  Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: data.message,
                  })

                }

              });
            }
          });

      });

    </script>
@endpush
