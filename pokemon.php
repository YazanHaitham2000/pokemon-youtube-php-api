<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        #app {
            text-align: center;
            background: white;
            padding: 20px;
            border-radius: 10px;
        }
        #pokemon-input {
            padding: 10px;
            width: 200px;
            margin-right: 10px;
        }
        #search-button {
            padding: 10px 20px;
        }
        #pokemon-info {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div id="app">
        <h1>Pokemon</h1>
        <form method="post" action="">
            <input type="text" id="pokemon-input" name="pokemon-input" placeholder="Enter Pokémon name or ID">
            <button type="submit" id="search-button">Search</button>
        </form>
        <div id="pokemon-info">
            <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $pokemonInput = strtolower(trim($_POST['pokemon-input']));
                    if ($pokemonInput) {
                        $apiUrl = "https://pokeapi.co/api/v2/pokemon/$pokemonInput";
                        $response = file_get_contents($apiUrl);
                        if ($response !== false) {
                            $pokemon = json_decode($response, true);
                            if ($pokemon) {
                                echo "<h2>{$pokemon['name']} (#{$pokemon['id']})</h2>";
                                echo "<img src=\"{$pokemon['sprites']['front_default']}\" alt=\"{$pokemon['name']}\">";
                                echo "<p>Height: " . ($pokemon['height'] / 10) . " m</p>";
                                echo "<p>Weight: " . ($pokemon['weight'] / 10) . " kg</p>";
                                echo "<p>Type: " . implode(', ', array_map(function($typeInfo) {
                                    return $typeInfo['type']['name'];
                                }, $pokemon['types'])) . "</p>";
                            } else {
                                echo "<p>Failed to parse Pokémon data.</p>";
                            }
                        } else {
                            echo "<p>Pokémon not found.</p>";
                        }
                    } else {
                        echo "<p>Please enter a Pokémon name or ID.</p>";
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>
