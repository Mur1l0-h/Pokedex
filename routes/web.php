<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\PokemonRotaController;

// GET

Route::get('/pikomon', [PokemonRotaController::class, 'index']);

Route::get('/pikomon/create', [PokemonController::class, 'create']);
Route::post('/pikomon/registrar', [PokemonController::class, 'store']);

Route::get('/pokemon/{nome}', function ($nome){
    $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$nome}");

    if($response->successful()){
        $dados = $response->json();
        return response()->json([
            'status' => 'Requisição feita com sucesso',
            'resultado' => [
                'identificador' => $dados['id'],
                'nome_pokemon' => ucfirst($dados['name']),
                'foto' => $dados['sprites']['front_default']
            ]
        ], 200);
    }
    return response()->json(['erro' => 'pokemon não encontrado'], 404);
});


Route::post('/pokemon/novo', function (Request $request){
    $dados = $request->validate([
        'nome' => 'required|string|min:3',
        'tipo' => 'required|string',
        'ataque' => 'required|integer'
    ]);
    
    return response()->json([
        'mensagem' => 'Pokemon cadastrado com sucesso',
        'id_gerado' => rand(1000, 9999),
        'dados_recebidos' => $dados
    ], 201);

});

Route::get("/dummy/{nomeUser}", function($nomeUser){
    $response = Http::get("https://dummyjson.com/users/search?q={$nomeUser}&select=firstName,lastName,bloodGroup");

    if($response->successful()){
        $dados = $response->json();
        $first = $dados["users"][0];

        return response()->json([
            'status' => 'Requisição feita com sucesso',
            'query' => [
                'id' => $first['id'],
                'primeiro_nome' => $first['firstName'],
                'sobrenome' => $first['lastName'],
                'tipo_sangue' => $first['bloodGroup'],
            ]
        ], 200);
    }
    return $response()->json(['erro' => 'Erro ao procurar'], 404);
});

Route::post("/dummy/registrar", function(Request $request){
    $dados = $request->validate([
        'primeiro_nome' => 'required|string|min:3',
        'sobrenome' => 'required|string',
        'tipo_sangue' => 'required|string'
    ]);

    return response()->json([
        'mensagem' => 'Usuário cadastrado com sucesso',
        'id_gerado' => rand(1000, 9999),
        'dados_recebidos' => $dados
    ], 201);
});