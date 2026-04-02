<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
            
            <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
                 class="fixed inset-y-0 left-0 z-30 w-64 bg-purple-900 text-white transition duration-300 transform md:relative md:translate-x-0 flex flex-col">
                
                <div class="p-6 text-2xl font-bold border-b border-purple-800 flex justify-between items-center">
                    <span>Sankara Santé</span>
                    <button @click="sidebarOpen = false" class="md:hidden text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <nav class="flex-1 mt-4 space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center py-3 px-6 hover:bg-purple-800 transition {{ request()->routeIs('dashboard') ? 'bg-purple-800 border-l-4 border-white' : '' }}">
                        <i class="fas fa-home mr-3"></i> Dashboard
                    </a>
                    
                    @if(Auth::user()->role === 'secretaire')
                        <a href="{{ route('patients.create') }}" class="flex items-center py-3 px-6 hover:bg-purple-800 transition {{ request()->routeIs('patients.create') ? 'bg-purple-800 border-l-4 border-white' : '' }}">
                           <i class="fas fa-user-plus mr-3"></i> Ajouter Patient
                        </a>
                       <a href="{{ route('historique.index') }}" class="flex items-center py-3 px-6 hover:bg-purple-800 transition {{ request()->routeIs('historique.index') ? 'bg-purple-800 border-l-4 border-white' : '' }}">
                       <i class="fas fa-history mr-3"></i> Historique Complet
                      </a>
                    @endif
                    {{-- Liens réservés à l'Administrateur --}}
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.services.index') }}" class="flex items-center py-3 px-6 hover:bg-purple-800 transition {{ request()->routeIs('admin.services.*') ? 'bg-purple-800 border-l-4 border-white' : '' }}">
                        <i class="fas fa-hospital mr-3"></i> Gestion Services
                        </a>
    
                        <a href="{{ route('admin.affectations.index') }}" class="flex items-center py-3 px-6 hover:bg-purple-800 transition {{ request()->routeIs('admin.affectations.*') ? 'bg-purple-800 border-l-4 border-white' : '' }}">
                     <i class="fas fa-user-tag mr-3"></i> Affectations
                    </a>
                    @endif

                    <a href="{{ route('profile.edit') }}" class="flex items-center py-3 px-6 hover:bg-purple-800 transition {{ request()->routeIs('profile.edit') ? 'bg-purple-800 border-l-4 border-white' : '' }}">
                        <i class="fas fa-user-cog mr-3"></i> Mon Profil
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                        @csrf
                        <button type="submit" class="w-full text-left flex items-center py-3 px-6 hover:bg-red-700 transition text-red-200">
                            <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
                        </button>
                    </form>
                </nav>
            </div>

            <div class="flex-1 flex flex-col overflow-hidden">
                
                <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-20">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="text-purple-900 md:hidden mr-4">
                            <i class="fas fa-bars fa-lg"></i>
                        </button>
                        @isset($header)
                            <div class="text-xl font-semibold text-purple-800">
                                {{ $header }}
                            </div>
                        @endisset
                    </div>

                    <div class="flex items-center gap-4 text-sm font-medium text-gray-700">
                        <span class="hidden sm:inline">Bienvenue, {{ Auth::user()->name }}</span>
                        <div class="h-8 w-8 rounded-full bg-purple-200 flex items-center justify-center text-purple-700">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </header>
                
                <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                    {{ $slot }}
                </main>
            </div>

            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black opacity-50 md:hidden"></div>
        </div>
    </body>
</html>