<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen px-4 text-white bg-black">

        <!-- Card Login -->
        <div class="w-full max-w-md p-8 bg-gray-800 rounded-lg shadow-lg">
            <h2 class="flex items-center justify-center mb-4 space-x-2 text-2xl font-semibold text-center text-gray-100">
                <span>Masuk ke</span> <span class="text-yellow-300">CodePersona</span> 🚀
            </h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mt-4">
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <x-text-input id="email" class="block w-full mt-1 text-white bg-gray-700 border-gray-600 focus:ring-yellow-400 focus:border-yellow-400"
                                  type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                    <x-text-input id="password" class="block w-full mt-1 text-white bg-gray-700 border-gray-600 focus:ring-yellow-400 focus:border-yellow-400"
                                  type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="flex items-center text-sm text-gray-300">
                        <input id="remember_me" type="checkbox" class="text-yellow-400 bg-gray-700 border-gray-600 rounded focus:ring-yellow-400" name="remember">
                        <span class="ml-2">Remember me</span>
                    </label>


                </div>

                <div class="flex justify-center mt-6">
                    <x-primary-button class="flex items-center justify-center w-full px-4 py-2 text-black bg-yellow-400 rounded-lg hover:bg-yellow-500">
                        LOG IN
                    </x-primary-button>
                </div>

            </form>
        </div>
    </div>
</x-guest-layout>
