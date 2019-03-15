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
    <link rel="stylesheet" href="{{ URL::asset('css/common/common.css') }}">
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
        <div class="box-header">
            <form class="form-inline" action="{{url('purchase/supplier')}}" method="get">
                <div class="form-group" id="datepicker">
                    <input type="text" class="form-control" name="start" id="qBeginTime" placeholder="选择起始日期">
                    <span class="">—</span>
                    <input type="text" class="form-control" name="end" id="qEndTime" placeholder="选择截止日期">
                </div>
                <div class="form-group">
                    <select name="type" id="type" class="form-control">
                        <option value="0">全部</option>
                        <option value="id">商家ID</option>
                        <option value="name">供应商名称</option>
                        <option value="manager">经营者</option>
                        <option value="mobile">联系电话</option>
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input id="keyword" name="keyword" type="text" class="form-control" placeholder="请输入关键字">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" id="search" type="button">搜索</button>
                </div>
                <div class="pull-right">
                    <a href="{{url('permission/roles/create')}}" class="btn btn-add btn-primary pull-right btn-create">添加用户组</a>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="jqGrid_wrapper">
                            <table id="table_list_2"></table>
                            <div id="pager_list_2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content -->

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
{{--<script src="{{ URL::asset('backadmin/js/bootstrap/shopManage.js') }}"></script>--}}
<script src="{{ URL::asset('js/nestable/content.js') }}"></script>

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function () {
        $.jgrid.defaults.styleUI = 'Bootstrap';
        // Examle data for jqGrid
        $("#table_list_2").jqGrid({
            url: '{{url('permission/roles')}}',
            mtype: "POST",
            datatype: "json",
            height: 600,
            autowidth: true,
            rowNum: 20,
            rowList: [10, 20, 30],
            jsonReader: {
                root: "rows",
                total: "total",
                page: "page",
                records: "records",
                repeatitems: false
            },
            colNames: ['ID', '用户组', '名称', '描述', '授权', '状态', '操作'],
            colModel: [
                {
                    name: 'id',
                    index: 'id',
                    editable: false,
                    width: 20,
                    sorttype: "int",
                    search: true
                },
                {
                    name: 'name',
                    index: 'name',
                    editable: true,
                    width: 40
                },
                {
                    name: 'display_name',
                    index: 'display_name',
                    editable: true,
                    width: 80
                },
                {
                    name: 'description',
                    index: 'description',
                    editable: true,
                    width: 80,

                },
                {
                    name: 'authorize',
                    index: 'authorize',
                    editable: false,
                    width: 80,

                },
                {
                    name: 'state',
                    index: 'state',
                    editable: false,
                    width: 40,

                },
                {
                    name: 'operations',
                    index: 'operations',
                    editable: false,
                    width: 90,

                },

            ],
            pager: "#pager_list_2",
            footerrow: true,
            userDataOnFooter: true,
            viewrecords: true,
            caption: "用户组列表"
        });

        // Setup buttons
        $("#table_list_2").jqGrid('navGrid', '#pager_list_2', {
            edit: false,
            add: false,
            del: false,
            search: true
        }, {
            height: 200,
            reloadAfterSubmit: true
        });
        // Add responsive to jqGrid
        $(window).bind('resize', function () {
            var width = $('.jqGrid_wrapper').width();
            $('#table_list_1').setGridWidth(width);
            $('#table_list_2').setGridWidth(width);
        });

        $('#table_list_2').on("click", ".btn-user-role", function () {
            var id = $(this).attr("data-id");
            $(location).attr('href', 'roles/rolelist/' + id);
        });

        $('#table_list_2').on("click", ".btn-authorize", function () {
            var id = $(this).attr("data-id");
            $.ajax({
                type: "get",
                url: "{{url("permission/roles/rolepermlist")}}",
                data: {role_id: id},
                async: false,
                success: function (ret) {
                    if (ret.code == 200) {
                        bootbox.dialog({
                            message: ret.msg,
                            title: ret.title
                        });
                    } else {
                        bootbox.alert(ret.msg);
                    }
                }
            })
        });

        $('#table_list_2').on("click", ".btn-edit-state", function () {
            var id = $(this).attr("data-id");
            var state = $(this).attr("data-state");
            $.post('roles/updateState', {'id': id, 'state': state}, function (data) {
                if (data.state == 1) {
                    $("#table_list_2").trigger("reloadGrid");
                } else {
                    alert("修改失败");
                }
            });
        });

        $('#table_list_2').on("click", ".btn-del", function () {
            var id = $(this).attr("data-id");
            bootbox.confirm("是否删除？", function (result) {
                if (result) {
                    $.post('roles/delRole', {'id': id}, function (data) {
                        if (data.state == 1) {
                            $("#table_list_2").trigger("reloadGrid");
                        } else {
                            alert("删除失败");
                        }
                    });
                }
            });
        });

    });

</script>
</body>
</html>
