<!-- Left side column. contains the logo and sidebar -->
<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        @if( Auth::check() )
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{{ Auth::user()->avatar }}}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{{ Auth::user()->nome }}}</p>

                <a href="#"><i class="fa fa-circle text-success"></i> {{{ Auth::user()->username }}}</a>
            </div>
        </div>
        
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="{{{ strstr(Route::currentRouteName(), 'home') ? 'active' : '' }}}">
                <a href="{{{ URL::route('home') }}}">
                    <i class="fa fa-dashboard"></i> <span>Painel</span>
                </a>
            </li>

            <li class="{{{ strstr(Route::currentRouteName(), 'tags') ? 'active' : '' }}}">
                <a href="{{{ URL::route('tags') }}}">
                    <i class="fa fa-tags"></i> <span>Criar tag</span>
                </a>
            </li>

            @if( Auth::user()->is_admin() )
            <li class="treeview {{{ strstr(Route::currentRouteName(), 'servidor') ? 'active' : '' }}}">
                <a href="#">
                    <i class="fa fa-desktop"></i>
                    <span>Servidores</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{{ URL::to('servidor') }}}"><i class="fa fa-angle-double-right"></i> Ver todos</a></li>
                    <li><a href="{{{ URL::to('servidor/create') }}}"><i class="fa fa-angle-double-right"></i> Cadastrar novo</a></li>
                </ul>
            </li>
            @endif
            <li class="treeview {{{ strstr(Route::currentRouteName(), 'projeto') ? 'active' : '' }}}">
                <a href="#">
                    <i class="fa fa-code"></i>
                    <span>Projetos</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{{ URL::to('projeto') }}}"><i class="fa fa-angle-double-right"></i> Ver todos</a></li>
                    @if( Auth::user()->is_admin() )
                        <li><a href="{{{ URL::to('projeto/create') }}}"><i class="fa fa-angle-double-right"></i> Cadastrar novo</a></li>
                    @endif
                </ul>
            </li>
            <li class="treeview {{{ strstr(Route::currentRouteName(),'usuario') ? 'active' : '' }}}">
                <a href="#">
                    <i class="fa fa-group"></i> <span>Usuários</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{{ URL::to('usuario') }}}"><i class="fa fa-angle-double-right"></i> Ver todos</a></li>
                    @if( Auth::user()->is_admin() )
                    <li><a href="{{{ URL::to('usuario/create') }}}"><i class="fa fa-angle-double-right"></i> Adicionar novo</a></li>
                    @endif
                </ul>
            </li>
        </ul>
        @else
        <ul class="sidebar-menu">
            <li class="{{{ strstr(Route::currentRouteName(), 'tags') ? 'active' : '' }}}">
                <a href="{{{ URL::route('tags') }}}">
                    <i class="fa fa-tags"></i> <span>Criar tag</span>
                </a>
            </li>
        </ul>
        @endif
    </section>
    <!-- /.sidebar -->
</aside>