@extends('layouts.master')

@section('content-header')
    <h1>Usuários</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">

            @if (isset($message) )
            <div class="alert alert-success alert-dismissable">
                <i class="fa fa-ban"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {{{$message}}}
            </div>
            @endif

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Lista de usuários</h3>
                    <div class="box-tools">
                        <a href="{{{ URL::to('usuario/create') }}}" class="btn bg-navy pull-right">Adicionar novo</a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>Ações</th>
                            <th>&nbsp</th>
                            <th>Nome</th>
                            <th>Cadastro</th>
                        </tr>

                        @foreach ($usuarios as $user)
                        <tr>
                            <td width="70">
                                <div class="btn-group">
                                    <a href="{{{ URL::to('usuario', array($user->id, 'edit')) }}}" class="btn btn-success btn-xs">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @if( $user->id != Auth::id() )
                                    <a href="{{{ URL::to('usuario', array($user->id)) }}}" data-remote="" class="btn btn-danger btn-xs btn-deletar-item" data-toggle="modal" data-target="#deleteModal">
                                        <i class="fa fa-ban"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                            <td width="50">
                                @if( ! empty( $user->avatar ) )
                                    <img src="{{ $user->avatar }}" width="30" height="30" class="img-circle" alt="">
                                @else
                                    <img src="/img/avatar5.png" width="30" height="30" class="img-circle" alt="">
                                @endif
                            </td>
                            <td>{{ isset( $user->nome ) ? $user->nome : $user->username }}</td>
                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div><!-- /.box-body -->

                <div class="box-footer">
                    {{ $usuarios->links() }}
                </div>

                <div class="overlay hidden"></div>
                <div class="loading-img hidden"></div>
            </div><!-- /.box -->
            </div><!-- /.box -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalLabel">
                        <i class="fa fa-warning"></i> Confirmar ação
                    </h4>
                </div>
                <div class="modal-body">
                    <p>Confirma que você deseja remover este usuário?</p>
                    <p><i><small>* esta ação irá somente remover o acesso dele ao sistema</small></i></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-danger">Remover item</button>
                </div>
            </div>
        </div>
    </div>
@stop