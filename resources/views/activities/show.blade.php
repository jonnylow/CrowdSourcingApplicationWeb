@extends('layouts.master')

@section('title', $activity->name)

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>{{ $activity->name }}</h1>

    </div>
</div>

@endsection
