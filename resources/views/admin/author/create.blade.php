<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link href="{{ URL::asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/skins/_all-skins.min.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ URL::asset('js/common/html5shiv.min.js')}}"></script>
    <script src="{{ URL::asset('js/common/respond.min.js')}}"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="{{ URL::asset('css/common/common.css') }}">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<!--顶部导航栏 start-->
@include('admin.header')
<!--顶部导航栏 end-->
@include('admin.menu')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                General Form Elements
                <small>Preview</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Forms</a></li>
                <li class="active">General Elements</li>
            </ol>
        </section>

        <!-- Main content -->
        <form class="form-horizontal m-t" id="commentForm" role="form" action="{{url('permission/roles/create')}}" method="POST">
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- Input addon -->
                    <div class="box box-info">
                        {{--<div class="box-header with-border">
                            <h3 class="box-title">Horizontal Form</h3>
                        </div>--}}
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal m-0"  id="commentForm" role="form" action="{{url('permission/roles/create')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">用户组</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputEmail3" placeholder="用户组" name="name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">名称</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputPassword3" placeholder="名称" name="display_name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">描述</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputPassword3" placeholder="描述" name="description">
                                    </div>
                                </div>
                                {{--<div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

                                    <div class="col-sm-10">
                                        <input type="checkbox" class="js-switch"  checked name="state"/>
                                    </div>
                                </div>--}}
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info pull-right">Sign in</button>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                    <!-- /.box -->

                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </section>
        </form>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@include('admin.footer')
</div>
<!-- ./wrapper -->

<!-- 全局js -->
@include('admin.js')
</body>
</html>
