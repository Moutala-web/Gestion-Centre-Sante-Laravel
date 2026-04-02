<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-emerald-900 uppercase">👨‍⚕️ Espace Praticien</h2>
            <span class="bg-emerald-100 text-emerald-700 px-4 py-1 rounded-full text-sm font-bold shadow-sm">
                {{ $user->service->nom ?? 'Général' }}
            </span>
        </div>
    </x-slot>

    <div class="py-12 min-h-screen bg-gradient-to-br from-gray-50 via-white to-emerald-50/30">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-emerald-50 mb-8 flex justify-between items-center">
                <div>
                    <h3 class="text-3xl font-black text-gray-800">Bonjour, Dr. {{ $user->name }} !</h3>
                    <p class="text-gray-500 mt-2 font-medium">
                        Vous avez <span class="text-emerald-600 font-bold">{{ $rendezVous->where('statut', 'en_attente')->count() }}</span> rendez-vous actifs aujourd'hui.
                    </p>
                </div>
                <div class="hidden md:block">
                    <span class="text-5xl">🩺</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl border border-emerald-100/50">
                        <div class="flex items-center mb-6 space-x-3">
                            <span class="p-3 bg-emerald-50 rounded-2xl text-xl">🕒</span>
                            <h3 class="font-black text-gray-800 uppercase tracking-tighter text-sm">Ajouter un créneau de consultation</h3>
                        </div>
                        <form action="{{ route('medecin.disponibilite.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Date</label>
                                <input type="date" name="date" class="w-full border-gray-100 bg-gray-50 rounded-xl font-bold text-sm focus:ring-emerald-500 shadow-sm" required min="{{ date('Y-m-d') }}">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Heure</label>
                                <input type="time" name="heure" class="w-full border-gray-100 bg-gray-50 rounded-xl font-bold text-sm focus:ring-emerald-500 shadow-sm" required>
                            </div>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-xl font-black text-xs shadow-lg transition uppercase tracking-widest">
                                Ouvrir le créneau
                            </button>
                        </form>
                    </div>

                    <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100">
                        <div class="p-6 bg-emerald-600 text-white font-black uppercase tracking-widest text-sm flex justify-between">
                            <span>📅 Planning Actuel</span>
                            <span class="opacity-75">{{ now()->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="p-6">
                            @php $hasActiveRdv = false; @endphp
                            @foreach($rendezVous as $rdv)
                                @php
                                    $momentRDV = \Carbon\Carbon::parse($rdv->date . ' ' . $rdv->heure);
                                    // On n'affiche que si c'est aujourd'hui/futur ET en attente
                                @endphp

                                @if(!$momentRDV->isPast() && $rdv->statut == 'en_attente')
                                    @php $hasActiveRdv = true; @endphp
                                    <div class="flex items-center p-4 mb-4 bg-gray-50 rounded-2xl border-l-4 border-emerald-500 hover:shadow-md transition">
                                        <div class="text-emerald-600 font-black mr-6">{{ \Carbon\Carbon::parse($rdv->heure)->format('H:i') }}</div>
                                        <div class="flex-1">
                                            <div class="font-bold text-gray-800 uppercase text-xs">{{ $rdv->patient->name ?? 'Patient Inconnu' }}</div>
                                            <div class="text-[10px] text-gray-400 italic">{{ Str::limit($rdv->motif, 50) }}</div>
                                        </div>
                                        <a href="{{ route('medecin.consulter', $rdv->id) }}" class="bg-white text-emerald-600 border border-emerald-200 px-4 py-2 rounded-xl text-[10px] font-black hover:bg-emerald-600 hover:text-white transition uppercase shadow-sm">
                                            Consulter
                                        </a>
                                    </div>
                                @endif
                            @endforeach

                            @if(!$hasActiveRdv)
                                <div class="text-center py-10 text-gray-400 italic font-bold">
                                    Aucun rendez-vous à venir pour le moment.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-[2.5rem] shadow-lg border border-gray-100">
                        <h4 class="font-black text-gray-800 uppercase text-xs mb-4 tracking-widest">Mes Créneaux</h4>
                        <div class="space-y-3 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                            @forelse($mesDispos as $dispo)
                                @php
                                    $isExpired = \Carbon\Carbon::parse($dispo->date . ' ' . $dispo->heure)->isPast();
                                @endphp
                                <div class="flex justify-between items-center p-3 rounded-xl {{ ($isExpired || !$dispo->est_libre) ? 'bg-gray-50 opacity-50' : 'bg-emerald-50 border border-emerald-100' }}">
                                    <div class="text-[10px] font-bold">
                                        <span class="{{ $isExpired ? 'text-gray-400' : 'text-emerald-700' }}">{{ \Carbon\Carbon::parse($dispo->date)->format('d/m') }}</span> 
                                        à <span class="text-gray-800">{{ \Carbon\Carbon::parse($dispo->heure)->format('H:i') }}</span>
                                    </div>
                                    <span class="text-[8px] font-black uppercase">
                                        @if($isExpired)
                                            <span class="text-gray-400">Expiré</span>
                                        @elseif(!$dispo->est_libre)
                                            <span class="text-blue-500">Occupé</span>
                                        @else
                                            <span class="text-emerald-500">Libre</span>
                                        @endif
                                    </span>
                                </div>
                            @empty
                                <p class="text-[10px] text-gray-400 italic">Aucun créneau ouvert.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-[2rem] shadow-lg border border-gray-100">
                        <h4 class="font-black text-gray-800 uppercase text-[10px] mb-4 tracking-widest">Outils rapides</h4>
                        
                        <a href="{{ route('medecin.recherche_patient') }}" class="flex items-center w-full mb-3 bg-blue-50 text-blue-600 p-4 rounded-2xl font-bold hover:bg-blue-100 transition text-xs shadow-sm group">
                            <span class="mr-3 group-hover:scale-125 transition-transform">🔍</span>
                            Rechercher un Patient
                        </a>

                        <a href="{{ route('medecin.dossiers') }}" class="flex items-center w-full bg-purple-50 text-purple-600 p-4 rounded-2xl font-bold hover:bg-purple-100 transition text-xs shadow-sm group">
                            <span class="mr-3 group-hover:scale-125 transition-transform">📚</span>
                            Historique Médical
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>