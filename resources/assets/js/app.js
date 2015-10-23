$(document).ready(function(){
  $('input').iCheck({
    tap: true,
    checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
  });

  $('.table-responsive table').bootstrapTable(); // init via javascript

    $(window).resize(function () {
        $('.table-responsive table').bootstrapTable('resetView');
    });
});

$("input[name='start_postal']").change(function(){
        var postal = $(this).val();
        var token = $("input[name='_token']").val();
        if(postal.length === 6) {
            $.ajax({
                type: 'POST',
                url: '{{ asset('postal-code-response') }}',
                data: {_token: token, postal: postal},
                dataType: 'json',
                success: function (data) {
                    var neighbourhood = data['neighbourhood'];
                    var address = data['address'];
                    var x = data['x'];
                    var y = data['y'];
                    $("input[name='activity_name_1']").val(neighbourhood);
                    $("textarea[name='start_location']").val(address);
                    $("input[name='start_location_lat']").val(y);
                    $("input[name='start_location_lng']").val(x);
                }
            });
        }
    });

$("input[name='end_postal']").change(function(){
    var postal = $(this).val();
    var token = $("input[name='_token']").val();
    if(postal.length === 6) {
        $.ajax({
            type: 'POST',
            url: '{{ asset('postal-code-response') }}',
            data: {_token: token, postal: postal},
            dataType: 'json',
            success: function (data) {
                var neighbourhood = data['neighbourhood'];
                var address = data['address'];
                var x = data['x'];
                var y = data['y'];
                $("input[name='activity_name_2']").val(neighbourhood);
                $("textarea[name='end_location']").val(address);
                $("input[name='end_location_lat']").val(y);
                $("input[name='end_location_lng']").val(x);
            }
        });
    }
});
