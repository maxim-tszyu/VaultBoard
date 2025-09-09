<div class="mx-auto w-full bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700" >
	<nav>
		<div class="max-w-7xl mx-auto ">
			<div class="flex justify-between h-16">
				<div class="flex items-center">
					<button @click="$dispatch('toggle-sidebar')"
							class="sm:hidden p-2 text-gray-500 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">
						<svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
						</svg>
					</button>


					<div class="hidden sm:flex sm:space-x-6">
						@foreach ([
							['route' => 'dashboard', 'label' => 'Dashboard', 'active_route' => 'dashboard'],
							['route' => 'tasks.index', 'label' => 'Tasks', 'active_route' => 'tasks.*'],
							['route' => 'notes.index', 'label' => 'Notes', 'active_route' => 'notes.*'],
							['route' => 'finances.index', 'label' => 'Finances', 'active_route' => 'finances.*'],
							['route' => 'entries.index', 'label' => 'Entries', 'active_route' => 'entries.*'],
						] as $link)
							<x-nav-link :href="route($link['route'])" :active="request()->routeIs($link['active_route'])">
								{{ __($link['label']) }}
							</x-nav-link>
						@endforeach
					</div>
				</div>

				<div class="flex items-center">
					<x-dropdown align="right" width="48">
						<x-slot name="trigger">
							<button class="flex items-center text-sm rounded-md px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 mr-4">
								<span class="mr-2">Hello, {{ Auth::user()->name }}</span>
								<svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd"
										  d="M5.3 7.3a1 1 0 011.4 0L10 10.6l3.3-3.3a1 1 0 111.4 1.4l-4 4a1 1 0 01-1.4 0l-4-4a1 1 0 010-1.4z"
										  clip-rule="evenodd"/>
								</svg>
							</button>
						</x-slot>
						<x-slot name="content">
							<x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
							<x-dropdown-link :href="route('analysis',1)">{{ __('Analysis') }}</x-dropdown-link>
							<x-dropdown-link :href="route('report')">{{ __('Report') }}</x-dropdown-link>
							<form method="POST" action="{{ route('logout') }}">
								@csrf
								<x-dropdown-link :href="route('logout')"
												 onclick="event.preventDefault(); this.closest('form').submit();">
									{{ __('Log Out') }}
								</x-dropdown-link>
							</form>
						</x-slot>
					</x-dropdown>
				</div>
			</div>
		</div>
	</nav>
</div>