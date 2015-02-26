<!DOCTYPE html>
<html>
    @include('layouts.head')

    @if( Auth::check() )
            <body class="skin-{{ Auth::user()->skin }} {{ Auth::user()->layout }}">
    @else
            <body class="skin-blue">
    @endif
        @include('layouts.header')
        <div class="wrapper row-offcanvas row-offcanvas-left">
            @include('layouts.sidebar')

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    @section('content-header')
                        
                    @show
                </section>

                <!-- Main content -->
                <section class="content">
                    @section('content')
                        
                    @show
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

    @include('layouts.footer')

    </body>
</html>
