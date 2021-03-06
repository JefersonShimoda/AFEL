<x-guest-layout>

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

    <div class="organizar">
        <div id="background"></div>

        <x-jet-authentication-card>
            <x-slot name="logo">
                <x-jet-authentication-card-logo />
            </x-slot>

            <p class="text-md text-center mb-4">A AFEL foi idealizada em 2016, quando um grupo de mães lutando pelos
                direitos básicos de seus filhos com deficiência decidiu criar uma Associação. Hoje a AFEL dá suporte a
                diversas famílias lutando pela inclusão em todos os âmbitos, realizando trabalhos socioeducativos e
                cuidando de quem cuida.
            </p>

            <x-jet-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                        required autofocus />
                </div>

                <div class="mt-4">
                    <x-jet-label for="password" value="{{ __('Password') }}" />
                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="current-password" />
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-jet-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                    <a class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none disabled:opacity-25 transition ease-in-out duration-150 bg-[#f29200] hover:bg-[#e58a00] focus:bg-[#e58a00] focus:border-[#e58a00] active:bg-[#e58a00] active:border-[#e58a00] ml-3 bg-[#c0c0c0] hover:bg-[#b0b0b0] focus:bg-[#b0b0b0] focus:border-[#c0c0c0] active:bg-[#b0b0b0] active:border-[#b0b0b0]"
                        href="/register">Registrar-se</a>
                    <x-jet-button class="ml-2">
                        {{ __('Log in') }}
                    </x-jet-button>
                </div>
            </form>
        </x-jet-authentication-card>
    </div>
</x-guest-layout>
