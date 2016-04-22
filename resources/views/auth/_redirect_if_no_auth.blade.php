{{-- View partial to redirect unauthenticated user to login page --}}
@section('auth-script')

<input id="reloadValue" type="hidden" name="reloadValue" value="" />
<script type="text/javascript">
    $(document).ready(function() {
        var d = new Date().getTime();

        window.onpageshow = function(event) {
            if ($('#reloadValue').val().length == 0) {
                $('#reloadValue').val(d);
                $('body').show();
            } else {
                if (event.persisted) {
                    $('#reloadValue').val('');
                    window.location.reload();
                } else {
                    $('#reloadValue').val('');
                    location.reload();
                }
            }
        };
    });
</script>

@endsection
