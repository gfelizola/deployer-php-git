<!DOCTYPE html>
<html>
    @include('head')

    <body class="skin-blue">
        @include('header')
        <div class="wrapper row-offcanvas row-offcanvas-left">
            @include('sidebar')

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

    @include('footer')        

    </body>
</html>
