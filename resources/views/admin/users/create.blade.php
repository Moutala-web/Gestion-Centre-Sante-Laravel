<x-app-layout>
    <div class="min-h-screen bg-gray-100 flex flex-col justify-center items-center p-4">
        
        <div class="w-full max-w-md bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border-t-8 border-blue-600">
            <div class="p-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-black text-blue-900 uppercase">Inscription</h2>
                    <p class="text-gray-400 text-xs font-bold tracking-widest mt-1">PERSONNEL MÉDICAL</p>
                </div>

                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-text-input id="name" class="block w-full bg-gray-50 border-none rounded-2xl py-3 focus:ring-2 focus:ring-blue-500" type="text" name="name" :value="old('name')" required placeholder="Nom complet" />
                    </div>

                    <div>
                        <x-text-input id="email" class="block w-full bg-gray-50 border-none rounded-2xl py-3 focus:ring-2 focus:ring-blue-500" type="email" name="email" required placeholder="Email professionnel" />
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <select name="role" class="bg-gray-50 border-none rounded-2xl py-3 text-sm focus:ring-2 focus:ring-blue-500">
                            <option value="medecin">🩺 Médecin</option>
                            <option value="secretaire">📂 Secrétaire</option>
                        </select>
                        <select name="service_id" class="bg-gray-50 border-none rounded-2xl py-3 text-sm focus:ring-2 focus:ring-blue-500">
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <x-text-input id="password" class="bg-gray-50 border-none rounded-2xl py-3" type="password" name="password" required placeholder="Pass" />
                        <x-text-input id="password_confirmation" class="bg-gray-50 border-none rounded-2xl py-3" type="password" name="password_confirmation" required placeholder="Confirm" />
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg transition transform hover:-translate-y-1">
                        CRÉER LE COMPTE
                    </button>

                    <div class="text-center mt-4">
                        <a href="{{ route('dashboard') }}" class="text-xs font-bold text-gray-400 hover:text-blue-600 uppercase">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>