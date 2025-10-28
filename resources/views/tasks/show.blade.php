@props(['task'])
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
@endphp
<x-app-layout :$sidebarLinks>
	<div class="max-w-7xl mx-auto p-6 space-y-6">
		<div class="bg-white/10 text-white rounded-2xl shadow-md p-6">
			<h1 class="text-3xl font-bold mb-4">{{ $task->title }}</h1>
			<p class="text-gray-200 mb-4">{{ $task->description }}</p>
			<p class="text-gray-200 mb-4">{{ $task->embedding ?? 'something' }}</p>

			<div class="flex flex-wrap gap-4 text-sm text-gray-300">
				<span class="px-3 py-1 rounded-full font-medium {{ $statusClasses[$task->status] ?? 'bg-white/10 text-gray-800' }}">
					{{ $task->status }}
				</span>

				<span class="px-3 py-1 rounded-full font-medium {{ $priorityClasses[$task->priority] ?? 'bg-white/10 text-gray-800' }}">
					{{ ucfirst($task->priority) }}
				</span>

				<span class="px-3 py-1 rounded-full bg-green-800/50">
					Дедлайн: {{ $task->due_date?->format('d.m.Y') }}
				</span>
				<span class="px-3 py-1 rounded-full bg-green-800/50">
					Categories: {{ implode(', ', $task->categories->pluck('title')->toArray()) }}
				</span>
				<span class="px-3 py-1 rounded-full bg-blue-800/50">
					Started at: {{ $task->started_at }}
				</span>
				<span class="px-3 py-1 rounded-full bg-red-800/50">
					Completed at: {{ $task->completed_at }}
				</span>
			</div>
			<div class="flex gap-2 mt-5 px-1">

				@switch($task->status)
					@case('Inactive')
						<form method="POST" action="{{ route('tasks.update.status', $task) }}">
							@csrf
							@method('PATCH')
							<input type="hidden" name="status" value="Active">
							<button type="submit"
									class="px-4 py-2 rounded-sm bg-blue-600/70 text-white text-xs hover:bg-blue-700/80">
								Начать
							</button>
						</form>
					@case('Active')

						<form method="POST" action="{{ route('tasks.update.status', $task) }}">
							@csrf
							@method('PATCH')
							<input type="hidden" name="status" value="Completed">
							<button type="submit"
									class="px-3 py-2 rounded-sm bg-green-600/70 text-white text-xs hover:bg-green-700/80">
								Завершить
							</button>
						</form>

						<form method="POST" action="{{ route('tasks.update.status', $task) }}">
							@csrf
							@method('PATCH')
							<input type="hidden" name="status" value="Aborted">
							<button type="submit"
									class="px-3 py-2 rounded-sm bg-red-600/70 text-white text-xs hover:bg-red-700/80">
								Забросить
							</button>
						</form>
				@endswitch
				<a class="px-3 py-2 rounded-sm bg-yellow-600/70 text-white text-xs hover:bg-yellow-700/80" href="{{route('tasks.edit', $task->id)}}">Изменить</a>
			</div>

		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
			<div class="bg-white/10 text-white rounded-2xl shadow-md p-6 md:col-span-2">
				<h2 class="text-xl font-semibold mb-4">История / Логи</h2>

				<div class="grid grid-cols-4 gap-4 mb-6">
					@foreach( $task->activity_logs as $log)
						<div class="bg-white/5 p-3 rounded-xl">
							<p class="text-sm font-semibold text-gray-100 truncate">
								{{ Str::limit($log->title, 60) }}
								<span>⏱ {{ $log->started_at->diff($log->ended_at)->format('%hч %iм') }}</span>
							</p>

							<p class="text-sm text-gray-300 mt-1 line-clamp-3" title="{{ $log->content }}">
								{{ Str::limit($log->content, 150) }}
							</p>

							<div class="flex items-center justify-between mt-2 text-xs text-gray-400">
								<span>
									<p class="log-time">{{ $log->ended_at }}</p>
								</span>
							</div>
						</div>
					@endforeach
				</div>

				<form method="POST" action="{{ route('logs.store') }}" class="grid grid-cols-2 gap-4">
					@csrf
					@method('POST')
					<div class="col-span-2 hidden">
						<input type="text" name="task_id" required
							   class="w-full px-3 py-2 rounded-lg bg-white/5 border border-white/10 focus:ring-2 focus:ring-blue-500 outline-none"
							   value="{{$task->id}}">
					</div>
					<div class="col-span-2">
						<label class="block text-sm font-medium text-gray-300 mb-1">Заголовок</label>
						<input type="text" name="title" required
							   class="w-full px-3 py-2 rounded-lg bg-white/5 border border-white/10 focus:ring-2 focus:ring-blue-500 outline-none">
					</div>

					<div class="col-span-2">
						<label class="block text-sm font-medium text-gray-300 mb-1">Контент</label>
						<textarea name="content" rows="3" required
								  class="w-full px-3 py-2 rounded-lg bg-white/5 border border-white/10 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
					</div>

					<div>
						<label class="block text-sm font-medium text-gray-300 mb-1">Начало</label>
						<input type="datetime-local" name="started_at"
							   class="w-full px-3 py-2 rounded-lg bg-white/5 border border-white/10 focus:ring-2 focus:ring-blue-500 outline-none">
					</div>

					<div>
						<label class="block text-sm font-medium text-gray-300 mb-1">Конец</label>
						<input type="datetime-local" name="ended_at"
							   class="w-full px-3 py-2 rounded-lg bg-white/5 border border-white/10 focus:ring-2 focus:ring-blue-500 outline-none">
					</div>

					<div class="col-span-2 flex justify-end">
						<button type="submit"
								class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 font-medium">
							Добавить запись
						</button>
					</div>
				</form>
			</div>

			<div class="bg-white/10 text-white rounded-2xl shadow-md p-6">
				<h2 class="text-xl font-semibold mb-3">Связанные задачи</h2>
				<ul class="space-y-2 text-gray-300 text-sm">
					<li>🔗 Родительская: — @if($task->parent)
							<a href="{{ route('tasks.show', $task->parent->id) }}">{{$task->parent->title}}</a>
						@else
							Нету родительской задачи
						@endif</li>
					<li>📎 Дочерние: —
						@if($task->subtasks->isNotEmpty())
							@foreach($task->subtasks as $subtask)
								<a href="{{ route('tasks.show', $subtask->id) }}">{{$subtask->title}}</a>
							@endforeach
						@else
							Нету дочерних задач
						@endif
					</li>
				</ul>
			</div>

			<div class="bg-white/10 text-white rounded-2xl shadow-md p-6 md:col-span-2 lg:col-span-3">
				<h2 class="text-xl font-semibold mb-3">Прогресс</h2>
				<div class="w-full bg-gray-700 rounded-full h-3 mb-3">
					@php
						$completed = $task->subtasks->where('status', 'Completed')->count();
						$total = $task->subtasks->count();

						$percent_ready = $total > 0 ? ($completed / $total) * 100 : 0;
					@endphp
					<div class="bg-green-500 h-3 rounded-full" style="width: {{ $percent_ready }}%"></div>
				</div>
				<p class="text-gray-300 text-sm">{{ $completed }} из {{ $total }} подзадач выполнено</p>
			</div>

			<div class="bg-white/10 text-white rounded-2xl shadow-md p-6 md:col-span-2 lg:col-span-3">
				<h2 class="text-xl font-semibold mb-3">Заметки</h2>
				<div class="space-y-2">
					@if($task->notes->isNotEmpty())
						@foreach($task->notes as $note)
							<p class="text-gray-300 text-sm">📝 {{$note->content}}</p>
						@endforeach
					@else
						<p class="text-gray-300 text-sm">У вас нет заметок по этой задаче</p>
					@endif
				</div>
				<form class="mt-3" method="POST" action="{{route('notes.store')}}">
					@csrf
					@method('POST')
					<div class="col-span-2 hidden">
						<input type="text" name="task_id" required
							   class="w-full px-3 py-2 rounded-lg bg-white/5 border border-white/10 focus:ring-2 focus:ring-blue-500 outline-none"
							   value="{{$task->id}}">
					</div>
					<textarea
							class="w-full rounded-xl bg-white/5 text-gray-200 p-3 text-sm border border-white/10 focus:outline-none focus:ring-2 focus:ring-blue-500"
							rows="3" placeholder="Добавить заметку..." name="content"></textarea>
					<button type="submit"
							class="mt-2 px-4 py-2 bg-blue-600 rounded-xl text-white text-sm hover:bg-blue-700">
						Добавить
					</button>
				</form>
			</div>

			<div class="bg-white/10 text-white rounded-2xl shadow-md p-6 md:col-span-2 lg:col-span-3">
				<h2 class="text-xl font-semibold mb-3">AI-помощник</h2>
				<div id="ai-report-box" class="text-gray-300 text-sm">💡 Ваш отчет прогружается</div>
			</div>
		</div>

	</div>
	<script>
		const taskId = {{ $task->id }};
		const aiReport = {!! json_encode($ai_report ?? false) !!};
		const formatReport = (html) => {
			let output = html;

			output = output.replace(/\*\*(.*?)\*\*/g, '<span class="font-semibold text-white">$1</span>');

			output = output.replace(/<h1>(.*?)<\/h1>/g, '<h2 class="text-xl font-bold mt-4 mb-2 text-white">$1</h2>');
			output = output.replace(/<h2>(.*?)<\/h2>/g, '<h3 class="text-lg font-semibold mt-3 mb-1 text-white">$1</h3>');

			output = output.replace(/<p>(.*?)<\/p>/g, '<p class="text-gray-300 leading-relaxed mb-2">$1</p>');

			return output;
		};

		const updateReportBox = (html) => {
			const box = document.querySelector('#ai-report-box');
			box.innerHTML = formatReport(html);
		};

		if (aiReport !== false) {
			updateReportBox(aiReport);
		}

		setTimeout(() => {
			window.Echo.channel('task.' + taskId)
				.listen('AiReportGeneratedEvent', (e) => {
					updateReportBox(e.text);
				});
		}, 200);

	</script>
</x-app-layout>
