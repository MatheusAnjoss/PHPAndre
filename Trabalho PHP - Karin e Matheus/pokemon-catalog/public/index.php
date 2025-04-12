<?php
session_start();
require_once '../src/utils/dados.php';

$pokemons = getPokemons();

if (isset($_SESSION['pokemons'])) {
    $pokemons = array_merge($pokemons, $_SESSION['pokemons']);
}

$favoritesFromSession = $_SESSION['favorites'] ?? [];
$favorites = array_merge($favoritesFromSession, array_slice($pokemons, 0, 3));

$favorites = array_unique($favorites, SORT_REGULAR);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Pokémons</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include '../src/includes/header.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center">Pokémons Favoritos</h1>
        <div class="row">
            <?php if (empty($favorites)): ?>
                <p class="text-center">Nenhum Pokémon favorito encontrado.</p>
            <?php else: ?>
                <?php foreach ($favorites as $pokemon): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?= $pokemon['image'] ?>" class="card-img-top" alt="<?= $pokemon['name'] ?>">
                            <div class="card-body">
                                <h5 class="card-title text-danger"><?= $pokemon['name'] ?></h5>
                                <p class="card-text">Tipo: <?= $pokemon['type'] ?></p>
                                <p class="card-text">Número na Pokédex: <?= $pokemon['pokedex_number'] ?></p>
                                <p class="card-text">Geração: <?= $pokemon['generation'] ?></p>
                                <a href="detalhes.php?id=<?= $pokemon['id'] ?>" class="btn btn-danger">Ver mais</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php include '../src/includes/footer.php'; ?>
</body>
</html>
