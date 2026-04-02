<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-purple-900 leading-tight tracking-tight">
            {{ __('Historique des Rendez-vous') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[1.5rem] border border-purple-100">
                <div class="p-8 bg-white">
                    
                    <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-6">
                        <div>
                            <h3 class="text-sm font-black text-purple-600 uppercase tracking-[0.2em]">Archives</h3>
                            <p class="text-gray-500 text-sm">Consultation des dossiers patients traités.</p>
                        </div>
                        <span class="bg-purple-600 text-white text-xs font-black px-4 py-2 rounded-lg shadow-lg shadow-purple-200">
                            {{ $historique->count() }} DOSSIERS
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-50 rounded-t-xl">
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Patient</th>
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Médecin</th>
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Rendez-vous</th>
                                    <th class="px-6 py-4 text-center text-xs font-black text-gray-400 uppercase tracking-widest">Statut</th>
                                    <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-widest">Date de Traitement</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($historique as $item)
                                <tr class="hover:bg-purple-50/50 transition duration-200">
                                    <td class="px-6 py-5">
                                        <div class="text-base font-black text-gray-900 leading-none mb-1">{{ $item->patient->name }}</div>
                                        <div class="text-sm text-purple-500 font-medium lowercase italic">{{ $item->patient->email }}</div>
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="flex items-center text-gray-700">
                                            <span class="w-2 h-2 bg-purple-400 rounded-full mr-2"></span>
                                            <span class="font-bold text-sm text-gray-800">Dr. {{ $item->medecin->name }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5">
                                        <div class="text-sm font-bold text-gray-900">
                                            {{ \Carbon\Carbon::parse($item->date)->translatedFormat('d M Y') }}
                                        </div>
                                        <div class="text-xs font-black text-gray-400 uppercase">
                                            à {{ \Carbon\Carbon::parse($item->heure)->format('H:i') }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        @if($item->statut === 'confirme')
                                            <span class="inline-flex items-center px-4 py-1.5 bg-green-100 text-green-800 border border-green-200 rounded-md text-[10px] font-black uppercase tracking-tighter">
                                                <i class="fas fa-check-circle mr-1.5"></i> Confirmé
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-4 py-1.5 bg-red-50 text-red-700 border border-red-100 rounded-md text-[10px] font-black uppercase tracking-tighter">
                                                <i class="fas fa-times-circle mr-1.5"></i> Refusé
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 text-right">
                                        <span class="text-sm font-bold text-gray-900 bg-gray-100 px-3 py-1.5 rounded-lg border border-gray-200 shadow-sm">
                                            {{ $item->updated_at->format('d/m/Y') }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="text-gray-300 text-5xl mb-4">📂</div>
                                        <div class="text-gray-400 font-bold uppercase text-xs tracking-widest italic">Aucun historique disponible</div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>