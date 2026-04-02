<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-purple-900 uppercase">📚 Historique des Consultations</h2>
            <a href="{{ route('dashboard') }}" class="text-xs font-bold text-purple-600 hover:underline">← Retour Dashboard</a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-purple-50/30 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-purple-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-purple-600 text-white font-black uppercase text-[10px] tracking-[0.2em]">
                        <tr>
                            <th class="p-6">Date & Heure</th>
                            <th class="p-6">Patient</th>
                            <th class="p-6">Motif</th>
                            <th class="p-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($dossiers as $rdv)
                            <tr class="hover:bg-purple-50/50 transition">
                                <td class="p-6 font-bold text-gray-700">
                                    <div class="text-sm">{{ \Carbon\Carbon::parse($rdv->date)->translatedFormat('d F Y') }}</div>
                                    <div class="text-purple-500 text-[10px]">{{ \Carbon\Carbon::parse($rdv->heure)->format('H:i') }}</div>
                                </td>
                                <td class="p-6">
                                    <div class="font-black text-gray-800 uppercase text-xs">{{ $rdv->patient->name }}</div>
                                    <div class="text-[10px] text-gray-400 italic">ID: #{{ $rdv->patient->id }}</div>
                                </td>
                                <td class="p-6 text-xs text-gray-500 font-medium">
                                    {{ $rdv->motif ?? 'Consultation standard' }}
                                </td>
                                <td class="p-6 text-center">
                                    <a href="{{ route('medecin.consulter', $rdv->id) }}" class="bg-white text-purple-600 border border-purple-200 px-4 py-2 rounded-xl text-[10px] font-black hover:bg-purple-600 hover:text-white transition uppercase">
                                        Voir Détails
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-20 text-center text-gray-400 italic font-bold">
                                    Aucun dossier trouvé dans votre historique.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>