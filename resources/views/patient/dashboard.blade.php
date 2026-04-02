<x-app-layout>
    @if(session('success'))
    <div class="mb-6 p-4 rounded-[2rem] bg-emerald-50 border-2 border-emerald-100 flex items-center shadow-sm animate-bounce">
        <div class="bg-emerald-500 p-2 rounded-full mr-4 text-white">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <p class="text-emerald-800 font-black text-xs uppercase tracking-widest">
            {{ session('success') }}
        </p>
    </div>
@endif

@if(session('error'))
    <div class="mb-6 p-4 rounded-[2rem] bg-red-50 border-2 border-red-100 flex items-center shadow-sm">
        <div class="bg-red-500 p-2 rounded-full mr-4 text-white">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </div>
        <p class="text-red-800 font-black text-xs uppercase tracking-widest">
            {{ session('error') }}
        </p>
    </div>
@endif
    <x-slot name="header">
        <h2 class="font-black text-xl text-blue-900 uppercase tracking-widest">
            🏥 Espace Patient
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <div class="bg-white p-8 rounded-[3rem] shadow-xl border border-gray-100 flex items-center space-x-8 transition hover:shadow-2xl">
                <div class="h-24 w-24 bg-gradient-to-br from-blue-600 to-blue-800 rounded-full flex items-center justify-center text-white text-4xl font-black shadow-lg shadow-blue-200 border-4 border-white">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                
                <div class="flex-1">
                    <div class="flex items-center space-x-3">
                        <h1 class="text-3xl font-black text-blue-900 uppercase tracking-tight">
                            {{ Auth::user()->name }}
                        </h1>
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-blue-100">
                            Patient Vérifié
                        </span>
                    </div>
                    
                    <div class="mt-2 space-y-1">
                        <p class="text-sm font-bold text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ Auth::user()->email }}
                        </p>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            Compte actif depuis : {{ Auth::user()->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>

                <div>
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center bg-gray-900 hover:bg-black text-white px-6 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest transition transform hover:-translate-y-1 shadow-lg">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><circle cx="12" cy="12" r="3" stroke-width="3"></circle></svg>
                        Paramètres
                    </a>
                </div>
            </div>
            <div class="bg-white p-8 rounded-[3rem] shadow-xl border border-gray-100" x-data="{ selectedMedecin: '' }">
                <h3 class="text-lg font-black text-gray-800 uppercase mb-6 flex items-center">
                    <span class="mr-2 text-2xl">📅</span> Prendre un Nouveau Rendez-vous
                </h3>
                
                <form action="{{ route('rendezvous.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="medecin_id" :value="__('1. Choisir un Médecin')" class="text-[10px] font-black uppercase text-gray-400 mb-2" />
                                <select x-model="selectedMedecin" name="medecin_id" id="medecin_id" 
                                        class="w-full border-gray-100 bg-gray-50 rounded-2xl font-bold text-sm focus:ring-blue-500 shadow-sm transition">
                                    <option value="">-- Sélectionnez un spécialiste --</option>
                                    @foreach($medecins as $medecin)
                                        <option value="{{ $medecin->id }}">Dr. {{ $medecin->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="motif" :value="__('2. Motif de la consultation')" class="text-[10px] font-black uppercase text-gray-400 mb-2" />
                                <textarea name="motif" rows="3" 
                                          class="w-full border-gray-100 bg-gray-50 rounded-2xl font-medium text-sm focus:ring-blue-500 shadow-sm" 
                                          placeholder="Ex: Fièvre, maux de tête..."></textarea>
                            </div>
                        </div>

                        <div class="bg-blue-50/50 p-6 rounded-[2.5rem] border-2 border-dashed border-blue-100">
                            <x-input-label :value="__('3. Choisir un créneau disponible')" class="text-[10px] font-black uppercase text-gray-400 mb-4" />
                            
                            <div x-show="selectedMedecin == ''" class="py-10 text-center">
                                <p class="text-xs text-blue-400 italic">Veuillez d'abord sélectionner un médecin pour voir ses disponibilités.</p>
                            </div>

                            <div class="grid grid-cols-2 gap-3" x-show="selectedMedecin != ''">
                                @forelse($disponibilites as $dispo)
                                    <template x-if="selectedMedecin == {{ $dispo->user_id }}">
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="disponibilite_id" value="{{ $dispo->id }}" class="peer sr-only" required>
                                            <div class="p-3 text-center bg-white border-2 border-transparent rounded-2xl peer-checked:border-blue-600 peer-checked:bg-blue-600 peer-checked:text-white hover:shadow-md transition duration-300 shadow-sm">
                                                <p class="text-[10px] font-black uppercase opacity-60 leading-none">
                                                    {{ \Carbon\Carbon::parse($dispo->date)->translatedFormat('d M') }}
                                                </p>
                                                <p class="text-sm font-black mt-1">
                                                    {{ \Carbon\Carbon::parse($dispo->heure)->format('H:i') }}
                                                </p>
                                            </div>
                                        </label>
                                    </template>
                                @empty
                                    <p class="col-span-2 text-center text-[10px] text-gray-400">Aucun créneau libre pour ce médecin.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex justify-center">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-12 py-4 rounded-2xl font-black text-xs shadow-xl shadow-blue-200 transition transform hover:-translate-y-1 uppercase tracking-widest">
                            Confirmer ma demande de rendez-vous
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-[3rem] shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-black text-gray-800 uppercase">📋 Mon Historique Médical</h3>
                    <span class="text-xs font-bold text-gray-400">{{ $mesRendezVous->count() }} Rendez-vous</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 text-[10px] font-black uppercase text-gray-400 tracking-widest">
                                <th class="px-8 py-4">Médecin</th>
                                <th class="px-8 py-4">Date & Heure</th>
                                <th class="px-8 py-4">Statut</th>
                                <th class="px-8 py-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($mesRendezVous as $rdv)
                                <tr class="hover:bg-blue-50/30 transition">
                                    <td class="px-8 py-6">
                                        <div class="font-bold text-blue-900">Dr. {{ $rdv->medecin->name ?? 'Inconnu' }}</div>
                                        <div class="text-[10px] text-gray-400 font-medium">{{ $rdv->motif }}</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="font-bold text-gray-700">{{ \Carbon\Carbon::parse($rdv->date)->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $rdv->heure }}</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        @if($rdv->statut === 'en_attente')
                                            <span class="px-3 py-1 bg-orange-100 text-orange-600 rounded-full text-[10px] font-black uppercase">En attente</span>
                                        @elseif($rdv->statut === 'confirme')
                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-600 rounded-full text-[10px] font-black uppercase">Confirmé</span>
                                        @elseif($rdv->statut === 'termine')
                                            <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-[10px] font-black uppercase">Terminé</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-[10px] font-black uppercase">Annulé</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        @if($rdv->statut === 'en_attente')
                                            <form action="{{ route('rendezvous.destroy', $rdv->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment annuler ce rendez-vous ?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600 text-[10px] font-black uppercase underline">Annuler</button>
                                            </form>
                                        @else
                                            <span class="text-gray-300 text-[10px] font-black uppercase">Aucune action</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-10 text-center text-gray-400 italic">Vous n'avez pas encore de rendez-vous.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>