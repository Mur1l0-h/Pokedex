<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pokemon;

class PokemonController extends Controller
{
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

        $pokemon = Pokemon::create([
            'name' => $request->input('name'),
            'type' => $request->input('type1'),
            'height' => $request->input('height'),
            'weight' => $request->input('weight'),
            'hp' => $request->input('hp'),
            'attack' => $request->input('attack'),
            'defense' => $request->input('defense'),
            'official_artwork' => $filePath,
        ]);

        return redirect("/pikomon");
    }
}
