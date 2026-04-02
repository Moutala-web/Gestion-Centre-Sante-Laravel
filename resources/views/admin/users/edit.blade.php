<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-blue-900 uppercase">✏️ Modifier le profil</h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-[2.5rem] p-10 border border-gray-100">
                
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="space-y-6">
                        <div>
                            <label class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-2">Nom Complet</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border-gray-100 bg-gray-50 rounded-xl font-bold shadow-sm" required>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-2">Adresse Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border-gray-100 bg-gray-50 rounded-xl font-bold shadow-sm" required>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-2">Rôle</label>
                                <select name="role" class="w-full border-gray-100 bg-gray-50 rounded-xl font-bold shadow-sm">
                                    <option value="medecin" {{ $user->role == 'medecin' ? 'selected' : '' }}>Médecin</option>
                                    <option value="secretaire" {{ $user->role == 'secretaire' ? 'selected' : '' }}>Secrétaire</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-black uppercase text-gray-400 tracking-widest mb-2">Service</label>
                                <select name="service_id" class="w-full border-gray-100 bg-gray-50 rounded-xl font-bold shadow-sm">
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ $user->service_id == $service->id ? 'selected' : '' }}>
                                            {{ $service->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 flex justify-end space-x-4">
                        <a href="{{ route('admin.users.index') }}" class="px-6 py-3 text-gray-400 font-bold uppercase tracking-widest">Annuler</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-3 rounded-2xl font-black shadow-lg">
                            Mettre à jour
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>