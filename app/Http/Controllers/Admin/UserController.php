<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Affiche la liste de tout le personnel.
     */
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())
                     ->whereIn('role', ['medecin', 'secretaire'])
                     ->with('service')
                     ->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        $services = Service::all();
        return view('admin.users.create', compact('services'));
    }

    /**
     * Enregistrer un nouveau membre du personnel.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:medecin,secretaire'],
            'service_id' => ['required', 'exists:services,id'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'service_id' => $request->service_id,
        ]);

        return redirect()->route('admin.users.index')->with('status', 'Personnel ajouté avec succès !');
    }

    /**
     * Afficher le formulaire de modification.
     */
    public function edit(User $user)
    {
        $services = Service::all();
        return view('admin.users.edit', compact('user', 'services'));
    }

    /**
     * Mettre à jour les informations du membre du personnel.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // L'exception ','.$user->id permet de garder le même email sans erreur
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:medecin,secretaire'],
            'service_id' => ['required', 'exists:services,id'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->service_id = $request->service_id;

        // On ne change le mot de passe que s'il est saisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('status', 'Le compte de '.$user->name.' a été mis à jour !');
    }

    /**
     * Supprimer un membre du personnel.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('status', 'Le compte a été supprimé.');
    }
}