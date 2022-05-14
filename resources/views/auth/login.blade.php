<x-guest-layout>
    <x-auth-card>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('El. paštas')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Slaptažodis')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>
                <input id="time_zone" class="block mt-1 w-full"
                         type="hidden"
                         name="time_zone"
                         value="{{ \Cookie::get("user_timezone", "Europe/London") }}" />

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Prisiminti mane') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <br>
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Užmiršote slaptažodį?') }}
                    </a>
                @endif<br>
                <a class="underline blue text-sm " style="color: #0f65ef!important;" href="/register">
                    {{ __('Registracija naujiems nariams') }}
                </a>

                <x-button class="ml-3">
                    {{ __('Prisijungti') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
