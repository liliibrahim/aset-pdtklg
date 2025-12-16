<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-100">

 <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-100">

    <!-- JATA + NAMA PEJABAT (LUAR BOX BIRU) -->
    <div class="flex flex-col items-center mt-6 mb-4">
        <img 
            src="{{ asset('image/jataselangor.png') }}" 
            alt="Jata Selangor"
            class="h-20 w-auto mb-2"
        >
        <div class="text-center">
            <div class="text-sm font-bold uppercase text-gray-800">
                Pejabat Daerah dan Tanah Klang
            </div>
        </div>
    </div>

    <!-- HEADER BIRU FULL WIDTH (TEKS SAHAJA) -->
    <header class="w-full bg-blue-900 text-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-3 text-center">
            <div class="text-base font-semibold uppercase">
                Sistem Pemantauan Aset ICT
            </div>
        </div>
    </header>

    <!-- CONTENT -->
    <div class="min-h-screen flex flex-col items-center justify-start mt-8">
        <div class="w-full max-w-md px-6 py-4 bg-white shadow-md rounded-lg">
            {{ $slot }}
        </div>
    </div>

</body>
</html>