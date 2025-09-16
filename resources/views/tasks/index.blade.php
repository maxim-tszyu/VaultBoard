<x-app-layout :$sidebarLinks>
	<div class="max-w-7xl mx-auto p-6 space-y-6">

		<div class="flex items-center justify-between mb-6">
			<h1 class="text-3xl font-bold text-white">Мои задачи</h1>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
			@forelse($tasks as $task)
				@php
					$priorityClasses = [
						'Low' => 'bg-purple-600 text-white',
						'Medium' => 'bg-purple-500 text-white',
						'High' => 'bg-purple-700 text-white',
					];
					$statusClasses = [
						'Active'    => 'bg-blue-800 text-white',
						'Inactive'  => 'bg-gray-700 text-white',
						'Aborted'   => 'bg-red-700 text-white',
						'Completed' => 'bg-green-700 text-white',
					];

					$completed = $task->subtasks->where('status', 'Completed')->count();
					$total = $task->subtasks->count();
					$percent_ready = $total > 0 ? ($completed / $total) * 100 : 0;
				@endphp

				<div class="bg-white/10 text-white rounded-2xl shadow-md p-6 flex flex-col justify-between">
					<div>
						<h2 class="text-xl font-semibold mb-2 truncate">{{ $task->title }}</h2>
						<p class="text-sm text-gray-300 line-clamp-2 mb-3">{{ $task->description }}</p>

						<div class="flex flex-wrap gap-2 text-xs mb-3">
                            <span class="px-2 py-1 rounded-full {{ $statusClasses[$task->status] ?? 'bg-white/10 text-gray-800' }}">
                                {{ $task->status }}
                            </span>
							<span class="px-2 py-1 rounded-full {{ $priorityClasses[$task->priority] ?? 'bg-white/10 text-gray-800' }}">
                                {{ ucfirst($task->priority) }}
                            </span>
							<span class="px-2 py-1 rounded-full bg-green-800/50">
                                Дедлайн: {{ $task->due_date?->format('d.m.Y') ?? '—' }}
                            </span>
						</div>

						<div class="text-xs text-gray-400 space-y-1 mb-3">
							<p>🔗 Родитель:
								@if($task->parent)
									<a href="{{ route('tasks.show', $task->parent->id) }}" class="text-blue-400 hover:underline">
										{{ Str::limit($task->parent->title, 20) }}
									</a>
								@else
									нет
								@endif
							</p>
							<p>📎 Дочерние:
								@if($task->subtasks->isNotEmpty())
									@foreach($task->subtasks->take(2) as $subtask)
										<a href="{{ route('tasks.show', $subtask->id) }}" class="text-blue-400 hover:underline">
											{{ Str::limit($subtask->title, 20) }}
										</a>@if(!$loop->last),@endif
									@endforeach
									@if($task->subtasks->count() > 2)
										…и ещё {{ $task->subtasks->count() - 2 }}
									@endif
								@else
									нет
								@endif
							</p>
						</div>

						<div class="w-full bg-gray-700 rounded-full h-2 mb-2">
							<div class="bg-green-500 h-2 rounded-full" style="width: {{ $percent_ready }}%"></div>
						</div>
						<p class="text-xs text-gray-400">{{ $completed }} / {{ $total }} подзадач</p>
					</div>

					<div class="mt-4 flex justify-between items-center">
						<a href="{{ route('tasks.show', $task->id) }}"
						   class="text-blue-400 text-sm hover:underline">Подробнее</a>

						<div class="flex gap-2">
							@switch($task->status)
								@case('Inactive')
									<form method="POST" action="{{ route('tasks.update.status', $task) }}">
										@csrf
										@method('PATCH')
										<input type="hidden" name="status" value="Active">
										<button type="submit"
												class="px-2 py-1 rounded bg-blue-600/70 text-xs hover:bg-blue-700/80">
											Начать
										</button>
									</form>
									@break

								@case('Active')
									<form method="POST" action="{{ route('tasks.update.status', $task) }}">
										@csrf
										@method('PATCH')
										<input type="hidden" name="status" value="Completed">
										<button type="submit"
												class="px-2 py-1 rounded bg-green-600/70 text-xs hover:bg-green-700/80">
											Завершить
										</button>
									</form>
									<form method="POST" action="{{ route('tasks.update.status', $task) }}">
										@csrf
										@method('PATCH')
										<input type="hidden" name="status" value="Aborted">
										<button type="submit"
												class="px-2 py-1 rounded bg-red-600/70 text-xs hover:bg-red-700/80">
											Прервать
										</button>
									</form>
									@break
							@endswitch
						</div>
					</div>
				</div>
			@empty
				<p class="text-gray-400 col-span-3">У вас пока нет задач</p>
			@endforelse
		</div>
	</div>
</x-app-layout>
