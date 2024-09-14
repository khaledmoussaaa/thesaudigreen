<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="root @if (app()->isLocale('ar')) rtl @endif">

<head>
    <!-- Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    
    <!-- Livewire -->
    @livewireStyles
    
    <!-- Internal CSS -->
    @can('employee')
    <link rel="stylesheet" href="{{ asset('CSS/Admin.css') }}">
    @elsecan('customer')
    <link rel="stylesheet" href="{{ asset('CSS/Customer.css') }}">
    @endcan
    <link rel="stylesheet" href="{{ asset('CSS/Common.css') }}">

    <!-- External CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Icon -->
    <link rel="shortcut icon" type="x-icon" href="{{ asset('Images/Logos/Logo-Light.svg') }}">

    <!-- Title -->
    <title>@yield('title')</title>

</head>