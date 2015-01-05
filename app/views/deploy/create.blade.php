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
            
            {{ Form::open( array('url' => 'deploy/' . $projeto->id .'/' . $servidor->id .'/realizar' )) }}
                <div class="box box-primary">
                    <div class="box-header">
                        <i class="fa fa-refresh"></i>
                        <h3 class="box-title">Aguarde enquanto atualizamos as informações do servidor</h3>
                    </div>
                    <div class="box-body">
                        <div class="panel panel-default">
                            <div class="panel-body bg-black">
                                <iframe name="console_frame" id="console_frame" src="{{{ URL::to('deploy/' . $projeto->id . '/' . $servidor->id .'/fetch') }}}" frameborder="0" width="100%" height="300" scrolling="no"></iframe>
                            </div>
                        </div>

                        <div class="form-group hidden {{{ $errors->has('tag') ? 'has-error' : '' }}}">
                            {{ Form::label("tag", "Escolha o rótulo de versão (tag)") }}

                            <div class="input-group">
                                <span class="input-group-addon bg-olive"><i class="fa fa-tags"></i></span>
                                {{ Form::select("tag", $tags, Input::old("tag"), array( "class" => "form-control input-lg" )) }}
                            </div>
                        </div>

                        <div class="form-group hidden {{{ $errors->has('descricao') ? 'has-error' : '' }}}">
                            {{ Form::label("descricao", "Descrição do Deploy") }}
                            {{ Form::textarea("descricao", Input::old("descricao"), array( "class" => "form-control" )) }}
                        </div>
                    </div>
                </div><!-- /.box -->
            {{ Form::close() }}
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cloneModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="cloneModalLabel"><i class="fa fa-warning"></i> Confirmar ação</h4>
                </div>
                <div class="modal-body">
                    <p>Este repositório ainda não existe na pasta indicada.</p>
                    <p><b>Deseja clonar este repositório?</b></p>
                    <p><span class="repositorio"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <a href="#" class="btn btn-danger" target="console_frame" data-dismiss="modal">Clonar repositório</a>
                </div>
            </div>
        </div>
    </div>
@stop