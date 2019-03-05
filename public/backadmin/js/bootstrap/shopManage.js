$(function () {
    //开始时间
    $('#qBeginTime').datepicker({
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true,
        endDate: new Date()
    }).on('changeDate', function (e) {
        var startTime = e.date;
        $('#qEndTime').datepicker('setStartDate', startTime);
    });
    //结束时间
    $('#qEndTime').datepicker({
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true,
        endDate: new Date()
    }).on('changeDate', function (e) {
        var endTime = e.date;
        $('#qBeginTime').datepicker('setEndDate', endTime);
    });

    $('.regain').on('click', function () {

        if ($(this).text() == '收回概况') {
            $(this).text('展开概况');
            $('.table1-div .table1').hide();
        }
        else if ($(this).text() == '展开概况') {
            $(this).text('收回概况');
            $('.table1-div .table1').show();
        }

    })
});