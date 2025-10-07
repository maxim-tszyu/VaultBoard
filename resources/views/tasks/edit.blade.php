<x-app-layout :$sidebarLinks>
	<div class="max-w-7xl mx-auto p-6 space-y-6">
		<div class="bg-white/10 text-white rounded-2xl shadow-md p-6">
			<h1 class="text-2xl font-bold mb-6">Редактировать задачу</h1>

			<form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-6">
				@csrf
				@method('PUT')

				<div>
					<label class="block text-sm font-medium text-gray-300 mb-1">Заголовок</label>
					<input type="text" name="title" value="{{ old('title', $task->title) }}"
						   class="w-full px-3 py-2 rounded-lg bg-white/5 border border-white/10
                                  focus:ring-2 focus:ring-blue-500 outline-none text-white">
				</div>

				<div>
					<label class="block text-sm font-medium text-gray-300 mb-1">Описание</label>
					<textarea name="description" rows="4"
							  class="w-full px-3 py-2 rounded-lg bg-white/5 border border-white/10
                                     focus:ring-2 focus:ring-blue-500 outline-none text-white">{{ old('description', $task->description) }}</textarea>
				</div>

				<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
					<div>

						<label class="block text-sm font-medium text-gray-300 mb-1">Статус</label>
						<select name="status"
								class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white border border-white/10">
							@foreach(\App\Enums\Status::cases() as $status)
								<option class="bg-gray-900 text-gray-200"
										value="{{ $status }}" @selected($task->status === $status)>
									{{ $status->value }}
								</option>
							@endforeach
						</select>
					</div>
					<div>
						<label class="block text-sm font-medium text-gray-300 mb-1">Приоритет</label>
						<select name="priority"
								class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white border border-white/10">
							@foreach(\App\Enums\Priority::cases() as $priority)
								<option class="bg-gray-900 text-gray-200"
										value="{{ $priority }}" @selected($task->priority === $priority)>
									{{ $priority->value }}
								</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="grid grid-cols-1 md:grid-cols-1 gap-4">
					<div>
						<label class="block text-sm font-medium text-gray-300 mb-1">Дедлайн</label>
						<input type="datetime-local" name="due_date"
							   value="{{ old('due_date', $task->due_date?->format('Y-m-d\TH:i')) }}"
							   class="w-full px-3 py-2 rounded-lg bg-white/5 border border-white/10 text-white">
					</div>
				</div>

				<div>
					<label class="block text-sm font-medium text-gray-300 mb-2">Категории</label>
					<div class="space-y-2 bg-gray-800 p-4 rounded-lg border border-white/10 max-h-60 overflow-y-auto">
						@foreach($categories as $category)
							<label class="flex items-center space-x-2 cursor-pointer">
								<input type="checkbox"
									   name="categories[]"
									   value="{{ $category->id }}"
									   class="rounded border-gray-600 bg-gray-700 text-blue-500 focus:ring-blue-500"
										@checked($task->categories->contains($category->id))>
								<span>{{ $category->title }}</span>
							</label>
						@endforeach
					</div>
				</div>

				<div>
					<label class="block text-sm font-medium text-gray-300 mb-1">Родительская задача</label>
					<select name="parent_task_id"
							class="w-full px-3 py-2 rounded-lg bg-gray-800 text-white border border-white/10">
						<option value="" class="bg-gray-900 text-gray-200">— Без родителя —</option>
						@foreach($allTasks as $t)
							@if($t->id !== $task->id and $t->parent !== $task->id)
								<option class="bg-gray-900 text-gray-200"
										value="{{ $t->id }}" @selected($task->parent_id === $t->id)>
									{{ $t->title }}
								</option>
							@endif
						@endforeach
					</select>
				</div>

				<div class="flex justify-end">
					<button type="submit"
							class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 font-medium">
						💾 Сохранить изменения
					</button>
				</div>
			</form>
		</div>
	</div>
</x-app-layout>
