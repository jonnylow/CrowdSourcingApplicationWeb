@extends('layouts.master')

@section('title', 'Add new Location')

@section('content')

<div class="container-fluid margin-bottom-lg">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1>Add new Location</h1>

            @include('errors.list')

            {!! Form::open(['route' => 'centres.store']) !!}

                <div class="panel-group margin-bottom-md" id="accordion" role="tablist" aria-multiselectable="true">

                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading-information">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" href="#collapse-information" aria-expanded="true" aria-controls="collapse-information">
                                    <span class="fa fa-fw fa-map-signs"></span>
                                    <strong>Location Information</strong>
                                    <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                                </a>
                            </h4>
                        </div>
                        <div id="collapse-information" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-information">
                            <div class="panel-body">
                                <div class="row">
                                    <!-- Name Form Input -->
                                    <div class="col-md-7 form-group">
                                        {!! Form::label('name', 'Location Name', ['class' => 'control-label']) !!}
                                        {!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => 'e.g. Henderson Home', 'onBlur' => 'javascript:{this.value = this.value.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});}']) !!}
                                    </div>
                                    <!-- Postal Form Input -->
                                    <div class="col-md-5 form-group">
                                        {!! Form::label('postal', 'Postal Code', ['class' => 'control-label']) !!}
                                        {!! Form::text('postal', null, ['class' => 'form-control', 'required', 'maxlength' => '6', 'pattern' => '[0-9]{6}', 'placeholder' => 'e.g. 123456']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Address Form Input -->
                                    <div class="col-md-12 form-group">
                                        {!! Form::label('address', 'Address', ['class' => 'control-label']) !!}
                                        {!! Form::text('address', null, ['class' => 'form-control', 'required', 'readonly']) !!}
                                    </div>
                                    <div class="col-md-12 form-group">
                                        {!! Form::text('address_more', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Submit Button Form Input -->
                <div class="form-group text-center">
                    {!! Form::submit('Add location', ['class' => 'btn btn-primary btn-lg']) !!}
                </div>

            {!! Form::close() !!}
        </div>
    </div>
</div>

@endsection

@section('page-script')

{!! $validator !!}

<script>
    $('input[name="postal"]').on('focusout', function() {
        var postal = $(this).val();
        var token = $("input[name='_token']").val();

        if(!isNaN(postal) && (postal.length === 6) && (postal % 1 === 0)) {
            $.ajax({
                type: 'POST',
                data: {_token: token, postal: postal},
                dataType: 'json',
                url: '{{ asset('/postal-to-address') }}',
                success: function (data) {
                    if (data['status'] === 'ok') {
                        var address = data['address'];
                        $("input[name='address']").val(address);
                    } else {
                        if ($('input[name="postal"]').siblings('.help-block').length === 0) {
                            var error = '<span id="postal-error" class="help-block error-help-block"></span>';
                            $('input[name="postal"]').parent('div.form-group').append(error);
                        }

                        $("input[name='address']").val("");
                        $('input[name="postal"]').parent('div.form-group').removeClass('has-success').addClass('has-error');
                        $('span#postal-error').html("Postal code does not exist.");
                    }
                }
            });
        }
    });


</script>

@endsection