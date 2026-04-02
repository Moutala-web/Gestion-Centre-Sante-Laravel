<section class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
    <header class="mb-6 border-b border-gray-50 pb-4">
        <h2 class="text-lg font-black text-blue-900 uppercase tracking-tighter">
            {{ __('Mon Profil Personnel') }}
        </h2>
        <p class="text-xs text-gray-400 font-medium">
            {{ __("Gérez votre identité numérique au sein du centre de santé.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            
            <div class="md:col-span-4 flex flex-col items-center justify-center p-6 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                <div class="relative group">
                    <img class="h-32 w-32 object-cover rounded-full border-4 border-white shadow-md transition group-hover:opacity-75" 
                         src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=0D8ABC&color=fff' }}" 
                         alt="{{ $user->name }}" />
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                        <span class="text-[10px] font-black text-blue-900 bg-white/80 px-2 py-1 rounded-full shadow-sm">MODIFIER</span>
                    </div>
                </div>
                
                <input id="profile_photo" name="profile_photo" type="file" class="hidden" onchange="this.form.submit()" />
                <button type="button" onclick="document.getElementById('profile_photo').click()" class="mt-4 text-[10px] font-black text-blue-600 uppercase hover:underline">
                    Changer la photo
                </button>
                <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
            </div>

            <div class="md:col-span-8 grid grid-cols-1 gap-4">
                <div>
                    <x-input-label for="name" :value="__('Nom complet')" class="text-[10px] font-black uppercase text-gray-400" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full border-gray-100 bg-gray-50 rounded-xl font-bold focus:ring-blue-500 shadow-sm text-sm" :value="old('name', $user->name)" required />
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-[10px] font-black uppercase text-gray-400" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full border-gray-100 bg-gray-50 rounded-xl font-bold focus:ring-blue-500 shadow-sm text-sm" :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="telephone" :value="__('Téléphone')" class="text-[10px] font-black uppercase text-gray-400" />
                        <x-text-input id="telephone" name="telephone" type="text" class="mt-1 block w-full border-gray-100 bg-gray-50 rounded-xl font-bold focus:ring-blue-500 shadow-sm text-sm" :value="old('telephone', $user->telephone)" placeholder="70 00 00 00" />
                        <x-input-error :messages="$errors->get('telephone')" />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-black text-xs shadow-lg transition transform hover:-translate-y-0.5 uppercase tracking-widest">
                        {{ __('Enregistrer les changements') }}
                    </button>

                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="ml-4 text-xs font-bold text-emerald-500 italic">
                            {{ __('Mis à jour avec succès !') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </form>
</section>