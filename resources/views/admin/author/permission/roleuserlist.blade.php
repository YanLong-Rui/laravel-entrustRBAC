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
    <link href="{{asset('backadmin/commen.css')}}" rel="stylesheet">
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
        <div class="box-header">
                <div class="form-group">
                    <button class="btn btn-primary btn-auth" type="button">批量授权</button>
            </form>
        </div>
        <div class="form-group">
            <table id="table_list_1" tabindex="0" role="presentation" aria-multiselectable="false"
                   aria-labelledby="gbox_table_list_1"
                   class="ui-jqgrid-btable ui-common-table table table-bordered" style="width: 1585px;">
                <thead>
                <tr class="ui-jqgrid-labels" role="row">
                    <th id="table_list_1_id" class="ui-th-column ui-th-ltr" role="columnheader"
                        style="width: 149px;">
                        <div id="jqgh_table_list_1_id" class="ui-jqgrid-sortable">
                            ID
                        </div>
                    </th>
                    <th id="table_list_1_id" class="ui-th-column ui-th-ltr" role="columnheader"
                        style="width: 149px;">
                        <div id="jqgh_table_list_1_id" class="ui-jqgrid-sortable">
                            用户名
                        </div>
                    </th>
                    <th id="table_list_1_id" class="ui-th-column ui-th-ltr" role="columnheader"
                        style="width: 149px;">
                        <div id="jqgh_table_list_1_id" class="ui-jqgrid-sortable">
                            E-mail
                        </div>
                    </th>
                    <th id="table_list_1_id" class="ui-th-column ui-th-ltr" role="columnheader"
                        style="width: 149px;">
                        <div id="jqgh_table_list_1_id" class="ui-jqgrid-sortable">
                            创建时间
                        </div>
                    </th>
                    <th id="table_list_1_id" class="ui-th-column ui-th-ltr" role="columnheader"
                        style="width: 149px;">
                        <div id="jqgh_table_list_1_id" class="ui-jqgrid-sortable">
                            修改时间
                        </div>
                    </th>
                    <th id="table_list_1_id" class="ui-th-column ui-th-ltr" role="columnheader"
                        style="width: 149px;">
                        <div id="jqgh_table_list_1_id" class="ui-jqgrid-sortable">
                            操作
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($data as $v)
                    <tr role="row" id="1" tabindex="-1" class="jqgrow ui-row-ltr">
                        <td role="gridcell" aria-describedby="table_list_1_id">
                            {{ $v->Users->id }}
                        </td>
                        <td role="gridcell" aria-describedby="table_list_1_invdate">
                            {{ $v->Users->name }}
                        </td>
                        <td role="gridcell" aria-describedby="table_list_1_invdate">
                            {{ $v->Users->email }}
                        </td>
                        <td role="gridcell" aria-describedby="table_list_1_invdate">
                            {{ $v->Users->created_at }}
                        </td>
                        <td role="gridcell" aria-describedby="table_list_1_invdate">
                            {{ $v->Users->updated_at }}
                        </td>
                        <td role="gridcell" aria-describedby="table_list_1_total">
                            <button class="btn btn-danger btn-del" data-id="{{ $v->Users->id }}" type="button"><i
                                        class="fa fa-close"></i>&nbsp;解除授权
                            </button>
                        </td>
                    </tr>
                @endforeach
                <tbody>
            </table>
        </div>
    </div>

</div>    <!-- /.content-wrapper -->
@include('admin.footer')
<!-- ./wrapper -->

<!-- 全局js -->
@include('admin.js')

<!-- Peity -->
<script src="{{ URL::asset('/backadmin/js/peity/jquery.peity.min.js')}}"></script>

<!-- jqGrid -->
<script src="{{ URL::asset('backadmin/js/jqgrid/i18n/grid.locale-cn.js') }}"></script>
<script src="{{ URL::asset('backadmin/js/jqgrid/jquery.jqGrid.min.js') }}"></script>

<script src="{{ URL::asset('backadmin/js/bootstrap/bootstrap-datepicker.js') }}"></script>

<!-- 自定义js -->
<script src="{{ URL::asset('js/nestable/content.js') }}"></script>
<script>
    $(function () {
        $('.btn-auth').on("click", function () {
            $.ajax({
                type: "get",
                url: "{{url("permission/roles/userroleadd" )}}",
                data: {rid: '{{ $rid }}'},
                async: false,
                success: function (ret) {
                    if (ret.code == 200) {
                        bootbox.dialog({
                            message: ret.msg,
                            title: "添加用户"
                        });
                    } else {
                        bootbox.alert(ret.msg);
                    }
                }
            })
        });

        $('.btn-del').on("click", function () {
            var uid = $(this).attr("data-id");
            $.post('{{ url("permission/roles/userroledel") }}', {
                'uid': uid,
                'rid': "{{ $rid }}"
            }, function (data) {
                if (data.code == 200) {
                    bootbox.alert(data.msg, function () {
                        window.location.reload();
                    });
                } else {
                    bootbox.alert(data.msg);
                }
            });
        });
    });
</script>
</body>
</html>
