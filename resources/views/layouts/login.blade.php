<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SignIn</title>

    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <!-- stylesheets css -->
    <link rel="stylesheet" href="{{ asset('CSS/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/et-line-font.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/vegas.min.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/style.css') }}">

    <link href='https://fonts.googleapis.com/css?family=Rajdhani:400,500,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="shortcut icon" type="x-icon" href="{{ asset('Images/Logos/Logo-Light.svg') }}">

</head>

<body>
    @yield('sections')

    <!-- javscript js -->
    <script src="{{ asset('JS/jquery.js') }}"></script>
    <script src="{{ asset('JS/bootstrap.min.js') }}"></script>
    <script src="{{ asset('JS/vegas.min.js') }}"></script>
    <script src="{{ asset('JS/wow.min.js') }}"></script>
    <script src="{{ asset('JS/smoothscroll.js') }}"></script>
    <script src="{{ asset('JS/design.js') }}"></script>
    <script src="{{ asset('JS/login.js') }}"></script>
    
</body>
</html>