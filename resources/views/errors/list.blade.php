@if (count($errors) || Session::has('success'))
    <div class="alert alert-{{ count($errors) ? 'danger' : 'success' }} alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="col-md-11">
            @if (count($errors))
                <div class="col-md-3 text-center">
                    <div class="row"><strong><h4>Error!</h4></strong></div>
                    <div class="row"><span class="fa fa-times-circle-o fa-3x"></span></div>
                </div>
                <div class="col-md-9">
                    <strong>Please double-check and try again.</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif (Session::has('success'))
                <div class="col-md-3 text-center">
                    <span class="fa fa-check-circle-o fa-4x"></span>
                </div>
                <div class="col-md-9">
                    <div class="row"><strong><h4>Success!</h4></strong></div>
                    <div class="row"><h4>{{ Session::get('success') }}</h4></div>
                </div>
            @endif
        </div>
        <div class="clearfix"></div>
    </div>
@endif