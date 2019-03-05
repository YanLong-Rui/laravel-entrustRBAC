<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-body form">
                <form class="form-horizontal" id="edit-form" action="{{url('permission/permission/edit')}}"
                      method="post">
                    <input type="hidden" id="id" name="id" value="{{$info->id}}"/>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">路由名称：</label>
                        <div class="col-md-7">
                            <input id="edit_name" name="name" minlength="2" type="text" class="form-control"
                                   required="" aria-required="true" value="{{$info->name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">权限名称：</label>
                        <div class="col-sm-7">
                            <input id="edit_display_name" name="display_name" minlength="2" type="text"
                                   class="form-control" required="" aria-required="true"
                                   value="{{$info->display_name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">选择上级权限：</label>
                        <div class="col-sm-7">
                            <select data-placeholder="选择上级操作" id="edit_parent_id" class="form-control m-b" tabindex="2"
                                    name='parent_id'>
                                <option value="0">--顶级--</option>
                                @foreach($selector as $v)
                                    <option value="{{ $v['id'] }}" {{$info->parent_id==$v['id']?"selected":""}}>{{ $v['display_name'] }}</option>
                                    @if (!empty($v['children']))
                                        @foreach($v['children'] as $i)
                                            <option value="{{ $i['id'] }}" {{$info->parent_id==$i['id']?"selected":""}}>
                                                |------{{ $i['display_name'] }}</option>
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-5 control-label">详细说明：</label>
                        <div class="col-sm-7">
                            <input id="edit_description" name="description" minlength="2" type="text"
                                   class="form-control" required="" aria-required="true" value="{{$info->description}}">
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="col-sm-6" style="text-align: right;">
                            <button type="submit" class="btn btn-info btn-sm btn-affirm"><i
                                        class="fa fa-save"></i> 确认
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-danger btn-sm btn-close"><i
                                        class="fa fa-close"></i> 关闭
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {

        $(".btn-close").on("click", function () {
            bootbox.hideAll();
        });

        var fromValidate = function () {
            var theForm = $('#edit-form');

            theForm.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                    name: {
                        required: true
                    },
                    display_name: {
                        required: true
                    },
                    description: {
                        required: true
                    }
                },

                messages: {
                    name: {
                        required: "请输入路由名称"
                    },
                    display_name: {
                        required: "请输入权限名称"
                    },
                    description: {
                        required: "请输入详细说明"
                    }
                },

                submitHandler: function (form) {
                    $(form).ajaxSubmit({
                        type: "post",
                        data: theForm.serialize(),
                        async: false,
                        success: function (ret) {
                            if (ret.code == 200) {
                                bootbox.alert(ret.msg, function () {
                                    bootbox.hideAll();
                                    LoadTree();
                                });
                            } else {
                                bootbox.alert(ret.msg);
                            }
                        }
                    });
                }
            });

        };

        fromValidate();
    });
</script>