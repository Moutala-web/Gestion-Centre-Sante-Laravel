<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-purple-800 uppercase tracking-widest">
                📅 Nouveau Rendez-vous Manuel
            </h2>
            <a href="{{ route('dashboard') }}" class="text-xs font-bold text-purple-600 hover:underline uppercase">
                ← Retour
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-[2rem] border border-purple-100">
                <div class="p-10">
                    <form method="POST" action="{{ route('rendezvous.store_manuel') }}">
                        @csrf

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-black uppercase mb-2">Choisir un Patient</label>
                            <select name="patient_id" class="w-full border-gray-200 rounded-xl focus:ring-purple-500 focus:border-purple-500 shadow-sm text-gray-800 font-bold" required>
                                <option value="">-- Sélectionner le patient --</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }} ({{ $patient->telephone }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-black uppercase mb-2">Médecin Référent</label>
                            <select name="medecin_id" id="medecin_id" class="w-full border-gray-200 rounded-xl focus:ring-purple-500 focus:border-purple-500 shadow-sm text-gray-800 font-bold" required>
                                <option value="">-- Sélectionner un médecin --</option>
                                @foreach($medecins as $medecin)
                                    <option value="{{ $medecin->id }}">Dr. {{ $medecin->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-8">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-4">Choisir un créneau disponible</label>
                            
                            <div id="container_creneaux" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <p class="text-gray-400 text-sm italic col-span-full border-2 border-dashed border-gray-100 rounded-xl p-6 text-center">
                                    Sélectionnez un médecin pour voir ses disponibilités...
                                </p>
                            </div>

                            <input type="hidden" name="date" id="date_selectionnee" required>
                            <input type="hidden" name="heure" id="heure_selectionnee" required>
                        </div>

                        <div class="flex items-center justify-end border-t border-gray-50 pt-6">
                            <button type="submit" class="bg-purple-700 hover:bg-purple-800 text-white font-black py-4 px-10 rounded-2xl shadow-lg shadow-purple-200 transition-all active:scale-95 uppercase tracking-widest text-xs">
                                Confirmer et Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const medecinSelect = document.getElementById('medecin_id');
            const container = document.getElementById('container_creneaux');
            const hiddenHeure = document.getElementById('heure_selectionnee');
            const hiddenDate = document.getElementById('date_selectionnee');

            async function chargerDisponibilites() {
                const medecinId = medecinSelect.value;

                if (medecinId) {
                    container.innerHTML = '<p class="col-span-full text-center text-purple-600 font-bold animate-pulse">Récupération des créneaux ouverts...</p>';
                    hiddenHeure.value = '';
                    hiddenDate.value = '';

                    try {
                        // On appelle une API qui renvoie les créneaux créés par le médecin
                        const response = await fetch(`/api/get-creneaux-ouverts?medecin_id=${medecinId}`);
                        const creneaux = await response.json();

                        container.innerHTML = ''; 

                        if (creneaux.length === 0) {
                            container.innerHTML = '<p class="col-span-full text-center text-red-500 bg-red-50 p-4 rounded-xl font-bold">Le médecin n\'a aucun créneau libre.</p>';
                        } else {
                            creneaux.forEach(item => {
                                const card = document.createElement('div');
                                card.className = "cursor-pointer border-2 border-gray-100 rounded-2xl p-4 text-center hover:border-purple-500 hover:bg-purple-50 transition-all group shadow-sm";
                                card.innerHTML = `
                                    <span class="block text-[10px] text-gray-400 font-black uppercase mb-1">${item.date_formatee}</span>
                                    <span class="block text-lg font-black text-gray-800 group-hover:text-purple-700">${item.heure}</span>
                                `;

                                card.addEventListener('click', function() {
                                    document.querySelectorAll('#container_creneaux > div').forEach(div => {
                                        div.classList.remove('border-purple-600', 'bg-purple-100', 'ring-2', 'ring-purple-200');
                                        div.classList.add('border-gray-100');
                                    });

                                    card.classList.add('border-purple-600', 'bg-purple-100', 'ring-2', 'ring-purple-200');
                                    card.classList.remove('border-gray-100');

                                    // On remplit les deux champs cachés d'un coup
                                    hiddenHeure.value = item.heure;
                                    hiddenDate.value = item.date_sql;
                                });

                                container.appendChild(card);
                            });
                        }
                    } catch (error) {
                        container.innerHTML = '<p class="col-span-full text-red-500 text-center">Erreur lors de la récupération des données.</p>';
                    }
                }
            }

            medecinSelect.addEventListener('change', chargerDisponibilites);
        });
    </script>
</x-app-layout>