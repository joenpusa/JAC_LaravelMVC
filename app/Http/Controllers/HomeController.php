<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Funcionario;
use App\Models\Junta;
use App\Models\Certificado;
use App\Models\Comuna;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

        // Certificados por mes
        $certificadosPorMes = Certificado::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as mes, COUNT(*) as total')
        ->where('created_at', '>=', Carbon::now()->subMonths(11)->startOfMonth())
        ->groupBy('mes')
        ->orderBy('mes')
        ->get()
        ->pluck('total', 'mes');

        // Juntas por municipio
        $juntasPorMunicipio = Junta::selectRaw('municipio_id, COUNT(*) as total')
        ->groupBy('municipio_id')
        ->with('municipio')
        ->get()
        ->mapWithKeys(function ($item) {
            return [$item->municipio->nombre_municipio => $item->total];
        });

        return view('home', compact('funcionarios', 'juntas', 'certificados', 'comunas', 'certificadosPorMes', 'juntasPorMunicipio'));
    }
}
