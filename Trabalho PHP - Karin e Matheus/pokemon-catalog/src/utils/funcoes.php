<?php
function filterPokemonsByType($pokemons, $type) {
    return array_filter($pokemons, function ($pokemon) use ($type) {
        return !$type || stripos($pokemon['type'], $type) !== false;
    });
}

function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}