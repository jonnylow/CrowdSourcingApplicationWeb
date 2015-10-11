<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>

        <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/bootflat.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/icheck.css') }}" rel="stylesheet">

        @yield('head')
    </head>

    <body>
        @include('layouts.header')

        @yield('content')

        @include('layouts.footer')
    </body>
</html>
