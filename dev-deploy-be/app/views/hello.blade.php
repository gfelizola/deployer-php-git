@extends('layouts.master')

@section('head-extra')
    <!-- Morris charts -->
    <link href="/css/morris/morris.css" rel="stylesheet" type="text/css" />
@stop

@section('content-header')
    <h1>Painel</h1>
@stop

@section('content')
    
    @if ( isset($mensagem) )
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <b>Aviso!</b><br>
        {{{$mensagem}}}
    </div>
    @endif

    <!-- Small boxes (Dados/Reports) -->
    <div class="row">
        <div class="col-md-9 col-xs-12">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="nav-tabs-custom">
                <!-- Tabs within a box -->
                <ul class="nav nav-tabs pull-right">
                    <li><a href="#projetos-chart" data-toggle="tab">Projetos</a></li>
                    <li class="active"><a href="#deploys-chart" data-toggle="tab">Geral</a></li>
                    <li class="pull-left header"><i class="fa fa-cloud-upload"></i> Deploys e Rollbacks</li>
                </ul>
                <div class="tab-content">
                    <!-- Morris chart - Sales -->
                    <div class="chart tab-pane active" id="deploys-chart" style="position: relative; height: 170px;"></div>
                    <div class="chart tab-pane" id="projetos-chart" style="position: relative; height: 170px;"></div>
                </div>
            </div><!-- /.nav-tabs-custom -->

        </div><!-- /.col (LEFT) -->
        <div class="col-lg-3 col-xs-12">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{{ $media }}}<sup style="font-size: 20px">%</sup></h3>
                    <p>Média de sucesso</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
             <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{{ $usuarios }}}</h3>
                    <p>Usuários</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-md"></i>
                </div>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->

    <!-- Timelines/Histórico -->
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <!-- The time line -->
            <ul class="timeline">
                @foreach($historicos as $k => $h)

                <!-- timeline time label -->
                <li class="time-label">
                    <span class="bg-green">{{$k}}</span>
                </li>
                <!-- /.timeline-label -->

                @foreach($h as $historico)
                <!-- timeline item -->
                <li>
                    @if( $historico->tipo == Historico::TipoUsuario )
                        <i class="fa fa-user bg-navy"></i>
                    @elseif( $historico->tipo == Historico::TipoDeploy )
                        <i class="fa fa-cloud-upload bg-blue"></i>
                    @elseif( $historico->tipo == Historico::TipoRollBack )
                        <i class="fa fa-level-down bg-red"></i>
                    @elseif( $historico->tipo == Historico::TipoProjeto )
                        <i class="fa fa-desktop bg-orange"></i>
                    @endif

                    <div class="timeline-item row">
                        <h3 class="timeline-header col-md-3">
                            
                            @if( $historico->user )
                            <a href="usuario/{{ $historico->user->id }}" class="">
                                <img src="{{ $historico->user->avatar }}" width="30" height="30" class="img-circle" alt="{{{ $historico->user->nome }}}">
                                    {{{ $historico->user->nome }}}
                            </a>
                            @endif
                        </h3>

                        <div class="col-md-3">
                            <p>{{{ $historico->descricao }}}</p>
                        </div>
                        <div class="col-md-5">
                            <p>
                                @if( $historico->projeto )
                                    <i class="fa fa-code"></i> {{ $historico->projeto->nome }}<br>
                                @endif

                                @if( $historico->deploy )
                                    <i class="fa fa-desktop"></i> {{ $historico->deploy->servidor->nome }}<br>
                                    <i class="fa fa-tags"></i> {{ $historico->deploy->tag }}<br>
                                @endif
                            </p>
                        </div>

                        <span class="time col-md-1 pull-right"><i class="fa fa-clock-o"></i> {{ $historico->created_at->format('H:i') }}</span>

                    </div>
                </li>
                <!-- END timeline item -->
                @endforeach

                @endforeach

                <li>
                    <i class="fa fa-clock-o"></i>
                </li>
            </ul>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop

@section('footer-extra')
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="/js/plugins/morris/morris.min.js"></script>
    <script>
        var dadosGraficoDR = {{ $dadosDR }};
        var dadosGraficoP  = {{ $dadosP }};
    </script>
@stop