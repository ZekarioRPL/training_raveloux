<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title></title>

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    {{-- Select 2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- Style CSS --}}
    @vite(['resources/js/app.js', 'resources/css/externals/table/commonTable.css', 'resources/css/externals/elements/select2/select2.css'])

    @vite(['resources/css/app.css', 'resources/css/internals/main.css', 'resources/css/internals/layout.css', 'resources/js/app.js'])

    <!-- Custom Style Current Page -->
    @yield('style')
</head>

<body>

    @include('layouts.panel.navbar')
    @include('layouts.panel.sidebar')

    <div class=" min-h-screen bg-gray-50 dark:bg-gray-900 p-2 mt-4 sm:ml-64">
        <div class="p-4 mt-8">
            @yield('content')
        </div>

    </div>

    <!-- Elemets Flowbite -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/datepicker.min.js"></script>

    <!-- Feather Icon -->
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>

    <!-- Custom Script Current Page -->
    @yield('script')
</body>

</html>
