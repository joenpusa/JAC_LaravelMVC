<?php

namespace App\Http\Controllers;

use App\Models\Junta;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class WelcomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        $juntas = Junta::All();
        return view('welcome', compact('juntas'));
    }

}
