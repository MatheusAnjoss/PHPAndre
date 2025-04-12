<?php
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function isValidUrl($url) {
    return filter_var($url, FILTER_VALIDATE_URL) && preg_match('/^https:\/\//', $url);
}

function isValidPositiveInteger($number) {
    return is_numeric($number) && (int)$number > 0;
}

function isValidValue($value, $validValues) {
    return in_array($value, $validValues, true);
}

function pokemonExists($pokemons, $name, $pokedexNumber) {
    foreach ($pokemons as $pokemon) {
        if ($pokemon['name'] === $name || $pokemon['pokedex_number'] == $pokedexNumber) {
            return true;
        }
    }
    return false;
}
