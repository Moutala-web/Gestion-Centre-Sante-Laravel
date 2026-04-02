<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-blue-900 uppercase">📋 Liste du Personnel</h2>
            <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-2xl font-bold shadow-lg transition transform hover:-translate-y-1">
                + Nouveau Membre
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('status'))
                <div class="mb-6 p-4 bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 font-bold rounded-r-xl shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-gray-100">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-blue-900 text-white">
                            <th class="px-6 py-5 text-xs font-black uppercase tracking-widest">Identité</th>
                            <th class="px-6 py-5 text-xs font-black uppercase tracking-widest">Poste</th>
                            <th class="px-6 py-5 text-xs font-black uppercase tracking-widest">Service</th>
                            <th class="px-6 py-5 text-xs font-black uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $user)
                        <tr class="hover:bg-blue-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-black shadow-md mr-3">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-400 font-medium">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->role == 'medecin')
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-black uppercase italic border border-emerald-200">🩺 Médecin</span>
                                @else
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-lg text-[10px] font-black uppercase italic border border-purple-200">📂 Secrétaire</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-bold">
                                {{ $user->service ? $user->service->nom : 'Général' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center space-x-4">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700 transition transform hover:scale-110" title="Modifier">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </a>
                                    
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce compte ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 transition transform hover:scale-110" title="Supprimer">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($users->isEmpty())
                    <div class="py-12 text-center text-gray-400 font-bold italic uppercase tracking-widest">
                        Aucun personnel enregistré pour le moment.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>