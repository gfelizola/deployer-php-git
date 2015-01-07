@extends('layouts.master')

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
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{{ $deploys }}}</h3>
                    <p>Deploys realizados</p>
                </div>
                <div class="icon">
                    <i class="fa fa-cloud-upload"></i>
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{{ $rollbacks }}}</h3>
                    <p>Rollbacks realizados</p>
                </div>
                <div class="icon">
                    <i class="fa fa-level-down"></i>
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{{ $media }}}<sup style="font-size: 20px">%</sup></h3>
                    <p>Média de sucesso</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
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

                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> {{ $historico->created_at->format('H:i') }}</span>
                        <h3 class="timeline-header">
                            @if( $historico->user )
                            <a href="usuario/{{ $historico->user->id }}">
                                <img src="{{ $historico->user->avatar }}" width="25" height="25" class="img-circle" alt="{{{ $historico->user->nome }}}">
                                    {{{ $historico->user->nome }}}
                            </a>
                            @endif
                        </h3>
                        <div class="timeline-body">
                            <p>{{{ $historico->descricao }}}</p>
                            <p>
                                @if( $historico->projeto )
                                    <b>Projeto:</b> {{ $historico->projeto->nome }}<br>
                                @endif

                                @if( $historico->deploy )
                                    <b>Servidor:</b> {{ $historico->deploy->servidor->nome }} <i>({{ preg_replace( '/\:.+\/?/', '', $historico->deploy->servidor->endereco )  }})</i><br>
                                    <b>Tag:</b> {{ $historico->deploy->tag }}<br>
                                @endif
                            </p>
                        </div>
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