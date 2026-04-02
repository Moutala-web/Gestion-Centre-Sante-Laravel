<x-app-layout>
    <form action="{{ route('medecin.ordonnance.store', $rdv->id) }}" method="POST">
    @csrf
    <div class="mb-6">
        <label class="block text-xs font-black uppercase text-gray-400 mb-2 tracking-widest">Détails de la prescription</label>
        <textarea 
            name="contenu" 
            rows="10" 
            class="w-full border-none bg-gray-50 rounded-[2rem] p-8 font-medium text-gray-700 focus:ring-2 focus:ring-emerald-500 shadow-inner"
            placeholder="Ex: Paracétamol 500mg, 1 comprimé 3 fois par jour pendant 5 jours..."
            required
        ></textarea>
    </div>

    <div class="flex gap-4">
        <button type="submit" class="flex-1 bg-emerald-600 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-700 transition shadow-lg">
            💾 Enregistrer et Valider
        </button>
        <a href="{{ route('medecin.consulter', $rdv->id) }}" class="px-8 py-4 bg-gray-100 text-gray-500 rounded-2xl font-bold text-xs uppercase hover:bg-gray-200 transition">
            Annuler
        </a>
    </div>
</form>
</x-app-layout>