<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pokemon;
use Illuminate\Support\Facades\Http;


class PokemonController extends Controller
{
    public function index(Request $request){
        $busca = $request->input('pokemon') ?? 1;
        $nomeOuId = strtolower($busca);

        // 1. FIRST check the local database
        $localPokemon = Pokemon::where('name', $nomeOuId)->orWhere('id', $nomeOuId)->first();

        if ($localPokemon) {
            // Reconstruct the data array so the Blade view thinks it came from the API
            $dataPoke = [
                'id' => $localPokemon->id,
                'name' => $localPokemon->name,
                'height' => $localPokemon->height * 10, 
                'weight' => $localPokemon->weight * 10,
                'types' => [
                    ['type' => ['name' => $localPokemon->type]]
                ],
                'stats' => [
                    ['stat' => ['name' => 'hp'], 'base_stat' => $localPokemon->hp],
                    ['stat' => ['name' => 'attack'], 'base_stat' => $localPokemon->attack],
                    ['stat' => ['name' => 'defense'], 'base_stat' => $localPokemon->defense],
                    ['stat' => ['name' => 'special-attack'], 'base_stat' => 0],
                    ['stat' => ['name' => 'special-defense'], 'base_stat' => 0],
                    ['stat' => ['name' => 'speed'], 'base_stat' => 0],
                ],
                'abilities' => [
                    ['ability' => ['name' => 'Local Custom'], 'is_hidden' => false]
                ],
                'moves' => [
                    ['move' => ['name' => 'tackle']]
                ],
                'held_items' => [],
                'sprites' => [
                    'front_default' => asset($localPokemon->official_artwork),
                    'back_default' => null,
                    'front_shiny' => null,
                    'back_shiny' => null,
                    'other' => [
                        'official-artwork' => [
                            'front_default' => asset($localPokemon->official_artwork), 
                            'front_shiny' => null,
                        ]
                    ]
                ]
            ];

            return view('pokemon', compact("dataPoke"));
        }

        // 2. If NOT found locally, query the official API
        $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$nomeOuId}");

        if($response->successful()){
            $dataPoke = $response->json();
            return view('pokemon', compact("dataPoke"));
        }

        return back()->with("error", "Pokémon não encontrado!");
    }

    public function create(){
        return view("create");
    }

    public function store(Request $request){

        // Validate form input
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

        // Process image upload
        if ($request->hasFile('official_artwork')) {
            $file = $request->file('official_artwork');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            $file->move(public_path('images'), $filename);
            $filePath = 'images/' . $filename;
        } else {
            $filePath = null;
        }        

        // Save to Database
        Pokemon::create([
            'name' => strtolower($request->input('name')), // Ensure it saves lowercase for searching
            'type' => $request->input('type1'),
            'height' => $request->input('height'),
            'weight' => $request->input('weight'),
            'hp' => $request->input('hp'),
            'attack' => $request->input('attack'),
            'defense' => $request->input('defense'),
            'official_artwork' => $filePath,
        ]);

        // THIS IS THE FIX FOR THE NON-REDIRECT!
        // This tells Laravel to push the browser back to the main Pokedex screen
        return redirect('/pikomon');
    }
}
