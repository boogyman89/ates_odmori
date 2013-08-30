var vacationRequest = vacationRequest || {};

vacationRequest.initDatepicker = function() {
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

    var checkin = $('.start_date_help').datepicker({
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
            if (ev.date.valueOf() > checkout.date.valueOf()) {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
                checkout.setValue(newDate);
            }
            checkin.hide();
            $('.end_date_help')[0].focus();
        }).data('datepicker');
    var checkout = $('.end_date_help').datepicker({
        onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
            checkout.hide();
        }).data('datepicker');

    $('.btn').click(function(){

        var start = new Date($('.start_date_help').val());
        var dd = start.getDate();
        var mm = start.getMonth()+1; //January is 0!

        var yyyy = start.getFullYear();
        if(dd<10){dd='0'+dd}
        if(mm<10){mm='0'+mm}
        start = yyyy+'-'+mm+'-'+dd;

        var end = new Date($('.end_date_help').val());
        dd = end.getDate();
        mm = end.getMonth()+1; //January is 0!

        yyyy = end.getFullYear();
        if(dd<10){dd='0'+dd}
        if(mm<10){mm='0'+mm}
        end = yyyy+'-'+mm+'-'+dd;

        $('#vacation_request_start_date').val(start);
        $('#vacation_request_end_date').val(end);


    });

    $(function(){
        if($('#vacation_request_start_date').val() != '')
        {
            $('.start_date_help').val($('#vacation_request_start_date').val());
            $('.end_date_help').val($('#vacation_request_end_date').val());
        }
    });
};
