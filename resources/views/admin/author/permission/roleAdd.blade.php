<style type="text/css">
    .datepicker{z-index: 99999 !important}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-body form">
                <form class="form-horizontal" method="post">
                    <div class="col-md-2">
                        <select name="status" id="state" class="form-control">
                            <option value="">状态</option>
                            <option value="0">冻结</option>
                            <option value="1">正常</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group col-sm-5 pull-left">
                                <input type="text" class="form-control" name="start" id="qBeginTime"
                                       placeholder="最后登录开始时间">
                            </div>
                            <span class="col-sm-2 pull-left">—</span>
                            <div class="input-group col-sm-5 pull-left">
                                <input type="text" class="form-control" name="end" id="qEndTime"
                                       placeholder="最后登录截止时间">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input id="keyword" name="keyword" type="text" class="form-control"
                                   placeholder="请输入关键字">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <button class="btn btn-primary" id="search" type="button">搜索</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="ibox-content">
    <div class="panel-body">
        <div class="panel-group" id="accordion">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h5 class="panel-title">
                        <span class="label label-info">已选择用户</span>
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">点击姓名可移除</a>
                    </h5>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">
                        <p>
                            @if($role_user)
                                @foreach($role_user as $v)
                                    <button class="btn btn-w-m btn-link btn-sel-user" data-id="{{$v->user_id}}"
                                            type="button"><i class="fa fa-close"></i>&nbsp;{{$v->name}}</button>
                                @endforeach
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content  animated fadeInRight">
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
    <div class="form-actions">
        <div class="col-sm-6" style="text-align: right;">
            <button type="button" class="btn btn-info btn-sm btn-affirm"><i
                        class="fa fa-save"></i> 确认
            </button>
        </div>
        <div class="col-sm-6">
            <button type="button" class="btn btn-danger btn-sm btn-close"><i
                        class="fa fa-close"></i> 关闭
            </button>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {

        $('#qBeginTime').datepicker({
            todayBtn : "linked",
            autoclose : true,
            todayHighlight : true,
            endDate : new Date()
        }).on('changeDate',function(e){
            var startTime = e.date;
            $('#qEndTime').datepicker('setStartDate',startTime);
        });

        $('#qEndTime').datepicker({
            todayBtn : "linked",
            autoclose : true,
            todayHighlight : true,
            endDate : new Date()
        }).on('changeDate',function(e){
            var endTime = e.date;
            $('#qBeginTime').datepicker('setEndDate',endTime);
        });

        $(".btn-close").on("click", function () {
            bootbox.hideAll();
        });

        $.jgrid.defaults.styleUI = 'Bootstrap';

        $("#table_list_2").jqGrid({
            url: '{{url('permission/roles/userroleadd')}}',
            postData: {type: 'user', rid: '{{$rid}}'},
            mtype: "POST",
            datatype: "json",
            height: 750,
            width: 1200,
            //autowidth: true,
            rowNum: 20,
            rowList: [10, 20, 30],
            jsonReader: {
                root: "rows",
                total: "total",
                page: "page",
                records: "records",
                repeatitems: false
            },
            colNames: ['', 'ID', '昵称', '手机号', '最后登录时间', '最后登录IP', '状态'],
            colModel: [
                {
                    name: 'checkbox',
                    index: 'checkbox',
                    width: 20
                },
                {
                    name: 'id',
                    index: 'id',
                    width: 100
                },
                {
                    name: 'name',
                    index: 'name',
                    width: 120
                },
                {
                    name: 'phone',
                    index: 'phone',
                    width: 120
                },
                {
                    name: 'logon_at',
                    index: 'logon_at',
                    width: 150
                },
                {
                    name: 'logon_ip',
                    index: 'logon_ip',
                    width: 120
                },
                {
                    name: 'state',
                    index: 'state',
                    width: 100
                }
            ],
            pager: "#pager_list_2",
            viewrecords: true,
            gridComplete: function () {
                //重新发数据，记住选中的信息
                var state = $("#state").val();
                var qBeginTime = $("#qBeginTime").val();
                var qEndTime = $("#qEndTime").val();
                var keyword = $("#keyword").val();
                var user = [];
                $(".btn-sel-user").each(function () {
                    var id = $(this).attr("data-id");
                    user.push(id);
                });

                $(this).jqGrid('setGridParam', {
                    mtype: "POST",
                    url: "{{url('permission/roles/userroleadd')}}",
                    postData: {
                        type: 'user',
                        rid: '{{$rid}}',
                        user: user,
                        state: state,
                        start_time: qBeginTime,
                        end_time: qEndTime,
                        keyword: keyword
                    }
                });
            }
        });

        // Setup buttons
        $("#table_list_2").jqGrid('navGrid', '#pager_list_2', {
            edit: false,
            add: false,
            del: false,
            search: false
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

        $('#table_list_2').on("click", "input[name='selUser']", function () {
            var user_id = $(this).val();
            //<button class="btn btn-w-m btn-link btn-sel-user" type="button"><i class="fa fa-close"></i>&nbsp;提交</button>
            var name = $(this).attr('user-name');

            if ($(this).is(':checked')) {
                var button = '<button class="btn btn-w-m btn-link btn-sel-user" data-id="' + user_id + '" type="button"><i class="fa fa-close"></i>&nbsp;' + name + '</button>';
                $('#collapseOne').find("p").append(button);
            } else {
                $(".btn-sel-user").each(function () {
                    var id = $(this).attr("data-id");
                    if (id == user_id) {
                        $(this).remove();
                    }
                });
            }
        });

        //移除
        $('.btn-sel-user').on("click", function () {
            var obj = $(this);
            if (confirm("是否确认移除？")) {
                var id = obj.attr("data-id");
                $("input[name='selUser']").each(function () {
                    var value = $(this).val();
                    if (id == value) {
                        $(this).prop("checked", false);
                    }
                });
                obj.remove();
            }
        });

        //搜索
        $('#search').on("click", function () {
            var state = $("#state").val();
            var qBeginTime = $("#qBeginTime").val();
            var qEndTime = $("#qEndTime").val();
            var keyword = $("#keyword").val();
            var user = [];
            $(".btn-sel-user").each(function () {
                var id = $(this).attr("data-id");
                user.push(id);
            });
            $("#table_list_2").jqGrid('setGridParam', {
                mtype: "POST",
                url: "{{url('permission/roles/userroleadd')}}",
                postData: {
                    type: 'user',
                    rid: '{{$rid}}',
                    user: user,
                    state: state,
                    start_time: qBeginTime,
                    end_time: qEndTime,
                    keyword: keyword
                }, //发送数据
                page: 1
            }).trigger("reloadGrid"); //重新载入
        });

        $('.btn-affirm').on("click", function () {
            var user = [];
            $(".btn-sel-user").each(function () {
                var id = $(this).attr("data-id");
                user.push(id);
            });
            $.ajax({
                type: "post",
                url: "{{url('permission/roles/userroleadd')}}",
                data: {type: "add", rid: '{{$rid}}', data: user},
                async: false,
                success: function (data) {
                    if (data.code == 200) {
                        bootbox.alert(data.msg, function () {
                            window.location.reload();
                        });
                    } else {
                        bootbox.alert(data.msg);
                    }
                }
            })
        });
    });
</script>