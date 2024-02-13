<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
{
    // $perPage = $request->input('per_page', 10); // Nombre de résultats par page, par défaut 10
    // $cities = City::orderBy('city')->get();
    // $cities = City::all()->sortBy('city'); // Tri des villes par le champ 'city' par ordre alphabétique
    // return response()->json($cities);

    $perPage = $request->input('per_page', 50); // Nombre de résultats par page, par défaut 10
    $cities = City::orderBy('city')->paginate($perPage);
    return response()->json($cities);
}
}

