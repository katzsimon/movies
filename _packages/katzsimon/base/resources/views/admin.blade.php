<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name') }} Admin</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <link href="{{ url('/css/admin.css') }}" rel="stylesheet"/>
    <link href="{{ url('/css/diesel.min.css') }}" rel="stylesheet"/>
    <link href="{{ url('/css/diesel-flat3d.min.css') }}" rel="stylesheet"/>

    <script src="{{ url('/js/dayjs.min.js') }}" defer></script>
    <script src="{{ url('/js/isLeapYear.min.js') }}" defer></script>
    <script src="{{ url('/js/customParseFormat.min.js') }}" defer></script>
    <script src="{{ url('/js/plugins.js') }}" defer></script>
    <script src="{{ url('/js/diesel.min.js') }}" defer></script>
    <script src="{{ url('/js/admin.js') }}" defer></script>


</head>
<body>

    @yield('page-content')

</body>
</html>
