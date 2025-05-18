<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'dcpic.eu') }}</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
	
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
	
    @include('components.announcement')
    @include('components.navbar')

    <main class="flex-grow container mx-auto p-4">
        @include('components.alert')
        @yield('content')
    </main>

    @include('components.footer')
	
	<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
