<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-green-900 uppercase">📋 Détails du Rendez-vous</h2>
            <a href="{{ route('medecin.dossiers') }}" class="text-xs font-bold text-green-600 hover:underline">← Retour à l'historique</a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#f0f4f8] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-white mb-8">
                <div class="bg-green-600 p-8 text-white">
                    <div class="flex items-center space-x-6">
                        <div class="w-20 h-20 bg-white/20 rounded-3xl flex items-center justify-center text-3xl shadow-inner">
                            👤
                        </div>
                        <div>
                            <h3 class="text-2xl font-black uppercase tracking-tight">{{ $rdv->patient->name }}</h3>
                            <p class="opacity-80 font-bold uppercase text-[10px] tracking-widest">Dossier Patient #{{ $rdv->patient_id }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-10 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h4 class="font-black text-gray-400 uppercase text-[10px] tracking-widest">Informations Contact</h4>
                        <p class="text-sm font-bold text-gray-700">📞 {{ $rdv->patient->telephone ?? 'Non renseigné' }}</p>
                        <p class="text-sm font-bold text-gray-700">📧 {{ $rdv->patient->email }}</p>
                    </div>
                    <div class="space-y-4">
                        <h4 class="font-black text-gray-400 uppercase text-[10px] tracking-widest">Détails Rendez-vous</h4>
                        <p class="text-sm font-bold text-gray-700">📅 {{ \Carbon\Carbon::parse($rdv->date)->translatedFormat('d F Y') }}</p>
                        <p class="text-sm font-bold text-gray-700">⏰ {{ \Carbon\Carbon::parse($rdv->heure)->format('H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-10 rounded-[2.5rem] shadow-lg border border-gray-100">
                <h4 class="font-black text-green-700 uppercase text-xs mb-6 tracking-widest">Motif de consultation</h4>
                <div class="bg-gray-50 p-6 rounded-2xl border-l-4 border-green-500 mb-8">
                    <p class="text-gray-600 font-medium italic">
                        {{ $rdv->motif ?? 'Aucun motif renseigné pour cette séance.' }}
                    </p>
                </div>
                
                <div class="flex gap-4 mt-8">
    <a href="{{ route('medecin.ordonnance.create', $rdv->id) }}" class="flex-1 bg-emerald-600 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-700 transition text-center shadow-lg">
    AJOUTER UNE ORDONNANCE
</a>

    <form action="{{ route('medecin.cloturer', $rdv->id) }}" method="POST" class="flex-1">
        @csrf
        @method('PATCH')
        <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-black transition shadow-lg">
            TERMINER LA SÉANCE
        </button>
    </form>
</div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>