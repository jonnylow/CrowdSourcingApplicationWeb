@extends('layouts.master')

@section('title', '{{ $activity->name }}')

@section('content')

<div class="container-fluid">
    <div class="row">
            <h1>{{ $activity->name }}</h1>
    </div>
</div>

@endsection
