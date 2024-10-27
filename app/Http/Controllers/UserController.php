<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
        $newPassword = Str::random(8) . rand(1000, 9999);;
        $user->password = Hash::make($newPassword);
        $user->save();

        return redirect()->route('users.index')->with('success', 'Contraseña restablecida');
    }

    public function showChangePasswordForm()
    {
        return view('auth.passwords.change');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return redirect()->back()->with('error', 'La contraseña actual no es correcta.');
        }

        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);
        return redirect()->back()->with('success', 'Contraseña cambiada con éxito.');
    }
}
