<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nome e Cognome (o Nome Azienda)')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Conferma Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- SELEZIONE RUOLO (VERSIONE INFALLIBILE CON ALPINE.JS) -->
        <div x-data="{ role: 'candidate' }" class="mt-6">
            <x-input-label for="role" :value="__('Chi sei? (Obbligatorio)')" />
            <div class="mt-2 grid grid-cols-1 gap-4 sm:grid-cols-2">

                <!-- OPZIONE 1: CANDIDATO -->
                <label class="relative cursor-pointer block">
                    <input type="radio" name="role" value="candidate" class="sr-only" x-model="role" required>
                    <div :class="role === 'candidate' ? 'border-blue-600 bg-blue-50' : 'border-gray-200 hover:bg-gray-50'" class="rounded-lg border-2 p-4 transition-all duration-200 h-full">
                        <div class="flex items-center">
                            <!-- Icona Utente SVG -->
                            <svg :class="role === 'candidate' ? 'text-blue-600' : 'text-gray-400'" class="w-8 h-8 mr-3 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <div>
                                <p :class="role === 'candidate' ? 'text-blue-700' : 'text-gray-900'" class="font-bold transition-colors">Candidato</p>
                                <p class="text-xs text-gray-500">Cerco lavoro (Cuoco, Cameriere, ecc.)</p>
                            </div>
                        </div>
                        <!-- Spunta SVG (appare solo se selezionato) -->
                        <div x-show="role === 'candidate'" class="absolute top-3 right-3 text-blue-600 transition-opacity duration-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                </label>

                <!-- OPZIONE 2: AZIENDA -->
                <label class="relative cursor-pointer block">
                    <input type="radio" name="role" value="employer" class="sr-only" x-model="role" required>
                    <div :class="role === 'employer' ? 'border-orange-500 bg-orange-50' : 'border-gray-200 hover:bg-gray-50'" class="rounded-lg border-2 p-4 transition-all duration-200 h-full">
                        <div class="flex items-center">
                            <!-- Icona Hotel SVG -->
                            <svg :class="role === 'employer' ? 'text-orange-500' : 'text-gray-400'" class="w-8 h-8 mr-3 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <div>
                                <p :class="role === 'employer' ? 'text-orange-700' : 'text-gray-900'" class="font-bold transition-colors">Azienda</p>
                                <p class="text-xs text-gray-500">Cerco personale (Albergatore, Ristoratore)</p>
                            </div>
                        </div>
                        <!-- Spunta SVG (appare solo se selezionato) -->
                        <div x-show="role === 'employer'" class="absolute top-3 right-3 text-orange-500 transition-opacity duration-200">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                </label>

            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>
        <!-- FINE SELEZIONE RUOLO -->

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Sei già registrato?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrati') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>