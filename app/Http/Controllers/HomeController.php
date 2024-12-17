<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;
use App\Models\Junta;
use App\Models\Certificado;
use App\Models\Comuna;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $funcionarios = Funcionario::count();
        $juntas = Junta::count();
        $certificados = Certificado::count();
        $comunas = Comuna::count();
        return view('home', compact('funcionarios', 'juntas', 'certificados', 'comunas'));
    }
}
