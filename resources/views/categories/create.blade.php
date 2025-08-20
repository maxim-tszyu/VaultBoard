@php use App\Enums\Status; @endphp
<x-app-layout>
	<h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">Create a new task</h2>
	<form action="{{ route('categories.store') }}" method="POST" class="space-y-6">
		@csrf
		@method('POST')
		<div>
			<label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category Title</label>
			<input type="text" name="title" id="title" placeholder="Type the title of a category" required
				   class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"/>
		</div>
		<div>
			<button type="submit"
					class="w-40 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
				Add Category
			</button>
		</div>
	</form>

</x-app-layout>
