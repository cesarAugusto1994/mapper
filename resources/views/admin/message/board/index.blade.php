@extends('layouts.layout')

@section('content')

      <div class="row wrapper border-bottom white-bg page-heading">
          <div class="col-lg-10">
              <h2>Mural de Recados</h2>
              <ol class="breadcrumb">
                  <li>
                      <a href="{{ route('home') }}">Painel Principal</a>
                  </li>
                  <li class="active">
                      <strong>Mural de Recados</strong>
                  </li>
              </ol>
          </div>

          <div class="col-lg-2">
            @permission('create.mural')
              <a href="{{route('message-board.create')}}" class="btn btn-primary btn-block dim m-t-lg">Novo Recado</a>
            @endpermission
          </div>

      </div>

      <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-content mailbox-content">
                        <div class="file-manager">
                            <a class="btn btn-block btn-primary compose-mail" href="{{route('message-board.create')}}">Novo</a>
                            <div class="space-25"></div>
                            <h5>Folders</h5>
                            <ul class="folder-list m-b-md" style="padding: 0">
                                <li><a href="#"> <i class="fa fa-inbox "></i> Inbox <span class="label label-warning float-right">16</span> </a></li>
                                <li><a href="#"> <i class="fa fa-envelope-o"></i> Send Mail</a></li>
                                <li><a href="#"> <i class="fa fa-certificate"></i> Important</a></li>
                                <li><a href="#"> <i class="fa fa-file-text-o"></i> Drafts <span class="label label-danger float-right">2</span></a></li>
                                <li><a href="#"> <i class="fa fa-trash-o"></i> Trash</a></li>
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
                    Entrada
                </h2>
                <div class="mail-tools tooltip-demo m-t-md">
                    <div class="btn-group float-right">
                        <button class="btn btn-white btn-sm"><i class="fa fa-arrow-left"></i></button>
                        <button class="btn btn-white btn-sm"><i class="fa fa-arrow-right"></i></button>

                    </div>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="left" title="Refresh inbox"><i class="fa fa-refresh"></i> Refresh</button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mark as read"><i class="fa fa-eye"></i> </button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Mark as important"><i class="fa fa-exclamation"></i> </button>
                    <button class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>

                </div>
            </div>
                <div class="mail-box">

                <table class="table table-hover table-mail">
                <tbody>

                @foreach($messages as $message)
                <tr class="unread">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">{{ $message->user->person->name }}</a></td>
                    <td class="mail-subject"><a href="#">{{ $message->subject }}</a></td>
                    <td class=""><i class="fa fa-paperclip"></i></td>
                    <td class="text-right mail-date">{{ $message->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach

                <tr class="unread">
                    <td class="check-mail">
                        <div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" class="i-checks" checked="" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Jack Nowak</a></td>
                    <td class="mail-subject"><a href="#">Aldus PageMaker including versions of Lorem Ipsum.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">8.22 PM</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Facebook</a> <span class="label label-warning float-right">Clients</span> </td>
                    <td class="mail-subject"><a href="#">Many desktop publishing packages and web page editors.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Jan 16</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Mailchip</a></td>
                    <td class="mail-subject"><a href="#">There are many variations of passages of Lorem Ipsum.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Mar 22</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Alex T.</a> <span class="label label-danger float-right">Documents</span></td>
                    <td class="mail-subject"><a href="#">Lorem ipsum dolor noretek imit set.</a></td>
                    <td class=""><i class="fa fa-paperclip"></i></td>
                    <td class="text-right mail-date">December 22</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Monica Ryther</a></td>
                    <td class="mail-subject"><a href="#">The standard chunk of Lorem Ipsum used.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Jun 12</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Sandra Derick</a></td>
                    <td class="mail-subject"><a href="#">Contrary to popular belief.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">May 28</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Patrick Pertners</a> <span class="label label-info float-right">Adv</span></td>
                    <td class="mail-subject"><a href="#">If you are going to use a passage of Lorem </a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">May 28</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Michael Fox</a></td>
                    <td class="mail-subject"><a href="#">Humour, or non-characteristic words etc.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Dec 9</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Damien Ritz</a></td>
                    <td class="mail-subject"><a href="#">Oor Lorem Ipsum is that it has a more-or-less normal.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Jun 11</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Anna Smith</a></td>
                    <td class="mail-subject"><a href="#">Lorem ipsum dolor noretek imit set.</a></td>
                    <td class=""><i class="fa fa-paperclip"></i></td>
                    <td class="text-right mail-date">6.10 AM</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Jack Nowak</a></td>
                    <td class="mail-subject"><a href="#">Aldus PageMaker including versions of Lorem Ipsum.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">8.22 PM</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Mailchip</a></td>
                    <td class="mail-subject"><a href="#">There are many variations of passages of Lorem Ipsum.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Mar 22</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Alex T.</a> <span class="label label-warning float-right">Clients</span></td>
                    <td class="mail-subject"><a href="#">Lorem ipsum dolor noretek imit set.</a></td>
                    <td class=""><i class="fa fa-paperclip"></i></td>
                    <td class="text-right mail-date">December 22</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Monica Ryther</a></td>
                    <td class="mail-subject"><a href="#">The standard chunk of Lorem Ipsum used.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Jun 12</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Sandra Derick</a></td>
                    <td class="mail-subject"><a href="#">Contrary to popular belief.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">May 28</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Patrick Pertners</a> </td>
                    <td class="mail-subject"><a href="#">If you are going to use a passage of Lorem </a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">May 28</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Michael Fox</a></td>
                    <td class="mail-subject"><a href="#">Humour, or non-characteristic words etc.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Dec 9</td>
                </tr>
                <tr class="read">
                    <td class="check-mail">
                        <div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                    </td>
                    <td class="mail-ontact"><a href="#">Damien Ritz</a></td>
                    <td class="mail-subject"><a href="#">Oor Lorem Ipsum is that it has a more-or-less normal.</a></td>
                    <td class=""></td>
                    <td class="text-right mail-date">Jun 11</td>
                </tr>
                </tbody>
                </table>


                </div>
            </div>
        </div>
        </div>

@endsection
