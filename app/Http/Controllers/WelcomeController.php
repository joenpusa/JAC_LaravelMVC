<?php

namespace App\Http\Controllers;

use App\Models\Junta;
use App\Models\Municipio;
use App\Models\Asociacion;
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
        $asociaciones = Asociacion::All();
        $municipios = Municipio::All();
        return view('welcome', compact('juntas', 'asociaciones', 'municipios'));
    }

}
