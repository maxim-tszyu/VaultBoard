<x-app-layout>
	<div class="max-w-7xl mx-auto p-6 space-y-8">

		<h1 class="text-3xl font-bold text-white">Все задачи</h1>

		<div class="flex gap-4 overflow-x-auto pb-2 mt-4">
			@foreach($tasks as $task)
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

				<div class="min-w-[350px] p-5 bg-white/10 text-white rounded-2xl shadow flex flex-col justify-between">
					<div>
						<h2 class="text-lg font-semibold truncate">{{ $task->title }}</h2>
						<p class="text-sm text-gray-300 line-clamp-2 mb-3">{{ $task->description }}</p>

						<div class="flex flex-wrap gap-2 text-xs mb-3">
                            <span class="px-2 py-1 rounded-full {{ $statusClasses[$task->status] ?? 'bg-white/10 text-gray-800' }}">
                                {{ $task->status }}
                            </span>
							<span class="px-2 py-1 rounded-full {{ $priorityClasses[$task->priority] ?? 'bg-white/10 text-gray-800' }}">
                                {{ ucfirst($task->priority) }}
                            </span>
							<span class="px-2 py-1 rounded-full bg-green-800/50">
                                {{ $task->due_date?->format('d.m.Y') ?? 'Без дедлайна' }}
                            </span>
						</div>

						<div class="w-full bg-gray-700 rounded-full h-2 mb-2">
							<div class="bg-green-500 h-2 rounded-full" style="width: {{ $percent_ready }}%"></div>
						</div>
						<p class="text-xs text-gray-400">{{ $completed }} / {{ $total }} подзадач</p>
					</div>

					<div class="mt-4 flex justify-between items-center">
						<a href="{{ route('tasks.show', $task->id) }}"
						   class="text-blue-400 text-sm hover:underline">Подробнее</a>

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
			@endforeach
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
			<section class="bg-white/10 rounded-2xl shadow p-5 text-white">
				<h3 class="text-xl font-semibold mb-3">⚡ Приоритетные задачи</h3>
				<div class="space-y-2">
					@foreach($priorityTasks as $task)
						<div class="p-3 bg-white/5 rounded-lg flex justify-between">
							<p class="font-medium">{{ $task->title }}</p>
							<span class="text-xs px-2 py-1 rounded-full bg-purple-600">{{ $task->priority }}</span>
						</div>
					@endforeach
				</div>
			</section>

			<section class="bg-white/10 rounded-2xl shadow p-5 text-white">
				<h3 class="text-xl font-semibold mb-3">🔥 Горящие задачи</h3>
				<div class="space-y-2">
					@foreach($urgentTasks as $task)
						<div class="p-3 bg-white/5 rounded-lg flex justify-between">
							<p class="font-medium">{{ $task->title }}</p>
							<span class="text-xs px-2 py-1 rounded-full bg-red-600">
                                {{ $task->due_date?->format('d.m.Y') }}
                            </span>
						</div>
					@endforeach
				</div>
			</section>
		</div>

		<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
			<section class="p-5 bg-white/10 rounded-2xl shadow text-white grid grid-cols-2 gap-4">
				<div>
					<h3 class="text-lg font-bold mb-1">Доход</h3>
					<p class="text-2xl font-semibold">₸ 125 000</p>
				</div>
				<div class="flex flex-col items-end text-right">
					<h3 class="text-lg font-bold mb-1">Расход</h3>
					<p class="text-2xl font-semibold">₸ 80 000</p>
				</div>
				<div class="col-span-2 text-center">
					<h3 class="text-lg font-bold mb-1">Прогресс к цели</h3>
					<div class="w-full bg-gray-700 h-2 rounded-full mb-2">
						<div class="bg-green-500 h-2 rounded-full" style="width: 60%"></div>
					</div>
					<p class="text-sm">60% выполнено, осталось ₸ 50 000</p>
				</div>
			</section>

			<section class="p-5 bg-white/10 rounded-2xl shadow text-white">
				<h3 class="text-xl font-semibold mb-3">📈 Прогресс</h3>
				<div class="h-40 flex items-center justify-center text-gray-400">
					Chart placeholder
				</div>
			</section>

			<section class="p-5 bg-white/10 rounded-2xl shadow text-white">
				<h3 class="text-xl font-semibold mb-3">🤖 Оценка от AI</h3>
				<p class="text-gray-300 text-sm">
					Ты выполнил 70% задач за эту неделю. Советую сосредоточиться на 🔥 горящих задачах.
				</p>
			</section>
		</div>

		<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
			<section class="p-5 bg-white/10 rounded-2xl shadow text-white">
				<h3 class="text-xl font-semibold mb-3">📝 Недавние записи</h3>
				<ul class="space-y-2 text-sm text-gray-300">
					<li>• Лог по задаче #1</li>
					<li>• Лог по задаче #2</li>
					<li>• Лог по задаче #3</li>
				</ul>
			</section>

			<section class="p-5 bg-white/10 rounded-2xl shadow text-white">
				<h3 class="text-xl font-semibold mb-3">📄 Последний отчёт</h3>
				<p class="text-gray-300 text-sm">
					На этой неделе закрыто 12 задач. В работе осталось 8 активных.
				</p>
			</section>
		</div>
	</div>
</x-app-layout>
