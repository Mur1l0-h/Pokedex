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

        $localPokemon = Pokemon::where('name', $nomeOuId)->orWhere('id', $nomeOuId)->first();

        if ($localPokemon) {
            // 1. Build the types array dynamically
            $typesArray = [
                ['type' => ['name' => $localPokemon->type]]
            ];
            
            // If the database has a type2, push it into the array!
            if (!empty($localPokemon->type2)) {
                $typesArray[] = ['type' => ['name' => $localPokemon->type2]];
            }

            $dataPoke = [
                'id' => $localPokemon->id,
                'name' => $localPokemon->name,
                'height' => $localPokemon->height * 10, 
                'weight' => $localPokemon->weight * 10,
                'types' => $typesArray, // <-- Use the dynamic array here
                'stats' => [
                    ['stat' => ['name' => 'hp'], 'base_stat' => $localPokemon->hp],
                    ['stat' => ['name' => 'attack'], 'base_stat' => $localPokemon->attack],
                    ['stat' => ['name' => 'defense'], 'base_stat' => $localPokemon->defense],
                    ['stat' => ['name' => 'special-attack'], 'base_stat' => $localPokemon->{'special-attack'}],
                    ['stat' => ['name' => 'special-defense'], 'base_stat' => $localPokemon->{'special-defense'}],
                    ['stat' => ['name' => 'speed'], 'base_stat' => $localPokemon->speed],
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
            'type2' => 'nullable|string',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'hp' => 'required|numeric',
            'attack' => 'required|numeric',
            'defense' => 'required|numeric',
            'speed' => 'required|numeric',
            'special-attack' => 'required|numeric',
            'special-defense' => 'required|numeric',
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

      
        $lastPokemon = Pokemon::orderBy('id', 'desc')->first();
        
        $nextId = ($lastPokemon && $lastPokemon->id >= 90000) ? $lastPokemon->id + 1 : 90000;

        Pokemon::create([
            'id' => $nextId, // <-- ASSIGN THE CUSTOM ID HERE
            'name' => strtolower($request->input('name')),
            'type' => $request->input('type1'),
            'type2' => $request->input('type2'),
            'height' => $request->input('height'),
            'weight' => $request->input('weight'),
            'hp' => $request->input('hp'),
            'attack' => $request->input('attack'),
            'defense' => $request->input('defense'),
            'speed' => $request->input('speed'),
            'special-attack' => $request->input('special-attack'),
            'special-defense' => $request->input('special-defense'),
            'official_artwork' => $filePath,
        ]);

        return redirect('/pikomon');
    }
}