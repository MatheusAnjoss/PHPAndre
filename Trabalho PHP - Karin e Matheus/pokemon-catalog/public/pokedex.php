<?php
session_start();
require_once '../src/utils/dados.php';

$pokemons = [
    1 => ['name' => 'Bulbasaur', 'description' => 'Um Pokémon planta que cresce com a luz do sol.'],
    2 => ['name' => 'Ivysaur', 'description' => 'A evolução de Bulbasaur com uma flor em suas costas.'],
    3 => ['name' => 'Venusaur', 'description' => 'A forma final de Bulbasaur, com uma flor gigante.'],
    4 => ['name' => 'Charmander', 'description' => 'Um Pokémon de fogo com uma chama na cauda.'],
    5 => ['name' => 'Charmeleon', 'description' => 'A evolução de Charmander, mais agressivo.'],
    6 => ['name' => 'Charizard', 'description' => 'A forma final de Charmander, que pode voar.'],
    7 => ['name' => 'Squirtle', 'description' => 'Um Pokémon aquático com uma carapaça dura.'],
    8 => ['name' => 'Wartortle', 'description' => 'A evolução de Squirtle, com orelhas peludas.'],
    9 => ['name' => 'Blastoise', 'description' => 'A forma final de Squirtle, com canhões de água.'],
    10 => ['name' => 'Caterpie', 'description' => 'Um Pokémon inseto que evolui rapidamente.'],
    11 => ['name' => 'Metapod', 'description' => 'A evolução de Caterpie, com uma carapaça dura.'],
    12 => ['name' => 'Butterfree', 'description' => 'A forma final de Caterpie, que pode voar.'],
    13 => ['name' => 'Weedle', 'description' => 'Um Pokémon inseto com um ferrão venenoso.'],
    14 => ['name' => 'Kakuna', 'description' => 'A evolução de Weedle, com uma carapaça protetora.'],
    15 => ['name' => 'Beedrill', 'description' => 'A forma final de Weedle, com ferrões perigosos.'],
    16 => ['name' => 'Pidgey', 'description' => 'Um Pokémon pássaro comum que pode voar.'],
    17 => ['name' => 'Pidgeotto', 'description' => 'A evolução de Pidgey, mais forte e rápido.'],
    18 => ['name' => 'Pidgeot', 'description' => 'A forma final de Pidgey, com asas poderosas.'],
    19 => ['name' => 'Rattata', 'description' => 'Um Pokémon roedor rápido e ágil.'],
    20 => ['name' => 'Raticate', 'description' => 'A evolução de Rattata, com dentes afiados.'],
    21 => ['name' => 'Spearow', 'description' => 'Um Pokémon pássaro agressivo e rápido.'],
    22 => ['name' => 'Fearow', 'description' => 'A evolução de Spearow, com asas grandes.'],
    23 => ['name' => 'Ekans', 'description' => 'Um Pokémon cobra que pode enrolar em seus inimigos.'],
    24 => ['name' => 'Arbok', 'description' => 'A evolução de Ekans, com padrões assustadores.'],
    25 => ['name' => 'Pikachu', 'description' => 'Um Pokémon elétrico conhecido por suas bochechas.']
];

// Merge Pokémon adicionados dinamicamente
if (isset($_SESSION['pokemons'])) {
    foreach ($_SESSION['pokemons'] as $newPokemon) {
        $pokemons[$newPokemon['pokedex_number']] = [
            'name' => $newPokemon['name'],
            'description' => $newPokemon['description'],
            'generation' => $newPokemon['generation']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokédex</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/pokedex.css"> <!-- Adicionado link para pokedex.css -->
</head>
<body>
    <?php include '../src/includes/header.php'; ?>
    <div class="pokedex">
        <h1>Pokédex</h1>
        <img src="assets/pokedex.png" alt="Pokédex" style="width: 100%; height: auto; object-fit: contain;">
        <div class="pokemon-display">
            <?php
            $search = $_GET['search'] ?? null;
            if ($search && isset($pokemons[$search])) {
                $pokemon = $pokemons[$search];
                echo "<img src='https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/{$search}.png' alt='{$pokemon['name']}'>";
            } elseif ($search) {
                echo "<p>Pokémon ainda não foi encontrado.</p>";
            } else {
                echo "<p>Pesquise um Pokémon</p>";
            }
            ?>
        </div>
        <div class="search-area">
            <form method="GET" style="display: flex; align-items: center;">
                <input type="text" id="search" name="search" class="form-control" placeholder="Nome ou Número">
                <button type="submit"></button>
            </form>
            <?php
            if ($search && isset($pokemons[$search])) {
                $pokemon = $pokemons[$search];
                echo "<div class='pokedex-info'>";
                echo "<p>Número na Pokédex: {$search}</p>";
                echo "<p>Descrição: {$pokemon['description']}</p>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>