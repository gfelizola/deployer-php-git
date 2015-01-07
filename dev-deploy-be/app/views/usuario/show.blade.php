@extends('layouts.master')

@section('content-header')
    <h1>Usuários
        <small>Perfil</small>
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">

            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{{ $usuario->nome }}}</h3>
                    
                    <div class="box-tools">
                        <a href="{{{ URL::to('usuario', array($usuario->id, 'edit' )) }}}" class="btn bg-navy pull-right">Editar</a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-2">
                            @if( ! empty( $usuario->avatar ) )
                                <p><img src="{{ $usuario->avatar }}" width="120" height="120" class="img-circle" alt=""></p>
                            @else
                                <p><img src="/img/avatar5.png" width="120" height="120" class="img-circle" alt=""></p>
                            @endif
                        </div>
                        <div class="col-xs-10">
                            <p><strong>Username:</strong> {{{ $usuario->username }}}</p>
                            <p><strong>Cadastro:</strong> {{{ $usuario->created_at->format('d/m/Y H:i') }}}</p>
                        </div>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
@stop