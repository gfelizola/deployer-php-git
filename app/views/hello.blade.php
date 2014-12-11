@extends('layouts.master')

@section('content-header')
    <h1>Painel</h1>
@stop

@section('content')
    <!-- Small boxes (Dados/Reports) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>44</h3>
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
                    <h3>65</h3>
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
                    <h3>53<sup style="font-size: 20px">%</sup>
                    </h3>
                    <p>Bounce Rate</p>
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
                    <h3>150</h3>
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
                <!-- timeline time label -->
                <li class="time-label">
                    <span class="bg-green">10 Fev. 2014</span>
                </li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <li>
                    <i class="fa fa-cloud-upload bg-blue"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
                        <h3 class="timeline-header"><a href="#">Daniel Basílio</a> realizou um deploy</h3>
                        <div class="timeline-body">
                            Projeto: Portal Estadão<br>
                            Tag: jira-ESTADAO-1621<br>
                            Status: <span class="label label-warning">Pendente</span>
                        </div>
                    </div>
                </li>
                <!-- END timeline item -->
                <!-- timeline item -->
                <li>
                    <i class="fa fa-level-down bg-red"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>
                        <h3 class="timeline-header no-border"><a href="#">João da Silva</a> realizou um rollback</h3>
                        <div class="timeline-body">
                            Projeto: Portal Estadão<br>
                            Tag: jira-ESTADAO-1601<br>
                            Status: <span class="label label-success">Realizado</span>
                        </div>
                    </div>
                </li>
                <!-- END timeline item -->
                <!-- timeline item -->
                <li>
                    <i class="fa fa-cloud-upload bg-blue"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
                        <h3 class="timeline-header"><a href="#">Daniel Basílio</a> realizou um deploy</h3>
                        <div class="timeline-body">
                            Projeto: Portal Estadão<br>
                            Tag: jira-ESTADAO-1621<br>
                            Status: <span class="label label-warning">Pendente</span>
                        </div>
                    </div>
                </li>
                <!-- END timeline item -->
                <!-- timeline time label -->
                <li class="time-label">
                    <span class="bg-green">9 Fev. 2014</span>
                </li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <!-- timeline item -->
                <li>
                    <i class="fa fa-cloud-upload bg-blue"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
                        <h3 class="timeline-header"><a href="#">Daniel Basílio</a> realizou um deploy</h3>
                        <div class="timeline-body">
                            Projeto: Portal Estadão<br>
                            Tag: jira-ESTADAO-1621<br>
                            Status: <span class="label label-warning">Pendente</span>
                        </div>
                    </div>
                </li>
                <!-- END timeline item -->
                <!-- timeline item -->
                <li>
                    <i class="fa fa-level-down bg-red"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>
                        <h3 class="timeline-header no-border"><a href="#">João da Silva</a> realizou um rollback</h3>
                        <div class="timeline-body">
                            Projeto: Portal Estadão<br>
                            Tag: jira-ESTADAO-1601<br>
                            Status: <span class="label label-success">Realizado</span>
                        </div>
                    </div>
                </li>
                <!-- END timeline item -->
                <!-- timeline item -->
                <li>
                    <i class="fa fa-cloud-upload bg-blue"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
                        <h3 class="timeline-header"><a href="#">Daniel Basílio</a> realizou um deploy</h3>
                        <div class="timeline-body">
                            Projeto: Portal Estadão<br>
                            Tag: jira-ESTADAO-1621<br>
                            Status: <span class="label label-warning">Pendente</span>
                        </div>
                    </div>
                </li>
                <!-- END timeline item -->
                <li>
                    <i class="fa fa-clock-o"></i>
                </li>
            </ul>
        </div><!-- /.col -->
    </div><!-- /.row -->
@stop