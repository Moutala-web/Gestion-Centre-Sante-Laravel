<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[2rem] p-8 mb-8 shadow-xl border-l-8 border-purple-600 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-black text-purple-900 uppercase tracking-tighter">Espace Secrétariat</h2>
                    <p class="text-gray-500 font-medium mt-1">
                        Gestion du service : <span class="text-purple-600 font-bold">{{ Auth::user()->service->nom ?? 'Général' }}</span>
                    </p>
                </div>
                <div class="text-4xl opacity-20">🏢</div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100">
                <div class="p-8 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-black text-gray-800 uppercase text-sm tracking-widest">Suivi des Rendez-vous</h3>
                    <span class="bg-purple-100 text-purple-600 px-4 py-1 rounded-full text-xs font-black uppercase">
                        {{ $demandes->count() }} Dossiers au total
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] bg-white">
                                <th class="px-8 py-4">Patient</th>
                                <th class="py-4">Médecin sollicité</th>
                                <th class="py-4">Date & Heure</th>
                                <th class="py-4">Statut</th>
                                <th class="px-8 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($demandes as $demande)
                            <tr class="hover:bg-purple-50/30 transition group">
                                <td class="px-8 py-5">
                                    <div class="font-bold text-gray-800">{{ $demande->patient->name }}</div>
                                    <div class="text-[10px] text-gray-400">ID: #{{ $demande->id }}</div>
                                </td>
                                
                                <td class="py-5">
                                    <div class="text-sm font-bold text-blue-900">Dr. {{ $demande->medecin->name }}</div>
                                    <div class="text-[10px] text-blue-400 uppercase font-black">{{ $demande->medecin->service->nom ?? '' }}</div>
                                </td>
                                
                                <td class="py-5">
                                    <div class="text-sm font-bold text-gray-700">{{ \Carbon\Carbon::parse($demande->date)->format('d/m/Y') }}</div>
                                    <div class="text-xs text-purple-500 font-black">{{ $demande->heure }}</div>
                                </td>

                                <td class="py-5">
                                    <div class="flex items-center">
                                        @if($demande->statut == 'termine')
                                            <span class="inline-flex items-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-2"></span>
                                                ✅ Effectué
                                            </span>
                                        @elseif($demande->statut == 'en_attente' && \Carbon\Carbon::parse($demande->date . ' ' . $demande->heure)->isPast())
                                            <span class="inline-flex items-center bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm">
                                                <span class="w-1.5 h-1.5 rounded-full bg-orange-500 mr-2 animate-pulse"></span>
                                                ⏳ Retard / Passé
                                            </span>
                                        @else
                                            <span class="inline-flex items-center bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2"></span>
                                                📅 Confirmé
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-8 py-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        @if($demande->statut == 'en_attente')
                                            <button class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl text-xs font-bold shadow-lg transition">
                                                Confirmer
                                            </button>
                                            <button class="bg-red-100 text-red-600 hover:bg-red-600 hover:text-white px-4 py-2 rounded-xl text-xs font-bold transition">
                                                Refuser
                                            </button>
                                        @else
                                            <button class="bg-gray-100 text-gray-400 px-4 py-2 rounded-xl text-xs font-bold cursor-not-allowed">
                                                Dossier clos
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center text-gray-400 font-medium italic">
                                    <div class="text-4xl mb-4">📂</div>
                                    Aucune demande pour le moment dans ce service.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>