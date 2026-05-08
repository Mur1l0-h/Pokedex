<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex | Register New</title>
    <link href="https://fonts.googleapis.com/css2?family=VT323&family=Flexo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { 
            background-color: #2b2b2b; 
            font-family: 'Flexo', sans-serif; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
            padding: 20px; 
        }

        .pokedex-device { 
            background-color: #cc0000; 
            border-radius: 15px; 
            padding: 20px; 
            box-shadow: inset -5px -5px 15px rgba(0,0,0,0.4), 10px 15px 25px rgba(0,0,0,0.6); 
            max-width: 450px; 
            width: 100%; 
            border: 3px solid #8b0000; 
            position: relative; 
        }

        .top-lights { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #8b0000; padding-bottom: 15px; }
        .main-lens { width: 60px; height: 60px; background: radial-gradient(#80d8ff, #01579b); border-radius: 50%; border: 5px solid #fff; box-shadow: 0 0 15px rgba(1, 87, 155, 0.8); }
        .mini-light { width: 15px; height: 15px; border-radius: 50%; border: 1px solid #444; }
        .light-red { background: radial-gradient(#ff8a80, #d50000); }
        .light-yellow { background: radial-gradient(#ffff8d, #ffd600); }
        .light-green { background: radial-gradient(#b2ff59, #64dd17); }

        .screen-bezel { background-color: #dfdfdf; border-radius: 10px 10px 10px 35px; padding: 15px; border: 2px solid #999; box-shadow: inset 2px 2px 5px rgba(0,0,0,0.3); margin-bottom: 15px; }
        
        .main-screen { 
            background-color: #222; 
            border-radius: 8px; 
            height: 480px; 
            overflow-y: auto; 
            border: 3px solid #111; 
            padding: 20px;
            color: #51ae5e; 
            font-family: 'VT323', monospace;
        }

        .reg-form label { display: block; margin-top: 15px; font-size: 18px; text-transform: uppercase; color: #fff; }
        .reg-form input, .reg-form select { 
            width: 100%; padding: 10px; border-radius: 4px; border: none; 
            background: #333; color: #fff; margin-top: 5px; box-sizing: border-box;
            font-size: 16px;
        }

        .controls-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
        }

        .hardware-submit-btn {
            background-color: #ffcb05;
            color: #222;
            border: 3px solid #b38a00;
            padding: 12px;
            flex-grow: 2;
            border-radius: 8px;
            font-weight: bold;
            font-size: 18px;
            cursor: pointer;
            font-family: 'Flexo', sans-serif;
            text-transform: uppercase;
            box-shadow: 2px 3px 0px #8b0000;
        }

        .hardware-submit-btn:active {
            transform: translateY(2px);
            box-shadow: 0px 1px 0px #8b0000;
        }

        .cancel-btn {
            background-color: #444;
            color: #fff;
            text-decoration: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
            border: 2px solid #111;
            text-align: center;
            flex-grow: 1;
            font-size: 14px;
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-thumb { background: #51ae5e; border-radius: 4px; }

        .data-screen {
            background-color: #51ae5e; 
            height: 50px; 
            border: 4px solid #444; 
            border-radius: 8px;
            box-shadow: inset 3px 3px 10px rgba(0,0,0,0.3);
        }

        /* --- NEW ERROR BOX STYLES --- */
        .error-box {
            background-color: #8b0000;
            color: #ff8a80;
            padding: 10px;
            border: 2px solid #ff5252;
            border-radius: 5px;
            margin-bottom: 15px;
            font-family: 'Flexo', sans-serif;
            font-size: 14px;
        }
        .error-box ul { margin: 0; padding-left: 20px; }

        /* Custom file upload styles */
        #official_artwork { width: 0.1px; height: 0.1px; opacity: 0; overflow: hidden; position: absolute; z-index: -1; }
        .custom-file-upload {
            display: block; width: 100%; padding: 10px; margin-top: 5px; background: #444; color: #51ae5e;   
            border: 2px dashed #51ae5e; border-radius: 4px; cursor: pointer; text-align: center;
            font-family: 'VT323', monospace; font-size: 18px; box-sizing: border-box; transition: all 0.2s;
        }
        .custom-file-upload:hover { background: #555; border-style: solid; color: #fff; }
        .file-selected { border-color: #ffcb05; color: #ffcb05; }
    </style>
</head>
<body>

<div class="pokedex-device">
    <div class="top-lights">
        <div class="main-lens"></div>
        <div class="mini-light light-red"></div>
        <div class="mini-light light-yellow"></div>
        <div class="mini-light light-green"></div>
    </div>

    <form action="{{ url('/pikomon/registrar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="screen-bezel">
            <div class="main-screen">
                <h2 style="margin-top: 0; color: #fff; border-bottom: 2px solid #51ae5e; padding-bottom: 5px;">REGISTER POKÉMON</h2>
                
                @if ($errors->any())
                    <div class="error-box">
                        <strong>ERROR DETECTED:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="reg-form">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter name..." required>

                    <label>Official Artwork</label>
                    <div class="file-upload-wrapper">
                        <input type="file" name="official_artwork" id="official_artwork" accept="image/*" onchange="updateFileName(this)">
                        <label for="official_artwork" class="custom-file-upload" id="file-label">
                            [ SELECT IMAGE FILE ]
                        </label>
                    </div>

                    <label>Primary Type</label>
                    <select name="type1">
                        <option value="grass" @if(old('type1') == 'grass') selected @endif>Grass</option>
                        <option value="fire" @if(old('type1') == 'fire') selected @endif>Fire</option>
                        <option value="water" @if(old('type1') == 'water') selected @endif>Water</option>
                        <option value="ground" @if(old('type2') == 'ground') selected @endif>Ground</option>
                        <option value="fighting" @if(old('type2') == 'fighting') selected @endif>Fighting</option>
                        <option value="bug" @if(old('type1') == 'bug') selected @endif>Bug</option>
                        <option value="normal" @if(old('type1') == 'normal') selected @endif>Normal</option>
                        <option value="electric" @if(old('type1') == 'electric') selected @endif>Electric</option>
                        <option value="psychic" @if(old('type1') == 'psychic') selected @endif>Psychic</option>
                        <option value="poison" @if(old('type1') == 'poison') selected @endif>Poison</option>
                        <option value="flying" @if(old('type1') == 'flying') selected @endif>Flying</option>
                    </select>

                    <label>Secondary Type (Optional)</label>
                    <select name="type2">
                        <option value="" @if(old('type2') == '') selected @endif>None</option>
                        <option value="grass" @if(old('type2') == 'grass') selected @endif>Grass</option>
                        <option value="fire" @if(old('type2') == 'fire') selected @endif>Fire</option>
                        <option value="water" @if(old('type2') == 'water') selected @endif>Water</option>
                        <option value="ground" @if(old('type2') == 'ground') selected @endif>Ground</option>
                        <option value="fighting" @if(old('type2') == 'fighting') selected @endif>Fighting</option>
                        <option value="bug" @if(old('type2') == 'bug') selected @endif>Bug</option>
                        <option value="normal" @if(old('type2') == 'normal') selected @endif>Normal</option>
                        <option value="electric" @if(old('type2') == 'electric') selected @endif>Electric</option>
                        <option value="psychic" @if(old('type2') == 'psychic') selected @endif>Psychic</option>
                        <option value="poison" @if(old('type2') == 'poison') selected @endif>Poison</option>
                        <option value="flying" @if(old('type2') == 'flying') selected @endif>Flying</option>
                    </select>

                    <label>Height (m)</label>
                    <input type="number" step="0.1" name="height" value="{{ old('height') }}" placeholder="0.7">

                    <label>Weight (kg)</label>
                    <input type="number" step="0.1" name="weight" value="{{ old('weight') }}" placeholder="6.9">

                    <label>Base HP</label>
                    <input type="number" name="hp" value="{{ old('hp') }}" placeholder="45">

                    <label>Attack</label>
                    <input type="number" name="attack" value="{{ old('attack') }}" placeholder="49">

                    <label>Defense</label>
                    <input type="number" name="defense" value="{{ old('defense') }}" placeholder="49">
                    
                    <label>Special Attack</label>
                    <input type="number" name="special-attack" value="{{ old('special-attack') }}" placeholder="65">

                    <label>Special Defense</label>
                    <input type="number" name="special-defense" value="{{ old('special-defense') }}" placeholder="65">

                    <label>Speed</label>
                    <input type="number" name="speed" value="{{ old('speed') }}" placeholder="45">
                </div>
            </div>
        </div>

        <div class="controls-row">
            <a href="{{ url('/pikomon') }}" class="cancel-btn">BACK</a>
            <button type="submit" class="hardware-submit-btn">SEND DATA</button>
        </div>
    </form>

    <div class="data-screen"></div>
</div>

<script>
    function updateFileName(input) {
        const label = document.getElementById('file-label');
        if (input.files && input.files.length > 0) {
            const fileName = input.files[0].name;
            label.innerText = "FILE: " + fileName;
            label.classList.add('file-selected');
        } else {
            label.innerText = "[ SELECT IMAGE FILE ]";
            label.classList.remove('file-selected');
        }
    }
</script>
</body>
</html>