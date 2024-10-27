<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado con éxito');
    }

    public function toggleActive(User $user)
    {
        $user->activo = !$user->activo;
        $user->save();

        return redirect()->route('users.index')->with('success', 'Estado del usuario actualizado');
    }

    public function resetPassword(User $user)
    {
        $newPassword = 'nueva_contraseña_segura'; // Genera una contraseña segura
        $user->password = Hash::make($newPassword);
        $user->save();

        // Aquí puedes enviar la nueva contraseña por correo si es necesario

        return redirect()->route('users.index')->with('success', 'Contraseña restablecida');
    }
}
