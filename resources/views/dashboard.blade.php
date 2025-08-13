<x-app-layout>
	<div class="p-6 space-y-6">
		<h3 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-200">Все задачи</h3>

		<div>
			<div class="flex gap-4 overflow-x-auto pb-2">
				@foreach(range(1,10) as $i)
					<div class="min-w-[200px] p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
						<p class="font-semibold">Задача {{ $i }}</p>
						<p class="text-sm text-gray-500">Описание...</p>
					</div>
				@endforeach
			</div>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
			<section>
				<h3 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-200">Приоритетные задачи</h3>
				<div class="space-y-2">
					@foreach(range(1,4) as $i)
						<div class="p-3 bg-yellow-100 dark:bg-yellow-800 rounded-lg">
							<p class="font-medium">Приоритет #{{ $i }}</p>
						</div>
					@endforeach
				</div>
			</section>

			<section>
				<h3 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-200">🔥 Горящие задачи</h3>
				<div class="space-y-2">
					@foreach(range(1,3) as $i)
						<div class="p-3 bg-red-100 dark:bg-red-800 rounded-lg">
							<p class="font-medium">Дедлайн скоро: #{{ $i }}</p>
						</div>
					@endforeach
				</div>
			</section>
		</div>

		{{-- Финансы, Чарт, AI --}}
		<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
			{{-- Финансы --}}
			<section class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
				<h3 class="text-lg font-bold mb-2">Финансы</h3>
				<p class="text-2xl font-semibold">₸ 125 000</p>
				<p class="text-sm text-gray-500">Текущий баланс</p>
			</section>

			{{-- Чарт --}}
			<section class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
				<h3 class="text-lg font-bold mb-2">Прогресс</h3>
				<div class="h-40 flex items-center justify-center text-gray-400">
					Chart placeholder
				</div>
			</section>

			{{-- AI-оценка --}}
			<section class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
				<h3 class="text-lg font-bold mb-2">Оценка от AI</h3>
				<p class="text-gray-600 dark:text-gray-300">
					Ты выполнил 70% задач за эту неделю. Предлагаю сосредоточиться на горящих задачах.
				</p>
			</section>
		</div>

	</div>
</x-app-layout>
