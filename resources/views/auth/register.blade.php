<x-guest-layout>

    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <script src="{{ asset('js/register.js') }}" defer></script>

    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <ul id="div-errors" class="ml-3 mb-4 text-sm text-red-600 hidden list-disc"></ul>

        <form method="POST" id="form-register" action="{{ route('register') }}">
            @csrf
            <div id="tela1">
                <div>
                    <x-jet-label for="name" value="{{ __('Nome') }}" />
                    <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                        autofocus autocomplete="name" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')"
                         />
                </div>

                <div class="mt-4">
                    <x-jet-label for="password" value="{{ __('Senha') }}" />
                    <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password"
                        autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="password_confirmation" value="{{ __('Confirmar Senha') }}" />
                    <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation"  autocomplete="new-password" />
                </div>
                <div class="mt-4">
                    <x-jet-label for="tipo" :value="__('Selecione o seu perfil')" />
                    <select name="tipo" id="tipo"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                        <option value=""></option>
                        <option value="associado">Associado</option>
                        <option value="colaborador">Colaborador</option>
                        <option value="gestor">Gestor</option>
                    </select>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        {{ __('Já possui registro?') }}
                    </a>
                    <x-jet-button class="ml-3" id="btn_tela1" type="button">
                        {{ __('Avançar') }}
                    </x-jet-button>
                </div>
            </div>
            <div id="tela2" class="hidden">
                {{-- sexo --}}
                <div class="mt-4">
                    <x-jet-label for="sexo" :value="__('Sexo')" />
                    <select name="sexo" id="sexo"
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                        <option value=""></option>
                        <option value="feminino">Feminino</option>
                        <option value="masculino">Masculino</option>
                    </select>
                </div>

                {{-- CPF --}}
                <div class="mt-4">
                    <x-jet-label for="cpf" :value="__('CPF')" />

                    <x-jet-input id="cpf" class="block mt-1 w-full cpf" type="text" name="cpf" :value="old('cpf')" />
                </div>

                {{-- telefone --}}
                <div class="mt-4">
                    <x-jet-label for="telefone" :value="__('Contato')" />

                    <x-jet-input id="telefone" class="block mt-1 w-full phone" type="text" name="telefone"
                        :value="old('telefone')" placeholder="(00) 00000-0000" />
                </div>

                {{-- cep --}}
                <div class="mt-4">
                    <x-jet-label for="cep" :value="__('CEP')" />

                    <x-jet-input id="cep" class="block mt-1 w-full cep" type="text" name="cep" :value="old('cep')" />
                </div>

                <div id="form-associado" class="hidden">
                    {{-- CID --}}
                    <div class="mt-4">
                        <x-jet-label for="cid" :value="__('CID')" />

                        <x-jet-input id="cid" class="block mt-1 w-full " type="text" name="cid" :value="old('cid')"
                            placeholder="A00" />
                    </div>

                    {{-- observação --}}
                    <div class="mt-4">
                        <x-jet-label for="obs" :value="__('Observação: ')" />

                        <x-jet-input id="obs" class="block mt-1 w-full " type="text" name="obs" :value="old('obs')" />
                    </div>

                    {{-- data de nascimento --}}
                    <div class="mt-4">
                        <x-jet-label for="nascimento" :value="__('Data de Nascimento')" />

                        <x-jet-input id="nascimento" class="block mt-1 w-full date" type="text" name="nascimento"
                            :value="old('nascimento')" placeholder="DD/MM/AAAA" />
                    </div>

                    {{-- escola --}}
                    <div class="mt-4 ">
                        <x-jet-label for="escola" :value="__('Escola')" />
                        <select name="escola" id="escola"
                            class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                            <option value="nfescola">Não frequenta escola</option>
                            <option value="especial">Escola Especial</option>
                            <option value="publica">Escola Pública</option>
                            <option value="particular">Escola Particular</option>
                        </select>
                    </div>
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-jet-label for="terms">
                            <div class="flex items-center">
                                <x-jet-checkbox name="terms" id="terms" />

                                <div class="ml-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
    'terms_of_service' => '<a target="_blank" href="' . route('terms.show') . '" class="underline text-sm text-gray-600 hover:text-gray-900">' . __('Terms of Service') . '</a>',
    'privacy_policy' => '<a target="_blank" href="' . route('policy.show') . '" class="underline text-sm text-gray-600 hover:text-gray-900">' . __('Privacy Policy') . '</a>',
]) !!}
                                </div>
                            </div>
                        </x-jet-label>
                    </div>
                @endif

                <div class="flex items-center justify-end mt-4">
                    <x-jet-button
                        class="ml-3 bg-[#c0c0c0] hover:bg-[#b0b0b0] focus:bg-[#b0b0b0] focus:border-[#c0c0c0] active:bg-[#b0b0b0] active:border-[#b0b0b0]"
                        type="button" id="btn_tela2">
                        {{ __('Voltar') }}
                    </x-jet-button>

                    <x-jet-button class="ml-2">
                        {{ __('Registrar') }}
                    </x-jet-button>

                </div>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
