<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen px-4 text-white bg-black">

        <!-- Card Register -->
        <div class="w-full max-w-md p-8 bg-gray-800 rounded-lg shadow-lg">
            <h2 class="mb-4 text-2xl font-semibold text-center text-gray-100">
                Daftar di <span class="text-yellow-300">CodePersona</span> 🚀
            </h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
                    <x-text-input id="name" class="block w-full mt-1 text-white bg-gray-700 border-gray-600 focus:ring-yellow-400 focus:border-yellow-400"
                                  type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <x-text-input id="email" class="block w-full mt-1 text-white bg-gray-700 border-gray-600 focus:ring-yellow-400 focus:border-yellow-400"
                                  type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                    <x-text-input id="password" class="block w-full mt-1 text-white bg-gray-700 border-gray-600 focus:ring-yellow-400 focus:border-yellow-400"
                                  type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm Password</label>
                    <x-text-input id="password_confirmation" class="block w-full mt-1 text-white bg-gray-700 border-gray-600 focus:ring-yellow-400 focus:border-yellow-400"
                                  type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a class="text-sm text-yellow-400 hover:text-yellow-300" href="{{ route('login') }}">
                        Already registered?
                    </a>

                    <x-primary-button class="px-4 py-2 text-black bg-yellow-400 rounded-lg hover:bg-yellow-500">
                        Register
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
