@extends('layouts.master')

@section('content-header')
    <h1>Projetos</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">

            @if ( $message )
            <div class="alert alert-success alert-dismissable">
                <i class="fa fa-ban"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{{$message}}}
            </div>
            @endif

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Lista de projetos</h3>
                    <div class="box-tools">
                        <a href="{{{ URL::to('projeto/create') }}}" class="btn bg-navy pull-right">Adicionar novo</a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>Ações</th>
                            <th>Deploys</th>
                            <th>Nome</th>
                            <th>Repo</th>
                            <th>Data de Cadastro</th>
                        </tr>

                        @foreach ($projetos as $projeto)
                        <tr>
                            <td width="70">
                                <div class="btn-group">
                                    <a href="{{{ URL::to('projeto', array($projeto->id, 'edit')) }}}" class="btn btn-success btn-xs">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{{ URL::to('projeto', array($projeto->id)) }}}" data-remote="" class="btn btn-danger btn-xs btn-deletar-item" data-toggle="modal" data-target="#deleteModal">
                                        <i class="fa fa-ban"></i>
                                    </a>
                                </div>
                            </td>

                            <td width="120">
                                <a href="{{{ URL::to('projeto', array($projeto->id, 'deploys')) }}}" data-remote="" class="btn btn-info btn-xs">
                                    <i class="fa fa-cloud-upload"></i> Ver Deploys
                                </a>
                            </td>
                            
                            <td>{{ $projeto->nome }}</td>
                            <td>{{ $projeto->repo }}</td>
                            <td>{{ $projeto->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    {{ $projetos->links() }}
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
                    <h4 class="modal-title" id="deleteModalLabel"><i class="fa fa-warning"></i> Confirmar ação</h4>
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

