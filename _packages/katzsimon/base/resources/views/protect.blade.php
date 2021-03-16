{{-- Displays the Password prompt for the Protect Middleware --}}<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }
        *,
        *:after,
        *::before {
            box-sizing: border-box;
            margin:0;
            padding:0;
        }

        .wrapper {
            align-items: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100vh;
            width:100%;
        }



        .control-label {
            font-weight:700;
        }
        .form-control {
            display: block;
            width: 100%;

            padding:10px 20px;

            line-height: 1.5;

            background-color: #fff;

            border: 1px solid #ced4da;
            font-size:16px;

            transition:border 300ms;
        }
        .form-control:focus {
            transition:border 300ms;
            border:1px solid #000;
        }
        .form-control, input, button, select, .btn {
            outline: none !important;
            -webkit-box-shadow: none;
            box-shadow: none;
            text-align: center;
        }


        .container {
            max-width:600px;
            margin-left: auto;
            margin-right: auto;
        }
        .submit {
            background-color:#333;
            color:#fff;
            border:0;
            padding:20px;
            display:block;
            margin-top:15px;
            border-radius:4px;
            width:100%;
            font-weight:700;
            font-size:16px;
            opacity:0.9;
            cursor:pointer;
        }
        .submit:hover {
            opacity:1;
        }
        .formgroup {
            display:none;
        }
        .logo {
            margin-top:30px;
            margin-bottom:30px;
            max-width:200px;
        }
        .center {
            text-align:center;
        }


    </style>
</head>
<body>
<div class="wrapper">
    <div class="center">

        <h3>Protected!</h3>
        <p style="margin-bottom:50px;">Please enter the password to continue</p>
        <form action="{{ route('app.protect') }}" method="post">
            <input type="hidden" name="url" value="{{ url()->current() }}">
            @csrf
            <div class="formgroup">
                <label for="name">Name</label>
                <input type="text" name="name" id="name">
            </div>
            <div class="container">
                <div class="form-group">
                    <label class="control-label" for="email">Password</label>
                    <input type="password" class="form-control" name="password" id="password" value="">
                </div>
                <button type="submit" class="submit">Continue</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
