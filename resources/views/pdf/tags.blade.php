<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel='shortcut icon' type='image/x-icon' href="{{asset('admin/img/RedukLogo/favicon.ico')}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} | Etiquetas</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="http://cdn.jsdelivr.net/npm/inspinia@2.6.5/dist/inspinia.min.css"/>

    <style>

      @page {
          margin-top: 0;
          margin-left: 0;
          margin-right: 0;
          margin-bottom: 100;
      }

      @page {
      	header: page-header;
      	footer: page-footer;
        body: wrapper-content;
      }

      .page-header {
        margin-top: -80px !important;
      }

      p:last-child { page-break-after: auto; }
      .wrapper-content { padding: 2em 2em;}


    </style>

</head>

<body class="pace-done">
<htmlpageheader name="page-header" style="top:0;margin-top:0;padding-top:-440">
<div style="width:100%;max-height:100px;min-height:100px;padding:0.6em 0.6em;top:0;margin-top:0">
  <!--public_path('/admin/img/RedukLogo/LogoNegativoPdf.png-->
<img class="img" style="max-height:100px;padding:1.6em 1.6em" src="{{ 'http://www.provider-es.com.br/logo_marca.png' }}" alt="" />
</div>
</htmlpageheader>

  <div class="wrapper wrapper-content">
      <div class="ibox-content">
          <div class="row">

            @foreach($deliveries as $delivery)

              <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="panel panel-default">
                  <div class="panel-heading">{{ $delivery->client->name }}</div>
                  <div class="panel-body">

                    @foreach($delivery->documents as $document)
                    @php
                        $document = $document->document;
                    @endphp

                    <div class="row">

                      <div class="col-md-2" style="width:25%">

                        @php
                            $route = route('start_delivery', $document->uuid);
                        @endphp

                          {!! QrCode::size(145)->generate($route); !!}

                      </div>

                      <div class="col-md-10" style="width:75%">

                          <address>
                              {{ $document->address->street }},
                              {{ $document->address->number }},<br>
                              {{ $document->address->district }},
                              {{ $document->address->city }}
                              {{ $document->address->zip }}<br>
                              Referencia: {{ $document->address->reference }}<br>
                              Complemento: {{ $document->address->complement }}<br>
                              Email: {{ $document->client->email }}<br>
                              <abbr title="Phone">T:</abbr>{{ $document->client->phone }}
                          </address>

                          <address>
                            <strong>Entregador</strong><br>
                            <span id="entregador"><span class="text-navy">{{ $delivery->user->person->name }} - {{ $delivery->user->person->cpf }}</span></span>
                          </address>

                      </div>

                    </div>

                    @endforeach

                  </div>
                </div>
              </div>

            @endforeach


          </div>
      </div>
  </div>

  <htmlpagefooter name="page-footer">

  <div style="width:100%;display:inline-block;position:static;">

    <div class="row" style="border-top:2px solid red;padding:2em 2em;width:100%;display:inline-block;">

      <div class="col-lg-3">

        <h4>Etiquetas</h4>
        <h4>####</h4>

      </div>

        <div class="col-lg-3" style="width:25%">

          <b>Relatório gerado por:</b>


        </div>
        <div class="col-lg-3" style="width:25%">

          <b></b>

        </div>
        <div class="col-lg-3" style="width:25%">

          <b></b>

        </div>
        <div class="col-lg-3" style="width:25%">

          <b>www.provider-es.com.br</b>

        </div>
    </div>

  </div>

  </htmlpagefooter>

</body>

</html>
