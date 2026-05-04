<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex | {{ ucfirst($dataPoke['name']) }}</title>
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

        /* --- Classic Pokedex Casing --- */
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

        /* --- Top Indicator Lights --- */
        .top-lights {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid #8b0000;
            padding-bottom: 15px;
        }

        .main-lens {
            width: 60px;
            height: 60px;
            background: radial-gradient(#80d8ff, #01579b);
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 0 15px rgba(1, 87, 155, 0.8), inset 5px 5px 10px rgba(255,255,255,0.6);
        }

        .mini-light {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            border: 1px solid #444;
        }
        .light-red { background: radial-gradient(#ff8a80, #d50000); }
        .light-yellow { background: radial-gradient(#ffff8d, #ffd600); }
        .light-green { background: radial-gradient(#b2ff59, #64dd17); }

        /* --- Main Image Screen --- */
        .screen-bezel {
            background-color: #dfdfdf;
            border-radius: 10px 10px 10px 35px;
            padding: 15px;
            border: 2px solid #999;
            box-shadow: inset 2px 2px 5px rgba(0,0,0,0.3);
            margin-bottom: 15px;
        }

        .main-screen {
            background-color: #222;
            border-radius: 8px;
            height: 220px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
            border: 3px solid #111;
        }

        #main-pokedex-img {
            max-width: 100%;
            max-height: 100%;
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.2));
            transition: all 0.3s ease;
        }

        /* --- Art Style Toggles --- */
        .style-toggle {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .style-btn {
            background-color: #444;
            color: white;
            border: 2px solid #222;
            padding: 3px 15px;
            border-radius: 15px;
            font-size: 12px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.2s;
        }

        .style-btn.active-style {
            background-color: #ffcb05;
            color: #222;
            border-color: #b38a00;
        }

        /* --- Mini Sprites Galleries --- */
        .gallery-group {
            display: none;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
        
        .gallery-group.active {
            display: flex;
        }

        .gallery-group img {
            width: 45px;
            height: 45px;
            background: rgba(0,0,0,0.1);
            border-radius: 5px;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border 0.2s;
        }
        .gallery-group img:hover { border: 2px solid #cc0000; background: rgba(0,0,0,0.2); }

        /* --- Controls (D-Pad and Search) --- */
        .controls-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .nav-btn {
            background-color: #222; color: #fff; text-decoration: none; padding: 10px 15px; 
            border-radius: 5px; font-weight: bold; box-shadow: 2px 2px 5px rgba(0,0,0,0.5); 
            border: 2px solid #111; cursor: pointer;
        }
        .nav-btn:active { transform: translateY(2px); box-shadow: 0 0 2px rgba(0,0,0,0.5); }

        .search-form { display: flex; gap: 5px; flex-grow: 1; margin: 0 10px; }
        .search-form input { width: 100%; padding: 10px; border-radius: 5px; border: none; background: #fff9c4; font-weight: bold; }
        .search-btn { background: #ffcb05; color: #222; border: none; padding: 10px; border-radius: 5px; font-weight: bold; cursor: pointer; }

        /* --- Tab Menu Buttons --- */
        .tab-menu {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            gap: 5px;
        }
        .tab-btn {
            flex-grow: 1;
            background-color: #444;
            color: white;
            border: 2px solid #222;
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'VT323', monospace;
            font-size: 18px;
            box-shadow: inset 1px 1px 3px rgba(255,255,255,0.2);
        }
        .tab-btn.active-tab {
            background-color: #51ae5e;
            color: #111;
            border-color: #111;
            font-weight: bold;
        }

        /* --- Digital Data Screen --- */
        .data-screen {
            background-color: #51ae5e; 
            border: 4px solid #444;
            border-radius: 8px;
            padding: 15px;
            color: #111;
            font-family: 'VT323', monospace; 
            font-size: 18px;
            box-shadow: inset 3px 3px 10px rgba(0,0,0,0.3);
            height: 160px;
            overflow-y: auto;
        }

        .data-header {
            display: flex; justify-content: space-between; border-bottom: 2px solid rgba(0,0,0,0.2); 
            padding-bottom: 5px; margin-bottom: 10px;
        }
        .data-header h2 { margin: 0; text-transform: uppercase; font-size: 24px; }

        .type-badge { background: #222; color: #fff; padding: 2px 8px; border-radius: 4px; font-size: 14px; text-transform: uppercase; }
        .data-row { margin-bottom: 8px; }

        /* Hide tabs by default */
        .tab-content { display: none; }
        .tab-content.active { display: block; }

        /* Stats Bar Styling */
        .stat-row { display: flex; align-items: center; margin-bottom: 5px; font-size: 16px; }
        .stat-label { width: 50px; font-weight: bold; text-transform: uppercase; }
        .stat-val { width: 30px; text-align: right; margin-right: 10px; }
        .stat-bar-bg { flex-grow: 1; background: rgba(0,0,0,0.2); height: 10px; border-radius: 5px; overflow: hidden; border: 1px solid #333; }
        .stat-bar-fill { height: 100%; background: #222; } 

        /* Moves and Items Grids */
        .grid-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5px;
            font-size: 16px;
            text-transform: capitalize;
        }
        .grid-item { background: rgba(0,0,0,0.1); padding: 2px 5px; border-radius: 3px; border-left: 3px solid #222;}

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: rgba(0,0,0,0.1); }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }

        .controls-row {
        display: flex;
        justify-content: space-between;
        align-items: center; /* Keeps arrows centered with the middle block */
        margin-bottom: 15px;
        gap: 10px;
    }

   .center-controls {
    display: flex;
    flex-direction: row; /* Changed from column to row */
    align-items: center;
    justify-content: center;
    gap: 10px;
    flex-grow: 1;
}

.add-pokemon-btn {
    background-color: #444;
    color: #51ae5e;
    text-decoration: none;
    padding: 10px 15px; /* Improved padding for the button */
    border-radius: 5px;
    font-weight: bold;
    text-align: center;
    border: 2px solid #111;
    font-family: 'VT323', monospace;
    font-size: 18px;
    transition: background 0.2s;
    white-space: nowrap; /* Prevents the text from wrapping */
}

.add-pokemon-btn:hover {
    background-color: #333;
    color: #fff;
}

/* Ensure the search form takes the remaining space or stays compact */
.search-form { 
    display: flex; 
    gap: 5px; 
    margin: 0;
    flex-grow: 1; 
}

.search-form input {
    flex-grow: 1; /* Allows input to expand */
    padding: 10px;
    border-radius: 5px;
    border: none;
    background: #fff9c4;
    font-weight: bold;
}
    </style>
</head>
<body>

@php
    $currentId = $dataPoke['id'];
    $prevId = $currentId > 1 ? $currentId - 1 : 1; 
    $nextId = $currentId + 1;
@endphp

<div class="pokedex-device">
    
    <div class="top-lights">
        <div class="main-lens"></div>
        <div class="mini-light light-red"></div>
        <div class="mini-light light-yellow"></div>
        <div class="mini-light light-green"></div>
    </div>

    <div class="screen-bezel">
        <div class="main-screen">
            <img id="main-pokedex-img" src="{{ $dataPoke['sprites']['other']['official-artwork']['front_default'] }}" alt="{{ $dataPoke['name'] }}">
        </div>

        <div class="style-toggle">
            <button class="style-btn active-style" onclick="toggleArtStyle('official', '{{ $dataPoke['sprites']['other']['official-artwork']['front_default'] }}', this)">Official</button>
            <button class="style-btn" onclick="toggleArtStyle('pixel', '{{ $dataPoke['sprites']['front_default'] }}', this)">Pixel</button>
        </div>

        <div id="gallery-official" class="gallery-group active">
            @if(isset($dataPoke['sprites']['other']['official-artwork']['front_default'])) 
                <img src="{{ $dataPoke['sprites']['other']['official-artwork']['front_default'] }}" onclick="swapSprite(this.src)" title="Official Front"> 
            @endif
            @if(isset($dataPoke['sprites']['other']['official-artwork']['front_shiny'])) 
                <img src="{{ $dataPoke['sprites']['other']['official-artwork']['front_shiny'] }}" onclick="swapSprite(this.src)" title="Official Shiny"> 
            @endif
        </div>

        <div id="gallery-pixel" class="gallery-group">
            @if($dataPoke['sprites']['front_default']) 
                <img src="{{ $dataPoke['sprites']['front_default'] }}" onclick="swapSprite(this.src)" title="Front"> 
            @endif
            @if($dataPoke['sprites']['back_default']) 
                <img src="{{ $dataPoke['sprites']['back_default'] }}" onclick="swapSprite(this.src)" title="Back"> 
            @endif
            @if($dataPoke['sprites']['front_shiny']) 
                <img src="{{ $dataPoke['sprites']['front_shiny'] }}" onclick="swapSprite(this.src)" title="Shiny Front"> 
            @endif
            @if($dataPoke['sprites']['back_shiny']) 
                <img src="{{ $dataPoke['sprites']['back_shiny'] }}" onclick="swapSprite(this.src)" title="Shiny Back"> 
            @endif
        </div>
    </div>

    

   <div class="controls-row">
    <a href="{{ url('/pikomon?pokemon=' . $prevId) }}" class="nav-btn">◄</a>
    
    <div class="center-controls">
        <a href="{{ url('/pikomon/create') }}" class="add-pokemon-btn" style="width: 30%;">ADD POKEMON</a>
        
        <form class="search-form" method="GET" action="{{ url('/pikomon') }}">
            <input type="text" name="pokemon" style="width: 30%" placeholder="ID or Name..." required>
            <button type="submit" class="search-btn">GO</button>
        </form>
    </div>

    <a href="{{ url('/pikomon?pokemon=' . $nextId) }}" class="nav-btn">►</a>
</div>
    
    <div class="tab-menu">
        <button class="tab-btn active-tab" onclick="openTab('info', this)">INFO</button>
        <button class="tab-btn" onclick="openTab('stats', this)">STATS</button>
        <button class="tab-btn" onclick="openTab('moves', this)">MOVES</button>
        <button class="tab-btn" onclick="openTab('items', this)">ITEMS</button>
    </div>

    <div class="data-screen">
        
        <div id="tab-info" class="tab-content active">
            <div class="data-header">
                <h2>{{ $dataPoke['name'] }}</h2>
                <span>#{{ str_pad($dataPoke['id'], 3, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="data-row">
                <strong>TYPE:</strong> 
                @foreach($dataPoke['types'] as $tipo)
                    <span class="type-badge">{{ $tipo['type']['name'] }}</span>
                @endforeach
            </div>
            <div class="data-row">
                <strong>HT:</strong> {{ $dataPoke['height'] / 10 }}m | <strong>WT:</strong> {{ $dataPoke['weight'] / 10 }}kg
            </div>
            <div class="data-row">
                <strong>ABILITIES:</strong><br>
                @foreach($dataPoke['abilities'] as $ability)
                    <span style="text-transform: capitalize;">- {{ $ability['ability']['name'] }} @if($ability['is_hidden']) <em>(Hidden)</em> @endif</span><br>
                @endforeach
            </div>
        </div>

        <div id="tab-stats" class="tab-content">
            <div style="margin-bottom: 10px;"><strong>BASE STATS:</strong></div>
            @foreach($dataPoke['stats'] as $stat)
                @php
                    $statName = $stat['stat']['name'];
                    if($statName == 'special-attack') $statName = 'sp.a';
                    if($statName == 'special-defense') $statName = 'sp.d';
                    $barWidth = min(($stat['base_stat'] / 150) * 100, 100);
                @endphp
                <div class="stat-row">
                    <div class="stat-label">{{ $statName }}</div>
                    <div class="stat-val">{{ str_pad($stat['base_stat'], 3, '0', STR_PAD_LEFT) }}</div>
                    <div class="stat-bar-bg">
                        <div class="stat-bar-fill" style="width: {{ $barWidth }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="tab-moves" class="tab-content">
            <div style="margin-bottom: 10px;"><strong>KNOWN MOVES ({{ count($dataPoke['moves']) }}):</strong></div>
            <div class="grid-list">
                @foreach($dataPoke['moves'] as $move)
                    <div class="grid-item">{{ str_replace('-', ' ', $move['move']['name']) }}</div>
                @endforeach
            </div>
        </div>

        <div id="tab-items" class="tab-content">
            <div style="margin-bottom: 10px;"><strong>HELD ITEMS:</strong></div>
            @if(count($dataPoke['held_items']) > 0)
                <div class="grid-list">
                    @foreach($dataPoke['held_items'] as $item)
                        <div class="grid-item">{{ str_replace('-', ' ', $item['item']['name']) }}</div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; margin-top: 20px;">
                    <em>NO HELD ITEMS RECORDED IN DATABASE</em>
                </div>
            @endif
        </div>

    </div>

</div>

<script>
    // Handle Sprite Swapping inside the gallery
    function swapSprite(newImageUrl) {
        document.getElementById('main-pokedex-img').src = newImageUrl;
    }

    // Handle toggling between Official Art and Pixel Art
    function toggleArtStyle(styleType, defaultImg, buttonElement) {
        // Change the main image to the default of the selected style
        if(defaultImg) {
            document.getElementById('main-pokedex-img').src = defaultImg;
        }

        // Hide all galleries and show the requested one
        document.querySelectorAll('.gallery-group').forEach(group => group.classList.remove('active'));
        document.getElementById('gallery-' + styleType).classList.add('active');

        // Update active button colors
        document.querySelectorAll('.style-btn').forEach(btn => btn.classList.remove('active-style'));
        buttonElement.classList.add('active-style');
    }

    // Handle Tab Switching in the green data screen
    function openTab(tabId, buttonElement) {
        const contents = document.querySelectorAll('.tab-content');
        contents.forEach(content => content.classList.remove('active'));

        const buttons = document.querySelectorAll('.tab-btn');
        buttons.forEach(btn => btn.classList.remove('active-tab'));

        document.getElementById('tab-' + tabId).classList.add('active');
        buttonElement.classList.add('active-tab');
    }
</script>
</body>
</html>