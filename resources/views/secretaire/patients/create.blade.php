<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-purple-800 leading-tight">
            {{ __('Enregistrer un nouveau Patient') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200">
                    <form action="{{ route('patients.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nom Complet</label>
                            <input type="text" name="name" class="w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Adresse Email</label>
                            <input type="email" name="email" class="w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500" required>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Téléphone</label>
                            <input type="text" name="telephone" class="w-full border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                        </div>

                        <div class="flex items-center justify-between bg-purple-50 p-4 rounded-lg">
                            <p class="text-xs text-purple-700 italic">
                                <i class="fas fa-info-circle mr-1"></i> Mot de passe par défaut : <strong>Sankara2026</strong>
                            </p>
                            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-lg transition">
                                Créer le compte
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>