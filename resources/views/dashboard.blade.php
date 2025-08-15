<x-app-layout>
		<h3 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-200">Все задачи</h3>

		<div class="flex gap-4 overflow-x-auto pb-2 mt-4">
			@foreach(range(1,10) as $i)
				<div class="min-w-[400px] p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
					<div class="max-w-sm rounded overflow-hidden shadow-lg">
						<div class="px-6 py-4">
							<div class="font-bold text-xl mb-2">The Coldest Sunset</div>
							<p class="text-gray-700 text-base">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla!
								Maiores et perferendis eaque, exercitationem praesentium nihil.
							</p>
						</div>
						<div class="px-6 pt-4 pb-2">
							<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#photography</span>
							<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#travel</span>
							<span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#winter</span>
						</div>
					</div>
				</div>
			@endforeach
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
			<section>
				<h3 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-200">Приоритетные задачи</h3>
				<div class="space-y-2">
					@foreach(range(1,3) as $i)
						<div class="p-3 bg-white dark:bg-gray-800 rounded-lg">
							<p class="font-medium">Приоритет #{{ $i }}</p>
						</div>
					@endforeach
				</div>
			</section>

			<section>
				<h3 class="text-lg font-bold mb-2 text-gray-800 dark:text-gray-200">🔥 Горящие задачи</h3>
				<div class="space-y-2">
					@foreach(range(1,3) as $i)
						<div class="p-3 bg-white dark:bg-gray-800 rounded-lg">
							<p class="font-medium">Дедлайн скоро: #{{ $i }}</p>
						</div>
					@endforeach
				</div>
			</section>
		</div>

		<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
			<section class="p-5 bg-white dark:bg-gray-800 rounded-lg shadow grid grid-cols-2 gap-4">
				<div>
					<h3 class="text-lg font-bold mb-2">Income</h3>
					<p class="text-2xl font-semibold">₸ 125 000</p>
				</div>
				<div class="flex flex-col items-end text-right">
					<h3 class="text-lg font-bold mb-2">Outcome</h3>
					<p class="text-2xl font-semibold">₸ 125 000</p>
				</div>
				<div class="col-span-2 items-center text-center">
					<h3 class="text-lg font-bold mb-2">Progress to your goal</h3>
					<p class="text-xl font-semibold">+XXX</p>
					<p class="text-xs font-semibold">remaining:xxx</p>
				</div>
			</section>

			<section class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
				<h3 class="text-lg font-bold mb-2">Прогресс</h3>
				<div class="h-40 flex items-center justify-center text-gray-400">
					Chart placeholder
				</div>
			</section>

			<section class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
				<h3 class="text-lg font-bold mb-2">Оценка от AI</h3>
				<p class="text-gray-600 dark:text-gray-300">
					Ты выполнил 70% задач за эту неделю. Предлагаю сосредоточиться на горящих задачах.
				</p>
			</section>
		</div>
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
			<section class="p-5 bg-white dark:bg-gray-800 rounded-lg shadow grid grid-cols-2 gap-4">
				<div>
					<h3 class="text-lg font-bold mb-2">Your recent entries</h3>
					<p class="text-2xl font-semibold">₸ 125 000</p>
				</div>
				<div class="flex flex-col items-end text-right">
					<h3 class="text-lg font-bold mb-2">Outcome</h3>
					<p class="text-2xl font-semibold">₸ 125 000</p>
				</div>
				<div class="col-span-2 items-center text-center">
					<h3 class="text-lg font-bold mb-2">Progress to your goal</h3>
					<p class="text-xl font-semibold">+XXX</p>
					<p class="text-xs font-semibold">remaining:xxx</p>
				</div>
			</section>

			<section class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
				<h3 class="text-lg font-bold mb-2">Your latest report</h3>
				<div class="h-40 flex items-center justify-center text-gray-400">
					report
				</div>
			</section>
		</div>

</x-app-layout>
