<?php

namespace App\Http\Controllers;

use App\Models\Ministere;
use App\Models\Procedure;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

public function index()
{
    
    $procedures = Procedure::all();
    $ministeres = Ministere::all(); // Récupère tous les ministères
return view('backend.index', compact('ministeres','procedures'));
}
}
