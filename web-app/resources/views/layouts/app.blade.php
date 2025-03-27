<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'UniCT Connect')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @yield('style')
</head>

<body>
    <div class="wrapper">
        @if (Request::is('home'))
            @include('partials.header_home')
        @else
            @include('partials.header_auth')
        @endif

        <main class="container">
            @yield('content')
        </main>

        @include('partials.footer')
    </div>
    <script src="{{ asset('js/home.js') }}" defer></script>

    @yield('scripts')
</body>

</html>
