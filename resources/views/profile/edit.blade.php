<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-purple-800 uppercase tracking-widest">
                ⚙️ Paramètres du compte
            </h2>
            <a href="{{ route('dashboard') }}" class="text-xs font-bold text-purple-600 hover:underline uppercase tracking-widest">
                ← Retour au Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
                
                <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-purple-100">
                    <div class="flex items-center mb-6 space-x-4">
                        <div class="p-3 bg-orange-500 rounded-2xl shadow-lg shadow-orange-100 text-white text-xl">
                            🔐
                        </div>
                        <h3 class="font-black text-gray-800 uppercase tracking-tighter">Sécurité & Accès</h3>
                    </div>
                    <div class="px-2">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="bg-white p-8 rounded-[2rem] shadow-xl border border-purple-100">
                    <div class="flex items-center mb-6 space-x-4">
                        <div class="p-3 bg-purple-600 rounded-2xl shadow-lg shadow-purple-100 text-white text-xl">
                            👤
                        </div>
                        <h3 class="font-black text-gray-800 uppercase tracking-tighter">Mon Profil Personnel</h3>
                    </div>
                    <div class="px-2">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

            </div>

            <div class="p-8 bg-red-50/50 rounded-[2rem] border border-red-100 shadow-sm">
                <div class="max-w-xl">
                    <h3 class="text-red-600 font-black uppercase text-xs tracking-widest mb-4">Zone de danger</h3>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>