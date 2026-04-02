<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // 1. On remplit avec les données validées par ProfileUpdateRequest (nom, email)
        $user->fill($request->validated());

        // 2. Gestion manuelle du téléphone (car il n'est pas forcément dans Request par défaut)
        if ($request->has('telephone')) {
            $user->telephone = $request->telephone;
        }

        // 3. Gestion de la photo de profil
        if ($request->hasFile('profile_photo')) {
            // Optionnel : Supprimer l'ancienne photo si elle existe pour gagner de la place
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Enregistre la nouvelle photo dans storage/app/public/profile-photos
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $path;
        }

        // Réinitialiser la vérification d'email si l'email a changé
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Optionnel : Supprimer la photo du serveur lors de la suppression du compte
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}