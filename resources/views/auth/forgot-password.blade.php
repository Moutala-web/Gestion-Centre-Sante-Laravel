<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f8fafc]">
        
        <div class="w-full sm:max-w-md mt-6 px-10 py-12 bg-white shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1)] overflow-hidden sm:rounded-[3rem] border border-gray-100">
            
            <div class="mb-8 text-center">
                <x-application-logo />
                <h2 class="text-lg font-black text-slate-800 uppercase tracking-tighter mt-4">Récupération</h2>
                <p class="text-gray-400 font-medium text-[10px] uppercase tracking-widest mt-2 px-4">
                    {{ __('Indiquez votre email pour recevoir un lien de réinitialisation.') }}
                </p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-8">
                    <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 tracking-widest">Votre adresse Email</label>
                    <x-text-input id="email" class="block mt-1 w-full border-none bg-gray-50 rounded-2xl p-4 focus:ring-2 focus:ring-purple-500 shadow-inner" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex flex-col gap-4">
                    <x-primary-button class="w-full justify-center bg-purple-700 hover:bg-purple-900 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-[0.15em] shadow-lg shadow-purple-200 transition-all active:scale-95">
                        {{ __('Envoyer le lien') }}
                    </x-primary-button>

                    <a href="{{ route('login') }}" class="text-center text-xs font-bold text-gray-400 hover:text-purple-600 transition">
                        Retour à la connexion
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>