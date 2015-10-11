<!-- Bootstrap -->
<script src="{{ URL::asset('js/jquery-1.11.0.min.js') }}"></script>
<script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>

<!-- Bootflat -->
<script src="{{ URL::asset('js/icheck.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery.fs.selecter.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery.fs.stepper.min.js') }}"></script>

<script>
$(document).ready(function(){
  $('input').icheck({
    tap: true,
    checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
  });
});
</script>
