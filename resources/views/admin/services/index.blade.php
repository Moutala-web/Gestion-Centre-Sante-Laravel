<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-indigo-700 mb-4">Ajouter un nouveau service</h3>
                <form action="{{ route('admin.services.store') }}" method="POST" class="flex gap-4">
                    @csrf
                    <input type="text" name="nom" placeholder="Nom du service (ex: Radiologie)" class="border-gray-300 rounded-md w-full" required>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Ajouter</button>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Nom du Service</th>
                            <th>Date de création</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 font-semibold">{{ $service->nom }}</td>
                            <td class="text-gray-500">{{ $service->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>