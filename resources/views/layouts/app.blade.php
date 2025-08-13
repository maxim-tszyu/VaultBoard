<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
<div class="min-h-screen flex">
	<!-- Header -->

	<aside class="w-64 h-screen bg-gray-50 dark:bg-gray-800">
		@include('layouts.sidebar')
	</aside>

	<div class="flex-1 flex flex-col">

		<div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 h-16 flex items-center">
			@include('layouts.navigation')
		</div>

		<main class="flex-1 overflow-auto">
			{{ $slot }}
		</main>
	</div>
</div>
</body>
</html>
