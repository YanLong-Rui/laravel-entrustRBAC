<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-body form">
                <form class="form-horizontal" id="edit-form" action="{{url('permission/users/'.$user->id.'/edit')}}"
                      method="post">
                    <input type="hidden" id="id" name="id" value="{{$user->id}}"/>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">用户名：</label>
                        <div class="col-sm-7">
                            <input id="name" name="name" type="text" class="form-control" value="{{$user->name}}">
                        </div>
                    </div>
                    {{--<div class="form-group">
                        <label class="col-sm-3 control-label">手机号：</label>
                        <div class="col-sm-7">
                            <input id="phone" name="phone" required type="text" class="form-control"
                                   value="{{$user->phone}}">
                        </div>
                    </div>--}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">E-mail：</label>
                        <div class="col-sm-7">
                            <input id="email" name="email" type="text" class="form-control" required=""
                                   aria-required="true"
                                   value="{{$user->email}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">密码：</label>
                        <div class="col-sm-7">
                            <input id="password" name="password" required type="password" class="form-control"
                                   value="{{$user->password}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">用户组：</label>
                        <div class="col-sm-7">
                            <select id="role_id" class="form-control m-b" name='role_id'>
                                <option value="">-请选择-</option>
                                @foreach($role as $v)
                                    <option value="{{$v->id}}" {{$user_role_id==$v->id?"selected":""}}>{{$v->display_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">是否启用：</label>
                        <div class="col-sm-7">
                            <div class="radio">
                                <label>
                                    <input type="radio" value="1" name="state" {{$user->state==1?"checked":""}}>
                                    正常
                                </label>
                                <label>
                                    <input type="radio" value="0" name="state" {{$user->state==0?"checked":""}}>
                                    冻结
                                </label>
                            </div>
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

            jQuery.validator.addMethod("verify_name", function (value, element) {

                var verify = $(element).attr("id");
                var user_id = $('#id').val();
                var flag = 1;
                $.ajax({
                    type: "POST",
                    url: "{{url('permission/user/isemailexist')}}",
                    async: false,
                    data: {data: value, verify: verify, user_id: user_id, type: "user-name-email"},
                    success: function (data) {
                        if (data == "false") {
                            flag = 0;
                        }
                    }
                });
                if (flag == 0) {
                    return false;
                } else {
                    return true;
                }
            }, "已存在");

            theForm.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                    name: {
                        required: true,
                        maxlength: 14,
                       // verify_name: true
                    },
                    phone: {
                        required: true,
                        isMobile: true
                    },
                    email: {
                        required: true,
                        email: true,
                        verify_name: true
                    },
                    password: {
                        required: true
                    },
                    role_id: {
                        required: true
                    }
                },

                messages: {
                    name: {
                        required: "请输入用户名",
                        maxlength: "用户名不能大于14个字符",
                        verify_name: "用户名已存在"

                    },
                    email: {
                        required: "请输入电子邮箱",
                        email: "邮箱格式不正确",
                        verify_name: "邮箱已存在"
                    },
                    password: {
                        required: "请输入密码"
                    },
                    role_id: {
                        required: "请选择用户组"
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
                                    $("#table_list_2").trigger("reloadGrid");
                                    bootbox.hideAll();
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