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
