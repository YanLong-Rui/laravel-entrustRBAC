<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AdminLTE 2 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link href="{{ URL::asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/Ionicons/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{URL::asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ URL::asset('bower_components/jvectormap/jquery-jvectormap.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ URL::asset('dist/css/skins/_all-skins.min.css') }}">

    <!---picker---->
    <link href="{{asset('backadmin/css/bootstrap/datepicker3.css')}}" rel="stylesheet">
    <!------jGride------>
    <link href="{{ URL::asset('backadmin/css/jqgrid/ui.jqgrid.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('backadmin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('backadmin/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('backadmin/css/commen.css')}}" rel="stylesheet">
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

<!--顶部导航栏 start-->
@include('admin.header')
<!--顶部导航栏 end-->
@include('admin.menu')
<div class="wrapper">


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Data Tables
                <small>advanced tables</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Tables</a></li>
                <li class="active">Data tables</li>
            </ol>
        </section>

        {{--<div class="box-footer">
            <button type="submit" class="btn btn-info pull-right">添加用户</button>
        </div>--}}
            <div class="row">
                <div class="col-sm-6">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="nestable-menu">
                                        <button type="button" data-action="expand-all" class="btn btn-white btn-sm">展开所有
                                        </button>
                                        <button type="button" data-action="collapse-all" class="btn btn-white btn-sm">收起所有
                                        </button>
                                        <span class="pull-right">
                                    <button class="btn btn-primary btn-sm btn-sort" type="button">
                                        <i class="fa fa-sort-amount-asc"></i>
                                        保存排序
                                    </button>
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content" id="nestable-content">

                        </div>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>添加管理</h5>
                        </div>
                        <div class="ibox-content">

                            <div class="dd" id="nestable">
                                <div class="ibox-content">
                                    <form class="form-horizontal m-t" id="myForm" role="form">
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">路由名称：</label>
                                            <div class="col-sm-7">
                                                <input id="add_name" name="name" minlength="2" type="text" class="form-control"
                                                       required="" aria-required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">权限名称：</label>
                                            <div class="col-sm-7">
                                                <input id="add_display_name" name="display_name" minlength="2" type="text"
                                                       class="form-control" required="" aria-required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">选择上级权限：</label>
                                            <div class="col-sm-7">

                                                <select data-placeholder="选择上级操作" id="add_parent" class="form-control m-b"
                                                        style="width:350px;"
                                                        tabindex="2" name='parent'>
                                                    <option value="0">--顶级--</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-5 control-label">详细说明：</label>
                                            <div class="col-sm-7">
                                                <input id="add_description" name="description" minlength="2" type="text"
                                                       class="form-control" required="" aria-required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-4 col-sm-offset-3">
                                                <button class="btn btn-primary" type="button" id="but">添加</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

    </div>
    <!-- /.content-wrapper -->
    @include('admin.footer')
</div>
<!-- ./wrapper -->

<!-- 全局js -->
@include('admin.js')
<script src="{{ URL::asset('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{ URL::asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>

<!-- jqGrid -->
<script src="{{ URL::asset('backadmin/js/jqgrid/i18n/grid.locale-cn.js') }}"></script>
<script src="{{ URL::asset('backadmin/js/jqgrid/jquery.jqGrid.min.js') }}"></script>
<script src="{{ URL::asset('backadmin/js/bootstrap/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('backadmin/js/bootstrap/shopManage.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function () {
        LoadTree();

        //保存排序
        $('.btn-sort').on("click", function () {
            var data = $('#nestable2').nestable('serialize');
            $.ajax({
                type: 'post',
                url: '{{ url("admin/permission/sort") }}',
                data: {data: data},
                async: false,
                success: function (data) {
                    if (data.code) {
                        bootbox.alert(data.msg);
                    }
                }
            });
        });

        //提交保存
        $("#but").on('click', function () {
            $.ajax({
                type: 'post',
                url: '{{ url("permission/permission/store") }}',
                data: $("#myForm").serialize(),
                async: false,
                success: function (data) {
                    if (data.code == 200) {
                        bootbox.alert(data.msg, function () {
                            LoadTree();
                        });
                    } else {
                        bootbox.alert(data.msg);
                    }
                }
            });
        });
    });

    //获取已有的操作列表
    function LoadTree() {
        $.ajax({
            type: 'post',
            url: '{{ url("permission/permission") }}',
            data: {},
            async: false,
            success: function (data) {
                if (data.code == 200) {
                    $('#nestable-content').html(data.msg);
                    $('#myForm').resetForm();
                    LoadSelector();
                } else {
                    bootbox.alert(data.msg);
                }
            }
        });
    }

    //上级权限下拉列表
    function LoadSelector() {
        $('#add_parent').empty();
        $('#add_parent').append("<option value=\"0\">--顶级--</option>");
        $.ajax({
            type: 'post',
            url: '{{ url("permission/permission") }}',
            data: {selector: 1},
            async: false,
            success: function (data) {
                if (data.code == 200) {
                    $.each(data.msg, function (i, v) {
                        $('#add_parent').append("<option value='" + v.id + "'>" + v.display_name + "</option>");
                        if (v.children) {
                            $.each(v.children, function (i, v) {
                                $('#add_parent').append("<option value='" + v.id + "'>|------" + v.display_name + "</option>");
                            });
                        }
                    });
                } else {
                    bootbox.alert(data.msg);
                }
            }
        });
    }
</script>
</body>
</html>
