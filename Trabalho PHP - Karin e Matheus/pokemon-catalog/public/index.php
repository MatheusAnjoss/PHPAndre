<?php
session_start();
require_once '../src/utils/dados.php';

$pokemons = getPokemons();

if (isset($_SESSION['pokemons'])) {
    $pokemons = array_merge($pokemons, $_SESSION['pokemons']);
}

$favorites = array_slice($pokemons, 0, 3);
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
        </div>
    </div>
    <?php include '../src/includes/footer.php'; ?>
</body>
</html>