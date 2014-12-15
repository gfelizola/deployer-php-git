@extends('layouts.master')

@section('content-header')
    <h1>Editar Usuários</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            
            @if ( $errors->has() )
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p><b>Aviso!</b></p>
                @foreach( $errors->all('<p>:message</p>') as $message )
                    {{ $message }}
                @endforeach
            </div>
            @endif

            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{{ $usuario->username }}}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    {{ Form::open(array('url' => 'usuario/' . $usuario->id . '/update', 'class' => 'form-horizontal')) }}
                    
                    <div class="row">
                        <div class="col-xs-2">
                            @if( ! empty( $usuario->avatar ) )
                                <p><img src="{{ $usuario->avatar }}" width="120" height="120" class="img-circle" alt=""></p>
                            @else
                                <p><img src="/img/avatar5.png" width="120" height="120" class="img-circle" alt=""></p>
                            @endif
                        
                            <p><small>* a imagem de perfil deve ser atualizada no BitBucket</small></p>
                        </div>
                        <div class="col-xs-10">
                            <div class="form-group {{{ $errors->has('nome') ? 'has-error' : '' }}}">
                                {{ Form::label("nome", "Nome completo", array("class" => "col-xs-2")) }}
                                <div class="col-xs-10">{{ Form::text("nome", $usuario->nome, array( "class" => "form-control" )) }}</div>
                            </div>

                            <div class="form-group {{{ $errors->has('skin') ? 'has-error' : '' }}}">
                                {{ Form::label("skin", "Skin", array("class" => "col-xs-2") ) }}
                                <div class="col-xs-10">
                                    {{ Form::radio('skin', 'blue', $usuario->skin == User::SKIN_BLUE, array( "class" => "form-control" )) }} Azul<br>
                                    {{ Form::radio('skin', 'black', $usuario->skin == User::SKIN_BLACK, array( "class" => "form-control" )) }} Preto
                                </div>
                            </div>

                            <div class="form-group {{{ $errors->has('layout') ? 'has-error' : '' }}}">
                                {{ Form::label("layout", "Layout Fixo", array("class" => "col-xs-2") ) }}
                                <div class="col-xs-10">
                                    {{ Form::checkbox('layout', 'fixed', $usuario->layout == User::LAYOUT_FIXED) }}
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <div class="col-xs-10 col-xs-offset-2">{{ Form::submit('Salvar', array( "class" => "btn btn-primary" )); }}</div>
                            </div>
                        </div>
                    </div>
                    
                    {{ Form::close() }}
                </div>
            </div><!-- /.box -->
        </div>
    </div>
@stop