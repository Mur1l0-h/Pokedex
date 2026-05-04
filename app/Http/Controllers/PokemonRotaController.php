<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonRotaController extends Controller
{
    public function index(Request $request){
        $busca = $request->input('pokemon') ?? 1;
        $nomeOuId = strtolower($busca);
        $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$nomeOuId}");

        if($response->successful()){
            $dataPoke = $response->json();
            return view('pokemon', compact("dataPoke"));
        }

        return back()->with("error", "Pokemon não encontrado");
    }

    public function create(){
        return view("create");
    }

    public function store(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'type1' => 'required|string',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'hp' => 'required|numeric',
            'attack' => 'required|numeric',
            'defense' => 'required|numeric',
            'official_artwork' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('official_artwork')) {
         
            $file = $request->file('official_artwork');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            $file->move(public_path('images'), $filename);
            $filePath = 'images/' . $filename;
        } else {
            $filePath = null;
        }        

        Pokemon::create($request);
        return redirect()->route("pikomon");
    }
}
