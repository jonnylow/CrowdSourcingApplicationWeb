<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/icheck/green.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap-table.min.css') }}" rel="stylesheet">

        @yield('head')
    </head>

    <body>
        @include('layouts.header')

        @yield('content')

        @include('layouts.footer')

        @yield('page-script')
    </body>
</html>
