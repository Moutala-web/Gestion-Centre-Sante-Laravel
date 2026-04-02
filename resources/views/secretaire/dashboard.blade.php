<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-purple-800 leading-tight tracking-tight">
            {{ __('Espace Secrétariat') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-bold rounded shadow-sm">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-[1.5rem] p-6 mb-8 shadow-sm border-l-8 border-purple-600 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-black text-gray-800 uppercase tracking-tighter">Session Secrétariat</h3>
                    <p class="text-sm text-gray-500 font-medium">Service : <span class="text-purple-600 font-bold uppercase">{{ auth()->user()->service->nom ?? 'Non assigné' }}</span></p>
                </div>
                <div class="hidden md:block text-right">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Université Thomas Sankara</p>
                    <p class="text-sm font-bold text-gray-700 italic">Sankara Santé v2.0</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2rem] mb-8 border border-gray-100">
                <div class="p-8 bg-white">
                    
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                        <div>
                            <h4 class="font-black text-gray-400 mb-1 uppercase text-xs tracking-[0.2em]">Flux de travail</h4>
                            <h2 class="text-lg font-black text-gray-800 uppercase">Demandes en attente</h2>
                        </div>
                        
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('rendezvous.create') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-black px-5 py-2.5 rounded-xl text-xs uppercase tracking-widest transition shadow-lg shadow-blue-100">
                                <i class="fas fa-calendar-plus mr-2"></i> Nouveau RDV Manuel
                            </a>
                            
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Patient</th>
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Médecin</th>
                                    <th class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Date & Heure</th>
                                    <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-widest">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-50">
                                @forelse($demandes as $demande)
                                <tr class="hover:bg-purple-50/30 transition duration-150">
                                    <td class="px-6 py-5">
                                        <div class="text-base font-black text-gray-900 leading-tight">{{ $demande->patient->name }}</div>
                                        <div class="text-sm text-purple-500 font-medium italic">{{ $demande->patient->email }}</div>
                                    </td>
                                    <td class="px-6 py-5 text-sm font-bold text-gray-700">
                                        <span class="text-purple-600 uppercase text-[10px] font-black block">Spécialiste</span>
                                        Dr. {{ $demande->medecin->name }}
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="text-sm font-black text-gray-800">{{ \Carbon\Carbon::parse($demande->date)->translatedFormat('d M Y') }}</div>
                                        <div class="text-xs font-bold text-gray-400 uppercase">à {{ \Carbon\Carbon::parse($demande->heure)->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex justify-end gap-2 items-center">
                                            <form action="{{ route('rendezvous.confirmer', $demande->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="bg-green-100 text-green-700 border border-green-200 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase hover:bg-green-600 hover:text-white transition shadow-sm">
                                                    Confirmer
                                                </button>
                                            </form>

                                            <button onclick="openModalReprogrammer({{ $demande->id }}, '{{ $demande->date }}', '{{ $demande->heure }}')" 
                                                class="bg-orange-50 text-orange-600 border border-orange-200 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase hover:bg-orange-500 hover:text-white transition shadow-sm">
                                                <i class="fas fa-clock mr-1"></i> Reprogrammer
                                            </button>

                                            <form action="{{ route('rendezvous.refuser', $demande->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="bg-red-50 text-red-600 border border-red-100 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase hover:bg-red-600 hover:text-white transition shadow-sm">
                                                    Refuser
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalReprogrammer" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white p-8 rounded-[2rem] shadow-2xl max-w-md w-full border border-orange-100">
            <h3 class="text-xl font-black text-gray-800 uppercase mb-2 text-orange-600 italic">🕒 Reprogrammer</h3>
            <p class="text-xs text-gray-500 font-bold mb-6 uppercase tracking-widest">Choisir un nouveau créneau</p>
            
            <form id="formReprogrammer" method="POST">
                @csrf @method('PATCH')
                <div class="space-y-5">
                    <div>
                        <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 tracking-widest">Nouvelle Date de visite</label>
                        <input type="date" name="date" id="inputDate" min="{{ date('Y-m-d') }}" class="w-full border-gray-100 rounded-xl font-bold text-gray-900 bg-gray-50 focus:ring-orange-500" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase text-gray-400 mb-2 tracking-widest">Nouvelle Heure</label>
                        <input type="time" name="heure" id="inputHeure" class="w-full border-gray-100 rounded-xl font-bold text-gray-900 bg-gray-50 focus:ring-orange-500" required>
                    </div>
                </div>

                <div class="mt-8 flex justify-end items-center gap-4">
                    <button type="button" onclick="closeModal()" class="text-gray-400 font-black uppercase text-[10px] tracking-widest hover:text-gray-600">Annuler</button>
                    <button type="submit" class="bg-orange-500 text-white px-6 py-3 rounded-xl font-black uppercase text-xs shadow-lg shadow-orange-200 hover:bg-orange-600 transition">
                        Valider le changement
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModalReprogrammer(id, date, heure) {
            const modal = document.getElementById('modalReprogrammer');
            const form = document.getElementById('formReprogrammer');
            form.action = `/rendezvous/${id}/reprogrammer`; 
            document.getElementById('inputDate').value = date;
            document.getElementById('inputHeure').value = heure;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
        function closeModal() {
            const modal = document.getElementById('modalReprogrammer');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</x-app-layout>