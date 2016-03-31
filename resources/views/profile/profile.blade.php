@extends('layouts.master')

@section('title', 'View my Profile')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>View my Profile</h1>

            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-information">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapse-information" aria-expanded="true" aria-controls="collapse-information">
                                <span class="fa fa-fw fa-user"></span>
                                <strong>Personal Information</strong>
                                <span class="icon-arrow fa fa-lg fa-chevron-up"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-information" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading-information">
                        <div class="panel-body">
                            <dl class="dl-horizontal">
                                <dt>Name:</dt><dd>{{ $profile->name }}</dd>
                                <dt>Email:</dt><dd>{{ $profile->email }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('auth-script')

@include('auth._redirect_if_no_auth')

@endsection
