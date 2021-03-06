<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <style>
        html {
            background-color: black;
        }

        html::-webkit-scrollbar{
            display : none;
        }

        * {
            margin: 0;
            padding: 0;
        }

        #all {
            position: fixed;
            top: 0px;
            left: 0px;
            right: 0px;
            z-index: 1000;
            transition: All 0.4s ease;
            -webkit-transition: All 0.4s ease;
            -moz-transition: All 0.4s ease;
            -o-transition: All 0.4s ease;
            color: white;
        }

        .navi_title {
            margin-top: 4%;
            padding-left: 50%;
            height: 60px;
        }

        .navi_title h2 {
            margin-top: 50px;
        }

        .navi {
            width: 500px;
            margin: 0 auto;
            position: relative;
        }

        .navi #navibar {
            border-bottom: 2.5px solid white;
            padding-left: 20%;
        }

        #navibar a {
            text-decoration: none;
            color: white;
            padding-right: 12%;
        }

        .navi_title a {
            text-decoration: none;
            color: white;
        }
        .navi_title a:active{
            text-decoration: none;
            color: white;
        }

        .navilog {
            position: fixed;
            z-index: 1001;
            margin-top: 1%;
            top: 0;
            left: 90%;
            transition: All 0.4s ease;
            -webkit-transition: All 0.4s ease;
            -moz-transition: All 0.4s ease;
            -o-transition: All 0.4s ease;
        }

        .navilog a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
<script src="js/navibar.js" type="text/javascript"></script>
</body>
</html>