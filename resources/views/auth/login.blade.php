<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6 p-4 rounded-lg bg-green-50 text-green-800 border border-green-200" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- NIP -->
        <div>
            <x-input-label for="nip" :value="__('NIP')" class="block text-sm font-medium text-gray-700" />
            <x-text-input id="nip" class="block mt-1 w-full input-field py-3 px-4 rounded-lg" 
            type="text" name="nip" :value="old('nip')" required autofocus autocomplete="nip" />
            <x-input-error :messages="$errors->get('nip')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700" />
            <x-text-input id="password" class="block mt-1 w-full input-field py-3 px-4 rounded-lg"
            type="password"
            name="password"
            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="remember-me rounded border-gray-300 shadow-sm focus:ring-primary" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

            <button type="submit" class="btn-primary py-3 px-6 rounded-lg font-medium">
                {{ __('Log in') }} <i class="fas fa-arrow-right ml-2"></i>
            </button>
        </form>
</x-guest-layout>