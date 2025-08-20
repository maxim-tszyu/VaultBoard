@php use App\Enums\Priority;@endphp
<x-app-layout>
	<h2 class="mb-6 text-2xl font-bold text-gray-900 dark:text-white">Create a new task</h2>
	<form action="{{ route('tasks.store') }}" method="POST" class="space-y-6">
		@csrf

		<div>
			<label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Task Title</label>
			<input type="text" name="title" id="title" placeholder="Type the title of a task" required
				   class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"/>
		</div>

		<div>
			<label for="description"
				   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
			<textarea id="description" name="description" rows="6" placeholder="Your description here"
					  class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"></textarea>
		</div>

		<div>
			<label for="priority" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Priority</label>
			<select id="priority" name="priority"
					class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-primary-500 dark:focus:border-primary-500">
				<option selected disabled>Select priority</option>
				@foreach(Priority::values() as $key => $value)
					<option value="{{$key}}">{{$value}}</option>
				@endforeach
			</select>
		</div>

		<div>
			<label for="categories"
				   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categories</label>
			<div x-data="{
    open: false,
    selected: [],
    options: {{ Js::from(auth()->user()->categories->map(fn($c) => [
        'id' => $c->id,
        'title' => $c->title
    ])->toArray() ?? []) }},
    toggle(id) {
        id = Number(id)
        if (this.selected.includes(id)) {
            this.selected = this.selected.filter(s => s !== id)
        } else {
            this.selected.push(id)
        }
    },
    selectedTitles() {
        return this.options
            .filter(o => this.selected.includes(Number(o.id)))
            .map(o => o.title)
    }
}" class="relative">
				<button type="button"
						@click="open = !open"
						class="w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg flex justify-between items-center focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">

        <span
				x-text="selected.length
                ? selectedTitles().join(', ')
                : (options.length ? 'Select categories' : 'Create categories')">
        </span>
					<svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
					</svg>
				</button>

				<div x-show="open" @click.away="open = false"
					 class="absolute mt-1 w-full bg-white border rounded-lg shadow-lg z-10">
					<template x-for="option in options" :key="option.id">
						<label class="flex items-center px-3 py-2 hover:bg-gray-100">
							<input type="checkbox"
								   :value="option.id"
								   @change="toggle(option.id)"
								   :checked="selected.includes(Number(option.id))">
							<span class="ml-2" x-text="option.title"></span>
						</label>
					</template>
				</div>

				<template x-for="id in selected" :key="id">
					<input type="hidden" name="category_ids[]" :value="id">
				</template>
			</div>
		</div>

		<div>
			<label for="datetime" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select
				deadline</label>
			<input type="datetime-local" id="datetime" name="datetime"
				   class="block w-full p-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 dark:focus:ring-primary-500 dark:focus:border-primary-500"/>
		</div>

		<div>
			<button type="submit"
					class="w-40 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800">
				Add Task
			</button>
		</div>
	</form>

</x-app-layout>
