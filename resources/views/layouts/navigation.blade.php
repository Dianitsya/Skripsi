<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block w-auto text-gray-800 fill-current h-9 dark:text-gray-200" />
                    </a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @can('admin')
                    <x-nav-link :href="route('user.index')" :active="request()->routeIs('user.index')">
                        {{ __('User') }}
                    </x-nav-link>
                    <x-nav-link :href="route('category.index')" :active="request()->routeIs('category.index*')">
                        {{ __('Category') }}
                    </x-nav-link>
                    <x-nav-link :href="route('module.index')" :active="request()->routeIs('module.index*')">
                        {{ __('Module') }}
                    </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Notifikasi & Profile dalam satu flex container -->
            <div class="flex items-center space-x-4">
                <!-- Notifikasi -->
                <div x-data="notificationBell()" class="relative">
                    <button @click="open = !open" class="relative p-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
                        🔔
                        <span class="absolute top-0 right-0 px-1 text-xs text-white bg-red-600 rounded-full" x-show="count > 0" x-text="count"></span>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 bg-white border rounded-lg shadow-lg dark:bg-gray-700 w-60">
                        <div class="p-3 text-sm text-gray-800 dark:text-gray-200" x-show="notifications.length === 0">Tidak ada notifikasi baru</div>
                        <template x-for="notif in notifications">
                            <a :href="notif.url" class="block px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <p class="text-sm font-semibold" x-text="notif.title"></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400" x-text="notif.time"></p>
                            </a>
                        </template>
                    </div>
                </div>

                <!-- Dropdown Profile -->
                <div>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('notificationBell', () => ({
        open: false,
        count: 0,
        notifications: [],

        async fetchNotifications() {
            try {
                let response = await fetch('/api/notifications');
                let data = await response.json();
                console.log(data);  // Log the response data here
                this.notifications = data.notifications;
                this.count = this.notifications.length;
            } catch (error) {
                console.error("Gagal mengambil notifikasi:", error);
            }
        },

        init() {
            this.fetchNotifications();
            setInterval(() => this.fetchNotifications(), 30000); // Refresh notifications every 30 seconds
        }
    }));
});
</script>
