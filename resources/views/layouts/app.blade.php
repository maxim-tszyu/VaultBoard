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

	<div class="w-64 h-screen bg-gray-50 dark:bg-gray-800">
	</div>

	<div class="flex-1 flex flex-col">
		@include('layouts.navigation')

		<div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 h-16 grid grid-cols-2">
			@include('layouts.sidebar')
			<div class="col-span-2">
				{{ $slot }}
			</div>
		</div>
	</div>
</div>
</body>
</html>
