<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-blue-900 uppercase">🔍 Recherche Patient</h2>
            <a href="{{ route('dashboard') }}" class="text-xs font-bold text-blue-600 hover:underline">← Retour Dashboard</a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-blue-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-blue-50 mb-8">
                <form action="{{ route('medecin.recherche_patient') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Rechercher par nom ou numéro de téléphone..." 
                        class="w-full pl-14 pr-4 py-4 bg-gray-50 border-none rounded-2xl font-bold text-gray-700 focus:ring-2 focus:ring-blue-500 shadow-inner">
                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-2xl">🔍</span>
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 bg-blue-600 text-white px-6 py-2 rounded-xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition">
                        Chercher
                    </button>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if(isset($patients) && $patients->count() > 0)
                    @foreach($patients as $patient)
                        <div class="bg-white p-6 rounded-[2rem] shadow-lg border border-gray-100 hover:shadow-2xl transition-all group">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-xl mr-4 group-hover:scale-110 transition">
                                    👤
                                </div>
                                <div>
                                    <h4 class="font-black text-gray-800 uppercase text-sm">{{ $patient->name }}</h4>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Patient #{{ $patient->id }}</p>
                                </div>
                            </div>
                            
                            <div class="space-y-2 mb-6">
                                <div class="flex items-center text-xs font-medium text-gray-500">
                                    <span class="mr-2 text-blue-500">📞</span> {{ $patient->telephone ?? 'Non renseigné' }}
                                </div>
                                <div class="flex items-center text-xs font-medium text-gray-500">
                                    <span class="mr-2 text-blue-500">📧</span> {{ $patient->email }}
                                </div>
                            </div>

                            <a href="#" class="block w-full text-center bg-gray-50 text-blue-600 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-600 hover:text-white transition">
                                Voir Dossier Complet
                            </a>
                        </div>
                    @endforeach
                @elseif(request('search'))
                    <div class="col-span-full text-center py-20">
                        <span class="text-5xl block mb-4">😕</span>
                        <p class="text-gray-400 font-bold italic">Aucun patient trouvé pour "{{ request('search') }}"</p>
                    </div>
                @else
                    <div class="col-span-full text-center py-20 text-gray-300">
                        <p class="font-black uppercase tracking-[0.3em] text-sm">Entrez un nom pour commencer la recherche</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>