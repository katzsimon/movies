<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name') }} App</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />


    @if(View::hasSection('page-content') || $output==='blade')
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('/js/app.js') }}" defer></script>
    @endif
</head>
<body>
@if(View::hasSection('page-content') || $output==='blade')
    @yield('page-content')
@else
    <div id="app"></div>
@endif
</body>
</html>
