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
                                <a href="{{{ URL::to('usuario', array($user->id, 'edit')) }}}" class="btn btn-success btn-xs">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="{{{ URL::to('usuario', array($user->id)) }}}" class="btn btn-danger btn-xs">
                                    <i class="fa fa-ban"></i>
                                </a>
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

                {{{ $usuarios->links() }}}
            </div><!-- /.box -->
        </div>
    </div>
@stop