@php use Illuminate\Support\Str; @endphp
<x-app-layout :$sidebarLinks>
	@foreach($tasks as $task)
		<div class="bg-white rounded-lg shadow-md p-4 mb-4">
			<h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $task->title }}</h3>
			<p class="text-gray-600 text-sm mb-3">    {{ Str::limit($task->description, 50) }}</p>
			<div class="flex items-center justify-between">
				<span class="text-xs font-medium text-blue-600 px-2 py-1 bg-blue-100 rounded-full">{{ $task->status }}</span>
				<button class="text-sm text-gray-500 hover:text-gray-700">View Details</button>
			</div>
		</div>
	@endforeach
</x-app-layout>