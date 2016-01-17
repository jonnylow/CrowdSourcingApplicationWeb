<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="confirmModalLabel">Title</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center"><span class="modal-icon fa fa-5x"></span></div>
                    <div class="col-md-8"><p>Body</p></div>
                </div>
            </div>
            <div class="modal-footer">
                {!! Form::button('No', ['class' => 'btn btn-default', 'id' => 'cancel', 'data-dismiss' => 'modal']) !!}
                {!! Form::button('Yes', ['class' => 'btn btn-primary', 'id' => 'confirm']) !!}
            </div>
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->

@section('partial-script')

<!-- Dialog show event handler -->
<script type="text/javascript">
    $('#confirmModal').on('show.bs.modal', function (e) {
        $modalSize = $(e.relatedTarget).attr('data-size');
        $(this).find('.modal-dialog').addClass($modalSize);
        $type = $(e.relatedTarget).attr('data-type');
        switch($type) {
            case 'question': $(this).find('.modal-icon').addClass('fa-question');
                break;
            case 'info': $(this).find('.modal-icon').addClass('fa-info');
                break;
            case 'warning': $(this).find('.modal-icon').addClass('fa-exclamation');
                break;
        }
        $(this).find('.modal-icon').addClass($type);
        $title = $(e.relatedTarget).attr('data-title');
        $(this).find('.modal-title').text($title);
        $message = $(e.relatedTarget).attr('data-message');
        $(this).find('.modal-body p').text($message);
        $yesButton = $(e.relatedTarget).attr('data-yes');
        $(this).find('#confirm').text($yesButton);
        $noButton = $(e.relatedTarget).attr('data-no');
        $(this).find('#cancel').text($noButton);

        // Pass form reference to modal for submission on yes/ok
        var form = $(e.relatedTarget).closest('form');
        $(this).find('.modal-footer #confirm').data('form', form);
    });

    <!-- Form confirm (yes/ok) handler, submits form -->
    $('#confirmModal').find('.modal-footer #confirm').on('click', function(){
        $(this).data('form').submit();
    });
</script>

@endsection
