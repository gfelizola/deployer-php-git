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
                {{{$message}}}
            </div>
            @endif

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Lista de deploys</h3>
                    <div class="box-tools">
                        <a href="{{{ URL::to('deploy', array($projeto->id, 'create')) }}}" class="btn bg-navy pull-right">Realizar deploy</a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>Ações</th>
                            <th>Projeto</th>
                            <th>Tag</th>
                            <th>Autor</th>
                            <th>Efetuado em</th>
                        </tr>

                        @foreach ($deploys as $d)
                        <tr>
                            <td width="70">
                                <div class="btn-group">
                                    <a href="{{{ URL::to('deploy', array($d->id, 'rollback')) }}}" data-remote="" class="btn btn-danger btn-xs btn-deletar-item" data-toggle="modal" data-target="#deleteModal">
                                        <i class="fa fa-level-down"></i> Rollback
                                    </a>
                                </div>
                            </td>
                            
                            <td>{{ $d->projeto->nome }}</td>
                            <td>{{ $d->tag }}</td>
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
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Confirmar ação</h4>
                </div>
                <div class="modal-body">
                    <p>Confirme que você deseja remover este item</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger">Remover item</button>
                </div>
            </div>
        </div>
    </div>
@stop

