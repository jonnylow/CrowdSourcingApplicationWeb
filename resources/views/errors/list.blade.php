@if (count($errors) || Session::has('success'))
    <div class="alert alert-{{ count($errors) ? 'danger' : 'success' }} alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        @if (count($errors))
            <strong>Please double-check and try again.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @elseif (Session::has('success'))
            {{ Session::get('success') }}
        @endif
    </div>
@endif