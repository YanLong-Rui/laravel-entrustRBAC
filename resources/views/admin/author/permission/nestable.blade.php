<div class="dd" id="nestable2">
    <ol class="dd-list">
        @foreach($data as $value)
            <li class="dd-item" data-id="{{$value['id']}}">
                <div>
                    <span class="pull-right">
                        <button class="btn btn-info btn-edit" type="button" id="{{$value['id']}}">
                            <i class="fa fa-paste"></i>
                            编辑
                        </button>
                        <button class="btn btn-warning btn-del" type="button" id="{{$value['id']}}">
                            <i class="fa fa-minus-square"></i>
                            <span class="bold">删除</span>
                        </button>
                    </span>
                </div>
                <div class="dd-handle">
                                        <span class="label label-primary"><i
                                                    class="fa fa-navicon"></i></span> {{$value['display_name']}}
                </div>
                @if(!empty($value['children']))
                    <ol class="dd-list">
                        @foreach(@$value['children'] as $val)
                            <li class="dd-item" data-id="{{$val['id']}}">
                                <div>
                                    <span class="pull-right">
                                        <button class="btn btn-info btn-edit" type="button" id="{{$val['id']}}">
                                            <i class="fa fa-paste"></i>
                                            编辑
                                        </button>
                                        <button class="btn btn-warning btn-del" type="button"
                                                id="{{$val['id']}}">
                                            <i class="fa fa-minus-square"></i>
                                            <span class="bold">删除</span>
                                        </button>
                                    </span>
                                </div>
                                <div class="dd-handle">
                                                        <span class="label label-info"><i
                                                                    class="fa fa-map-signs"></i></span> {{$val['display_name']}}
                                </div>
                                @if(!empty($val['children']))
                                    <ol class="dd-list">
                                        @foreach($val['children'] as $v)
                                            <li class="dd-item" data-id="{{$v['id']}}">
                                                <div>
                                                        <span class="pull-right">
                                                            <button class="btn btn-info btn-edit" type="button"
                                                                    id="{{$v['id']}}">
                                                                <i class="fa fa-paste"></i>
                                                                编辑
                                                            </button>
                                                            <button class="btn btn-warning btn-del" type="button"
                                                                    id="{{$v['id']}}">
                                                                <i class="fa fa-minus-square"></i>
                                                                <span class="bold">删除</span>
                                                            </button>
                                                        </span>
                                                </div>
                                                <div class="dd-handle">
                                                                        <span class="label label-warning"><i
                                                                                    class="fa fa-gears"></i></span> {{$v['display_name']}}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ol>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                @endif
            </li>
        @endforeach
    </ol>
</div>
<!-- 全局js -->
@include('admin.js')
<!-- 自定义js -->
<script src="{{ URL::asset('js/nestable/content.js') }}"></script>
<!-- Nestable List -->
<script src="{{ URL::asset('js/nestable/jquery.nestable.js') }}"></script>
<script>
    $(document).ready(function () {

        // activate Nestable for list 2
        $('#nestable2').nestable({
            group: 1
        }).on('change', function (e) {

        });
        $('.dd').nestable('collapseAll');

        $('#nestable-menu').on('click', function (e) {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });

        //删除
        $('.btn-del').on('click', function () {
            var id = $(this).attr("id");
            bootbox.confirm("是否确认删除？", function (result) {
                if (result) {
                    $.ajax({
                        type: 'post',
                        url: '{{ url("permission/permission/delPerm") }}',
                        data: {'id': id},
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
                }
            });
        });

        $('.btn-edit').on('click', function () {
            var id = $(this).attr("id");
            $.ajax({
                type: "get",
                url: "{{url("permission/permission/edit")}}",
                data: {id: id},
                async: false,
                success: function (ret) {
                    if (ret.code == 200) {
                        bootbox.dialog({
                            message: ret.msg,
                            title: "编辑操作"
                        });
                    } else {
                        bootbox.alert(ret.msg);
                    }
                }
            })
        });

    });

</script>