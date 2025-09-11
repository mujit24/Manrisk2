<!doctype html>
<html lang="en">

<head>
    <title>MUJ APPS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Iconic Bootstrap 4.5.0 Admin Template">
    <meta name="author" content="WrapTheme, design by: ThemeMakker.com">
    <link rel="icon" href="{{asset('assets/images/logo.ico')}}" type="image/x-icon">
    @include('include.style')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body data-theme="light" class="font-nunito">
    <div id="wrapper" class="theme-cyan">
        @include('include.header')
        @include('include.sidebar')
        <!-- mani page content body part -->
        <div id="main-content">
            <div class="container-fluid">

                @yield('content')
            </div>
        </div>

        @include('include.script')
        @stack('js')
    </div>
</body>

</html>