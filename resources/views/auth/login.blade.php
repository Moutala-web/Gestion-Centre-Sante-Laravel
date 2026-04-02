<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f8fafc]">
        
        <div class="w-full sm:max-w-md mt-6 px-10 py-12 bg-white shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1)] overflow-hidden sm:rounded-[3rem] border border-gray-100">
            
            <div class="mb-10 text-center">
                <x-application-logo />
                <p class="text-gray-400 font-medium text-sm mt-4 uppercase tracking-widest">Portail Médical sécurisé</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-6">
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 tracking-widest">Adresse Email</label>
                    <x-text-input id="email" class="block mt-1 w-full border-none bg-gray-50 rounded-2xl p-4 focus:ring-2 focus:ring-purple-500 shadow-inner" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 tracking-widest">Mot de passe</label>
                    <x-text-input id="password" class="block mt-1 w-full border-none bg-gray-50 rounded-2xl p-4 focus:ring-2 focus:ring-purple-500 shadow-inner" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="block mb-6">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded-md border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500" name="remember">
                        <span class="ms-2 text-sm text-gray-500 font-medium italic">{{ __('Se souvenir de moi') }}</span>
                    </label>
                </div>

                <div class="flex flex-col gap-4">
                    <x-primary-button class="w-full justify-center bg-purple-700 hover:bg-purple-900 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-lg shadow-purple-200 transition-all active:scale-95">
                        {{ __('Se connecter') }}
                    </x-primary-button>

                    @if (Route::has('password.request'))
                        <a class="text-center text-xs font-bold text-gray-400 hover:text-purple-600 transition" href="{{ route('password.request') }}">
                            {{ __('Mot de passe oublié ?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <p class="mt-8 text-gray-400 text-sm font-medium">
            Pas encore de compte ? 
            <a href="{{ route('register') }}" class="text-purple-600 font-black uppercase tracking-tighter hover:underline">Créer un profil</a>
        </p>
    </div>
</x-guest-layout>