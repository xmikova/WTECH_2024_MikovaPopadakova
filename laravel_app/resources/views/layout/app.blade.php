<!DOCTYPE html>
<html lang="sk">
<head>
    @include('layout.partials.head')
    @yield('customCss')
</head>

<body>
@include('layout.partials.header')
@include('layout.partials.sidebar')

<main >
    @yield('content')
</main>

@include('layout.partials.footer')
@include('layout.partials.footscripts')
@yield('customJs')
</body>
</html>
