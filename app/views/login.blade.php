<!DOCTYPE html>
<html class="bg-black">
    @include('layouts.head')
    <body class="bg-black">

        <div class="form-box" id="login-box">
            @if (isset($mensagem) )
            <div class="alert alert-danger alert-dismissable">
                <i class="fa fa-ban"></i>
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <b>Aviso!</b><br>
                {{{$mensagem}}}
            </div>
            @endif
            <form action="{{{ URL::to('login/bitbucket') }}}" method="get">
                <div class="header">Login</div>
                
                <div class="body bg-gray">
                    <button type="submit" class="btn bg-orange btn-lg btn-block btn-bitbucket">
                        <i class="fa fa-bitbucket"></i>
                        Realizar login com BitBucket
                    </button>
                </div>
                <div class="footer">
                    <p>Para realizar o login é necessário possuir uma conta no <strong>BitBucket</strong>.</p>
                    <p>Caso ainda não seja cadastrado, clique <a href="https://bitbucket.org/" target="_blank" title="Cadastrar">aqui</a>.<br>
                        <em><small>* Será necessário informar um desenvolvedor do sistema para adicionar seu acesso.</small></em>
                    </p>
                </div>
            </form>
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>

    </body>
</html>