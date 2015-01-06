@extends('layouts.master')

@section('content-header')
    <h1>
        {{ $projeto->nome }}
        <small>Deploys</small>
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">

            @if( $message )
            <div class="alert alert-success alert-dismissable">
                <i class="fa fa-ban"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{$message}}
            </div>
            @endif

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Lista de deploys</h3>
                    <div class="box-tools pull-right">
                        @foreach($projeto->servidores as $server)
                            <a href="{{{ URL::to('deploy', array($projeto->id, $server->id, 'create')) }}}" class="btn bg-navy">Deploy em {{{ $server->nome }}}</a>
                        @endforeach
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>Ações</th>
                            <th>Tag</th>
                            <th>Servidor</th>
                            <th>Autor</th>
                            <th>Efetuado em</th>
                        </tr>

                        <?php $pos_atual = false; ?>

                        @foreach ($deploys as $d)
                            @if( $d->projeto->servidores->find($d->servidor->id)->pivot->tag_atual == $d->tag )
                                <?php $pos_atual = true; ?>
                                <tr class="bg-warning">
                                    <td width="100"><i class="fa fa-tag"></i> tag atual</td>
                            @else
                                @if($pos_atual)
                                <tr>
                                    <td width="100">
                                        <div class="btn-group">
                                            <a href="{{{ URL::to('deploy', array($d->id, 'rollback')) }}}" data-remote="" class="btn btn-danger btn-deletar-item" data-toggle="modal" data-target="#rollbackModal">
                                                <i class="fa fa-level-down"></i> Rollback
                                            </a>
                                        </div>
                                    </td>
                                @else
                                <tr>
                                    <td width="100">
                                        <a href="#" data-remote="" class="btn btn-danger disabled"><i class="fa fa-level-down"></i> Rollback</a>
                                    </td>
                                @endif
                            @endif
                            
                                <td>{{ $d->tag }}</td>
                                <td>{{ $d->servidor->nome }}</td>
                                <td>{{ $d->user->nome }}</td>
                                <td>{{ $d->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    {{ $deploys->links() }}
                </div>

                <div class="overlay hidden"></div>
                <div class="loading-img hidden"></div>
            </div><!-- /.box -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="rollbackModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteModalLabel"><i class="fa fa-warning"></i> Confirmar ação</h4>
                </div>
                <div class="modal-body">
                    <p>Ao realizar um rollback o servidor poderá ficar desatualizado.<br>
                        <small>Essa ação deve ser realizada com cuidado.</small></p>
                </div>
                <div class="modal-footer">
                    {{ Form::open(array('url' => '#')) }}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-danger">Realizar Rollback</button>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@stop

