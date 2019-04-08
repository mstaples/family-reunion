<!DOCTYPE HTML>
<html>
<head>
    <title>Chosen Family Reunion</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/hearts.css') }}" rel="stylesheet">
    <noscript><link href="{{ asset('css/noscript.css') }}" rel="stylesheet"></noscript>
    <script>
        document.onload = function() {
            window.location.href = "#"+{{ $hash }};
        };
    </script>
</head>