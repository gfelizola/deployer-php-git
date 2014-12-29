@extends('layouts.master')

@section('content-header')
    <h1>Projeto</h1>
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
            
            {{ Form::open( array('url' => 'deploy/' . $projeto->id .'/realizar' )) }}
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="panel panel-default">
                            <div class="panel-header">Atualizando infos do repositório</div>
                            <div class="panel-body bg-black">
                                <iframe src="{{{ URL::to('deploy/' . $projeto->id .'/fetch') }}}" frameborder="0" width="100%" height="300" scrolling="no"></iframe>
                            </div>
                        </div>

                        <div class="form-group {{{ $errors->has('nome') ? 'has-error' : '' }}}">
                            {{ Form::label("Tag", "Escolha o rótulo de versão (tag)") }}

                            <div class="input-group">
                                <span class="input-group-addon bg-olive"><i class="fa fa-tags"></i></span>
                                {{ Form::select("tag", $tags, Input::old("tag"), array( "class" => "form-control input-lg" )) }}
                            </div>
                        </div>

                        <div class="form-group {{{ $errors->has('nome') ? 'has-error' : '' }}}">
                            {{ Form::label("descricao", "Descrição do Deploy") }}
                            {{ Form::textarea("descricao", Input::old("descricao"), array( "class" => "form-control" )) }}
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="form-group">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fa fa-cloud-upload"></i> Carregar versão
                            </button>
                        </div>
                    </div>
                </div><!-- /.box -->
            {{ Form::close() }}
        </div>
    </div>
@stop