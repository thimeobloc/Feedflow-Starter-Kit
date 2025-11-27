<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey; 

class StatsController extends Controller
{
    public function index($token = null)
    {
        // Si un token est fourni
        if ($token) {
            return view('surveys.stats', [
                'token' => $token
            ]);
        }

        // Sinon, page stats générale
        return view('surveys.stats');
    }

    public function store()
    {
        // Logique pour stocker les statistiques ou générer des rapports
        return redirect()->back()->with('status', 'Statistiques générées avec succès !');
    }
}