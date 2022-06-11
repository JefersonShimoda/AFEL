<x-jet-form-section submit="updateProfileInformation">

    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{ photoName: null, photoPreview: null }" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden" wire:model="photo" x-ref="photo" x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-jet-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                        class="rounded-full h-20 w-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                        x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                    {{ __('Select A New Photo') }}
                </x-jet-secondary-button>

                @if ($this->user->profile_photo_path)
                    <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        {{ __('Remove Photo') }}
                    </x-jet-secondary-button>
                @endif

                <x-jet-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name"
                autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && !$this->user->hasVerifiedEmail())
                <p class="text-sm mt-2">
                    {{ __('Seu endereço de e-mail não foi verificado.') }}

                    <button type="button" class="underline text-sm text-gray-600 hover:text-gray-900"
                        wire:click.prevent="sendEmailVerification">
                        {{ __('Clique aqui para reenviar o e-mail de verificação.') }}
                    </button>
                </p>

                @if ($this->verificationLinkSent)
                    <p v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        {{ __('Um novo link de verificação foi enviado para seu endereço de e-mail.') }}
                    </p>
                @endif
            @endif
        </div>

        {{-- Tipo --}}
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="tipo" :value="__('Perfil')" />
            <select id="tipo" wire:model.defer="state.tipo" autocomplete="tipo" disabled
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                <option value=""></option>
                <option value="associado">Associado</option>
                <option value="colaborador">Colaborador</option>
                <option value="gestor">Gestor</option>
            </select>
        </div>

        {{-- Sexo --}}
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="sexo" :value="__('Sexo')" />
            <select id="sexo" wire:model.defer="state.sexo" autocomplete="sexo" disabled
                class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                <option value=""></option>
                <option value="feminino">Feminino</option>
                <option value="masculino">Masculino</option>
            </select>
        </div>

        {{-- CPF --}}
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="cpf" value="{{ __('CPF') }}" />
            <x-jet-input id="cpf" type="text" class="mt-1 block w-full disabled:opacity-70" wire:model.defer="state.cpf"
                autocomplete="cpf" disabled />
        </div>

        {{-- Contato --}}
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="telefone" value="{{ __('Contato') }}" />
            <x-jet-input id="telefone" type="text" class="phone mt-1 block w-full" wire:model.defer="state.telefone"
                autocomplete="telefone" />
            <x-jet-input-error for="telefone" class="mt-2" />
        </div>

        {{-- CEP --}}
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="cep" value="{{ __('CEP') }}" />
            <x-jet-input id="cep" type="text" class="cep mt-1 block w-full" wire:model.defer="state.cep"
                autocomplete="cep" />
            <x-jet-input-error for="cep" class="mt-2" />
        </div>

        @if (Auth::user()->tipo == 'associado')
            {{-- CID --}}
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="cid" value="{{ __('CID') }}" />
                <x-jet-input id="cid" type="text" class="mt-1 block w-full" wire:model.defer="state.cid"
                    autocomplete="cid" />
                <x-jet-input-error for="cid" class="mt-2" />
            </div>

            {{-- Observação --}}
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="obs" value="{{ __('Observação') }}" />
                <textarea id="cid" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"
                    wire:model.defer="state.obs" autocomplete="obs"></textarea>
                <x-jet-input-error for="cep" class="mt-2" />
            </div>

            {{-- Data de Nascimento --}}
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="nascimento" value="{{ __('Data de Nascimento') }}" />
                <x-jet-input id="nascimento" type="text" class="mt-1 block w-full disabled:opacity-70"
                    wire:model.defer="state.nascimento" autocomplete="nascimento" disabled />
            </div>

            {{-- Escola --}}
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="escola" :value="__('Escola')" />
                <select id="escola" wire:model.defer="state.escola" autocomplete="escola"
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                    <option value="nfescola">Não frequenta escola</option>
                    <option value="especial">Escola Especial</option>
                    <option value="publica">Escola Pública</option>
                    <option value="particular">Escola Particular</option>
                </select>
            </div>
        @endif
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Salvo.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
