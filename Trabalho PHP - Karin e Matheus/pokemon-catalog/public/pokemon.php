<?php
session_start();
require_once '../src/utils/data.php';

$id = $_GET['id'] ?? null;
$pokemon = null;

if ($id) {
    $pokemons = getPokemons();
    foreach ($pokemons as $p) {
        if ($p['id'] == $id) {
            $pokemon = $p;
            break;
        }
    }
}

include '../src/includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Pokémon</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .content-wrapper {
            margin-bottom: 100px;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <div class="container mt-5">
            <?php if ($pokemon): ?>
                <div class="card">
                    <img src="<?= $pokemon['image'] ?>" class="card-img-top" alt="<?= $pokemon['name'] ?>">
                    <div class="card-body">
                        <h5 class="card-title text-danger"><?= $pokemon['name'] ?></h5>
                        <p class="card-text">Tipo: <?= $pokemon['type'] ?></p>
                        <p class="card-text">Número na Pokédex: <?= $pokemon['pokedex_number'] ?></p>
                        <p class="card-text">Geração: <?= $pokemon['generation'] ?></p>
                        <p class="card-text">Descrição: <?= $pokemon['description'] ?? 'Sem descrição disponível.' ?></p>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-center">Pokémon não encontrado.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include '../src/includes/footer.php'; ?>
</body>
</html>
