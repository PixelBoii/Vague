<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>
        <link rel="stylesheet" href="/vendor/vague/css/app.css">
    </head>
    <body class="antialiased">
        <div class="relative flex items-center justify-center min-h-screen w-screen bg-cover bg-center" style="background-image: url('@yield('image')')">
            <div class="relative text-center space-y-4">
                <p class="text-5xl font-bold text-white"> @yield('code') </p>

                <p class="text-xl font-medium text-gray-100 max-w-lg"> @yield('message') </p>
            </div>
        </div>
    </body>
</html>
