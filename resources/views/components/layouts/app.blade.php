<!-- resources/views/components/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livewire Chat</title>
    <!-- Add your styles or include CSS here -->
    @livewireStyles
</head>

<body>
    <div>
        @yield('main')
    </div>
    <script src="{{ asset('vendor/livewire/livewire.js') }}"></script>
    @livewireScripts
</body>

</html>