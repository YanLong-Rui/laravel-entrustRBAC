<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-body form">
                <form class="form-horizontal" id="reject-form" action="{{url('permission/roles/rolepermlist')}}"
                      method="post">
                    <input class="auth_rules" type="hidden" value="{{ $role_id }}" name='role_id'/>
                    <div class="form-body">
                        <div class="col-sm-4" style="text-align: right;">
                            <label class="mt-checkbox mt-checkbox-outline">
                                <input type="checkbox" class="btn-selAll">全选
                                <span></span>
                            </label>
                        </div>
                        <div class="col-sm-4" style="text-align: right;">
                            <button type="button" class="btn btn-info btn-sm btn-affirm"><i
                                        class="fa fa-save"></i> 确认
                            </button>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-danger btn-sm btn-close"><i
                                        class="fa fa-close"></i> 关闭
                            </button>
                        </div>
                    </div>

                    <div class="form-body">
                        @foreach($getData as $i)
                            <div class="acc_top_div mt-checkbox-inline">
                                <h3 class="form-section">
                                    <label class="mt-checkbox mt-checkbox-outline">
                                        <input type="checkbox" class="acc_top_all" name="rules[]" value="{{ $i['id'] }}"
                                               parent="0" @if(in_array($i['id'],$perm)) checked
                                               @endif autocomplete="OFF">
                                        <span></span>
                                    </label>
                                    {{ $i['display_name'] }}
                                </h3>

                                @if (!empty($i['children']))
                                    @foreach ($i['children'] as $j)
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">{{ $j['display_name'] }}：</label>
                                            <div class="col-md-8">
                                                <div class="mt-checkbox-inline acc_sec_list">
                                                    <div class="mt-checkbox-inline">
                                                        <label class="mt-checkbox mt-checkbox-outline">
                                                            <input type="checkbox" class="acc_sec_all" name="rules[]"
                                                                   parent="{{ $j['parent_id'] }}" value="{{ $j['id'] }}"
                                                                   @if(in_array($j['id'],$perm)) checked
                                                                   @endif autocomplete="OFF"><b>{{ $j['display_name'] }}</b>
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    @if (!empty($j['children']))
                                                        @foreach ($j['children'] as $l)
                                                            <label class="mt-checkbox">
                                                                <input type="checkbox" class="acc_sec"
                                                                       @if(in_array($l['id'],$perm)) checked
                                                                       @endif name="rules[]"
                                                                       value="{{ $l['id'] }}"
                                                                       parent="{{ $l['parent_id'] }}"> {{ $l['display_name'] }}
                                                                <span></span>
                                                            </label>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hr-line-dashed"></div>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="form-body">
                        <div class="col-sm-4" style="text-align: right;">
                            <label class="mt-checkbox mt-checkbox-outline">
                                <input type="checkbox" class="btn-selAll">全选
                                <span></span>
                            </label>
                        </div>
                        <div class="col-sm-4" style="text-align: right;">
                            <button type="button" class="btn btn-info btn-sm btn-affirm"><i
                                        class="fa fa-save"></i> 确认
                            </button>
                        </div>
                        <div class="col-sm-4">
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
<script>
    $(document).ready(function () {

        $(".btn-close").on("click", function () {
            bootbox.hideAll();
        });

        //全选
        $(".btn-selAll").on("click", function () {
            $("[type='checkbox']", $('#reject-form')).prop("checked", this.checked);
        });

        //本类全选
        $(".acc_top_all").on("click", function () {
            $(this).parents(".acc_top_div").find(":checkbox").prop("checked", this.checked);
        });

        $(".acc_sec_all").on("click", function () {
            var parent = $(this).attr("parent");
            //$(this).parents(".acc_sec_list").find(":checkbox").prop("checked", this.checked);

            var flag = false;
            if ($(this).is(":checked")) {
                flag = true;
            } else {
                $(".acc_sec_all").each(function () {
                    var this_parent = $(this).attr("parent");
                    if ($(this).is(":checked") && this_parent == parent) {
                        flag = true;
                        return false;
                    }
                });

                $(this).parents(".acc_sec_list").find(":checkbox").prop("checked", this.checked);
            }

            $(this).parents(".acc_top_div").find(".acc_top_all").prop("checked", flag);
        });

        $(".acc_sec").on("click", function () {
            var parent = $(this).attr("parent");

            var flag = false;
            if ($(this).is(":checked")) {
                flag = true;
            } else {
                $(".acc_sec").each(function () {
                    var this_parent = $(this).attr("parent");
                    if ($(this).is(":checked") && this_parent == parent) {
                        flag = true;
                        return false;
                    }
                });
            }

            if (flag) {
                if (!$(this).parents(".acc_sec_list").find(".acc_sec_all").is(":checked")) {
                    $(this).parents(".acc_sec_list").find(".acc_sec_all").trigger("click");
                }
            }
        });

        $('.btn-affirm').on("click", function () {
            var form = $("#reject-form");
            $.ajax({
                type: "POST",
                url: form.attr("action"),
                data: form.serialize(),
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
        });
    });
</script>