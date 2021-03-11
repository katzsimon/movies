<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name') }} App</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <link href="{{ url('/css/app.css') }}" rel="stylesheet"/>
    <script src="{{ url('/js/app.js') }}" defer></script>


</head>
<body>

    @yield('page-content')

</body>
</html>
