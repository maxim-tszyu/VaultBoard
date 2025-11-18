<x-app-layout>
	<div class="max-w-7xl mx-auto p-6 space-y-8">

		<div class="flex items-center justify-between mb-4">
			<h1 class="text-2xl font-bold text-white">Мои финансовые цели</h1>

			<a href="{{ route('goals.create') }}"
			   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
				+ Новая цель
			</a>
		</div>

		@if($goals->isEmpty())
			<div class="bg-white/10 p-6 rounded-2xl text-center text-gray-300">
				У вас пока нет целей. Создайте первую, чтобы начать отслеживать прогресс 💡
			</div>
		@else
			<div class="flex gap-3 overflow-x-auto pb-2">
				@foreach($goals as $goal)
					<a href="{{ route('finances.index', ['goal' => $goal->id]) }}"
					   class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap
                              transition
                              {{ $activeGoal && $activeGoal->id === $goal->id
                                  ? 'bg-indigo-600 text-white shadow'
                                  : 'bg-white/10 text-gray-300 hover:bg-white/20 hover:text-white' }}">
						{{ $goal->title }}
					</a>
				@endforeach
			</div>


			<div class="bg-white/10 rounded-2xl p-8 shadow-lg text-white relative mt-4">
				<div class="flex justify-between items-start mb-6">
					<div>
						<h2 class="text-2xl font-semibold">{{ $activeGoal->title }}</h2>
						<p class="text-gray-300 mt-1 max-w-2xl">{{ $activeGoal->content }}</p>
					</div>
					<a href="{{ route('goals.show', $activeGoal) }}"
					   class="text-sm bg-white/20 hover:bg-white/30 px-3 py-1 rounded-lg">
						Подробнее →
					</a>
				</div>

				@php
					$progress = min(100, round(($activeGoal->current_amount ?? 0) / $activeGoal->amount * 100, 1));
				@endphp

						<div class="w-full bg-white/20 rounded-full h-3 mb-2">
					<div class="bg-green-400 h-3 rounded-full transition-all duration-500"
						 style="width: {{ $progress }}%"></div>
				</div>
				<div class="flex justify-between text-sm text-gray-300">
					<span>Собрано: {{ number_format($activeGoal->current_amount ?? 0, 0, '.', ' ') }}₸</span>
					<span>Цель: {{ number_format($activeGoal->amount, 0, '.', ' ') }}₸</span>
				</div>
			</div>
		@endif
		<div class="grid gap-6 mt-6" style="grid-template-columns: 20fr 10fr;">

			<section class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm flex flex-col">
				<h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">История финансов</h2>

				<div class="overfow-y-auto max-h-[400px] space-y-3">
					@forelse ($finances as $t)
						<div class="flex justify-between items-center bg-gray-100 dark:bg-gray-800 rounded-lg p-3">
							<div>
								<p class="font-medium">{{ $t->title }}</p>
								<p class="text-sm text-gray-500">{{ $t->content }}</p>
							</div>
							<span class="{{ $t->type === 'income' ? 'text-green-500' : 'text-red-500' }}">
						{{ $t->amount }} ₸
					</span>
						</div>
					@empty
						<div class="bg-white/10 p-6 rounded-2xl text-center text-gray-300">
							У вас пока нет записей. Создайте первую, чтобы начать отслеживать прогресс 💡
						</div>
					@endforelse
				</div>
			</section>

			<section class="flex flex-col gap-6">
				<div
						x-data="{ type: 'income' }"
						:class="type === 'income'
		? 'bg-green-50/40 dark:bg-green-900/30'
		: 'bg-red-50/40 dark:bg-red-900/30'"
						class="p-5 rounded-2xl border border-white/10 transition-colors duration-300"
				>
					<div class="flex mb-3 rounded-lg overflow-hidden border border-gray-300/30 dark:border-gray-700/50">
						<button type="button"
								@click="type = 'income'"
								:class="type === 'income'
				? 'bg-green-600 text-white'
				: 'bg-gray-200 dark:bg-gray-800 text-gray-500 dark:text-gray-400'"
								class="flex-1 py-1.5 text-sm font-medium transition">
							Доход
						</button>
						<button type="button"
								@click="type = 'expense'"
								:class="type === 'expense'
				? 'bg-red-600 text-white'
				: 'bg-gray-200 dark:bg-gray-800 text-gray-500 dark:text-gray-400'"
								class="flex-1 py-1.5 text-sm font-medium transition">
							Расход
						</button>
					</div>

					<form action="{{ route('finances.store') }}" method="POST" class="space-y-3">
						@csrf
						<input type="hidden" name="type" :value="type">

						<div>
							<label class="block text-xs font-medium text-gray-600 dark:text-gray-400">Сумма</label>
							<input type="number" name="amount" step="0.01"
								   class="w-full mt-1 border border-gray-300/30 dark:border-gray-700/50
					   rounded-lg p-2 text-sm bg-gray-50 dark:bg-gray-800 dark:text-gray-100
					   focus:ring-1 focus:ring-green-500 focus:border-green-500 transition"
								   required>
						</div>

						<div>
							<label class="block text-xs font-medium text-gray-600 dark:text-gray-400">Название</label>
							<input type="text" name="title"
								   class="w-full mt-1 border border-gray-300/30 dark:border-gray-700/50
					   rounded-lg p-2 text-sm bg-gray-50 dark:bg-gray-800 dark:text-gray-100
					   focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition"
								   required>
						</div>

						<div>
							<label class="block text-xs font-medium text-gray-600 dark:text-gray-400">Описание</label>
							<textarea name="description" rows="2"
									  class="w-full mt-1 border border-gray-300/30 dark:border-gray-700/50
					   rounded-lg p-2 text-sm bg-gray-50 dark:bg-gray-800 dark:text-gray-100
					   focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition"
									  placeholder="Необязательно"></textarea>
						</div>

						<button type="submit"
								:class="type === 'income'
				? 'bg-green-600 hover:bg-green-700 focus:ring-green-500'
				: 'bg-red-600 hover:bg-red-700 focus:ring-red-500'"
								class="w-full text-white text-sm font-medium py-2 rounded-lg focus:outline-none focus:ring-1 transition">
							<span x-text="type === 'income' ? 'Добавить доход' : 'Добавить расход'"></span>
						</button>
					</form>
				</div>


				<div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6 rounded-2xl shadow-lg">
					<h3 class="text-lg font-semibold mb-2">Совет от AI</h3>
					<p class="text-sm opacity-90">
						Попробуй ограничить расходы на развлечения в этом месяце — это улучшит твоё соотношение доходов
						и расходов на 15%.
					</p>
				</div>
			</section>

		</div>

	</div>
</x-app-layout>
