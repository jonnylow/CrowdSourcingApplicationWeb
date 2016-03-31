@section('auth-script')

<input id="reloadValue" type="hidden" name="reloadValue" value="" />
<script type="text/javascript">
    $(document).ready(function() {
        var d = new Date().getTime();
        if ($('#reloadValue').val().length == 0) {
            $('#reloadValue').val(d);
            $('body').show();
        } else {
            $('#reloadValue').val('');
            location.reload();
        }
    });
</script>

@endsection
