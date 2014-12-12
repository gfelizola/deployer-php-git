<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="active">
                <a href="{{{ URL::to('home') }}}">
                    <i class="fa fa-dashboard"></i> <span>Painel</span>
                </a>
            </li>
            <li class="treeview {{{ strstr(Route::currentRouteName(), 'projeto') ? 'active' : '' }}}">
                <a href="#">
                    <i class="fa fa-code"></i>
                    <span>Projetos</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{{ URL::to('projeto') }}}"><i class="fa fa-angle-double-right"></i> Ver todos</a></li>
                    <li><a href="{{{ URL::to('projeto/create') }}}"><i class="fa fa-angle-double-right"></i> Cadastrar novo</a></li>
                </ul>
            </li>
            <li class="treeview {{{ strstr(Route::currentRouteName(), 'deploy') ? 'active' : '' }}}">
                <a href="#">
                    <i class="fa fa-cloud-upload"></i>
                    <span>Deploys</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{{ URL::to('deploy') }}}"><i class="fa fa-angle-double-right"></i> Ver todos</a></li>
                    <li><a href="{{{ URL::to('deploy/create') }}}"><i class="fa fa-angle-double-right"></i> Realizar deploy</a></li>
                    <li><a href="{{{ URL::to('deploy/rollback') }}}"><i class="fa fa-angle-double-right"></i> Realizar rollback</a></li>
                </ul>
            </li>
            <li class="treeview {{{ strstr(Route::currentRouteName(),'usuario') ? 'active' : '' }}}">
                <a href="#">
                    <i class="fa fa-group"></i> <span>Usuários</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{{ URL::to('usuario') }}}"><i class="fa fa-angle-double-right"></i> Ver todos</a></li>
                    <li><a href="{{{ URL::to('usuario/create') }}}"><i class="fa fa-angle-double-right"></i> Adicionar novo</a></li>
                    <li><a href="{{{ URL::to('usuario/roles') }}}"><i class="fa fa-angle-double-right"></i> Gerenciar acessos</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>