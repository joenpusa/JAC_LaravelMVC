<?php

namespace App\Http\Controllers;

use App\Models\Junta;

use Illuminate\Http\Request;


class WelcomeController extends Controller
{
    public function index()
    {
        $juntas = Junta::All();
        return view('welcome', compact('juntas'));
    }

}
