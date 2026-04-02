<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-blue-900 uppercase tracking-widest">
                🏥 Gestion UTS Santé
            </h2>
            <div class="px-4 py-1 bg-blue-600 text-white text-xs font-bold rounded-full shadow-md">
                ADMINISTRATEUR
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-gradient-to-r from-blue-700 to-indigo-800 rounded-[2rem] p-8 mb-8 shadow-xl text-white">
                <h3 class="text-2xl font-bold">Bonjour, {{ Auth::user()->name }} !</h3>
                <p class="text-blue-100 mt-1">Gérez efficacement les effectifs et les services du centre de santé.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white p-6 rounded-[2rem] shadow-lg border-l-8 border-blue-500 transform transition hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase text-gray-400">Médecins actifs</p>
                            <h4 class="text-3xl font-black text-gray-800">{{ $stats['medecins'] ?? 0 }}</h4>
                        </div>
                        <span class="text-4xl">👨‍⚕️</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2rem] shadow-lg border-l-8 border-emerald-500 transform transition hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase text-gray-400">Secrétaires</p>
                            <h4 class="text-3xl font-black text-gray-800">{{ $stats['secretaires'] ?? 0 }}</h4>
                        </div>
                        <span class="text-4xl">💼</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2rem] shadow-lg border-l-8 border-purple-500 transform transition hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase text-gray-400">Patients inscrits</p>
                            <h4 class="text-3xl font-black text-gray-800">{{ $stats['patients'] ?? 0 }}</h4>
                        </div>
                        <span class="text-4xl">👥</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <a href="{{ route('admin.users.create') }}" class="group relative bg-white p-8 rounded-[2rem] shadow-xl hover:scale-105 transition-transform duration-300 border-b-8 border-blue-500">
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <h4 class="text-xl font-black text-gray-800 uppercase">Recrutement</h4>
                    <p class="text-sm text-gray-500 mt-2 font-medium">Ajouter un médecin ou secrétaire au système.</p>
                </a>

                <a href="{{ route('admin.users.index') }}" class="group relative bg-white p-8 rounded-[2rem] shadow-xl hover:scale-105 transition-transform duration-300 border-b-8 border-emerald-500">
                    <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-colors shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-black text-gray-800 uppercase">Effectifs</h4>
                    <p class="text-sm text-gray-500 mt-2 font-medium">Consulter et gérer la liste complète du personnel.</p>
                </a>

                <div class="group relative bg-white p-8 rounded-[2rem] shadow-xl hover:scale-105 transition-transform duration-300 border-b-8 border-purple-500 cursor-pointer">
                    <div class="w-16 h-16 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-600 group-hover:text-white transition-colors shadow-inner">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h4 class="text-xl font-black text-gray-800 uppercase">Analytique</h4>
                    <p class="text-sm text-gray-500 mt-2 font-medium">Visualiser les rapports d'activité du centre.</p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>