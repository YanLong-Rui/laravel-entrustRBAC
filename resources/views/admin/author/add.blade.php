<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-body form">
                <form class="form-horizontal this_form" style="padding-left:0px"
                      action="{{$url}}"
                      method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">姓名：</label>
                        <div class="col-sm-9">
                            <input id="name" name="name" maxlength="20" type="text" class="form-control"
                                   data-rule-required="true" data-msg="请输入用户名称" placeholder="请输入用户名称" value="{{@$name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email：</label>
                        <div class="col-sm-9">
                            <input id="legal" name="email" value="{{@$legal}}" maxlength="30" data-rule-isEmail="30" data-msg-maxlength="" type="text" class="form-control" aria-required="true" placeholder="请输入用户email" data-rule-required="true" data-msg="请输入用户email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">密码：</label>
                        <div class="col-sm-9">
                            <input id="password" name="password" value="" maxlength="30" data-rule-isEmail="30" data-msg-maxlength="" type="password" class="form-control" aria-required="true" placeholder="请输入密码" data-rule-required="true" data-msg="请输入密码">
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
    function initArea_add(id=0){
        $.post("{{url('common/area')}}",{'id':0},function(data){
            var data = data.msg;
            $('#province-add').html('<option value="0">省份选择</option>');
            $('#city').html('<option value="0">城市选择</option>');
            $.each(data,function(no,items){
                if(items.areaname!='中国'){
                    $('#province-add').append('<option value="'+items.id+'">'+items.areaname+'</option>');
                }
            });
            if("{{@$province_id??'false'}}}"){
                $('#province-add').find("option[value='{{ @$province_id }}']").attr("selected",true);
                loadArea_add("{{ @$province_id }}",'city-add');
                loadArea_add("{{ @$city_id }}",'area-add');
            }

        });
    }
    function loadArea_add(areaId,areaType) {
        $.post("{{url('common/area')}}",{'id':areaId},function(data){
            var data = data.msg;
            if(areaType=='city-add'){
                $('#'+areaType).html('<option value="0">城市选择</option>');
                $('#area-add').html('<option value="0">区域选择</option>');

            }
            if(areaType=='area-add'){
                if("{{$area_id??'false'}}}"){
                    $('#area-add').find("option[value='{{ @$area_id }}']").attr("selected",true);
                }
                $('#area-add').html('<option value="0">区域选择</option>');
            }
            if(areaId>0){
                $.each(data,function(no,items){
                    $('#'+areaType).append('<option value="'+items.id+'">'+items.areaname+'</option>');
                });
            }
            if(areaType=='city-add' && "{{@$city_id??'false'}}}"){
                $('#city-add').find("option[value='{{ @$city_id }}']").attr("selected",true);
            }
            if(areaType=='area-add' && "{{$area_id??'false'}}}"){
                $('#area-add').find("option[value='{{ @$area_id }}']").attr("selected",true);
            }
        });
    }
    initArea_add($('#province-add').val());
    $(function () {
        jQuery.validator.addMethod("isSelect", function(value, element) {
            return value!="" &&value!=0;
        }, "必填项");
        jQuery.validator.addMethod("isMobile", function (value, element) {
            var res = /^0\d{2,3}-?\d{7,8}$/.test(value) || /^(((13[0-9]{1})|(15[0-9]{1})|(17[0-9]{1})|(18[0-9]{1}))+\d{8})$/.test(value);
            return this.optional(element) || res;
        }, "必填项");
        var fromValidate = function () {
            var theForm = $('.this_form');

            theForm.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                   //  name: {
                  //       required: true,
                  //       maxlength: 20
                  //   },
                  //   email: {
                  //       required: true,
                  //       maxlength: 100
                  //   }
                },

                messages: {
                     //name: {
                    //     required: "请输入用户名称"
                    // },
                   //  email: {
                   //      required: "请输入Email地址"
                  //   }
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
                                    window.location.reload();
                                });
                            } else {
                                bootbox.alert(ret.msg);
                            }
                        }
                    });
                    return false;
                }
            });

        };

        fromValidate();

        $(".btn-close").on("click", function () {
            bootbox.hideAll();
        });
    });
</script>