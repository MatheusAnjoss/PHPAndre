<?php
session_start();
require_once '../src/utils/dados.php';

$pokemons = array_merge(getPokemons(), $_SESSION['pokemons'] ?? []);

$id = $_GET['id'] ?? null;
$pokemon = null;

if ($id) {
    foreach ($pokemons as $p) {
        if ($p['id'] == $id) {
            $pokemon = $p;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Pokémon</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/detalhes.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include '../src/includes/header.php'; ?>
    <div class="container mt-5">
        <?php if ($pokemon): ?>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= htmlspecialchars($pokemon['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($pokemon['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title text-danger"><?= htmlspecialchars($pokemon['name']) ?></h5>
                            <p class="card-text"><strong>Tipo:</strong> <?= htmlspecialchars($pokemon['type']) ?></p>
                            <p class="card-text"><strong>Número na Pokédex:</strong> <?= htmlspecialchars($pokemon['pokedex_number']) ?></p>
                            <p class="card-text"><strong>Geração:</strong> <?= htmlspecialchars($pokemon['generation']) ?></p>
                            <p class="card-text"><strong>Descrição:</strong> <?= htmlspecialchars($pokemon['description']) ?></p>
                        </div>
                    </div>
                </div>
                <?php if (!empty($pokemon['card_new'])): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?= htmlspecialchars($pokemon['card_new']) ?>" class="card-img-top" alt="Carta Mais Nova">
                            <div class="card-body">
                                <h5 class="card-title text-danger">Carta Mais Nova</h5>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($pokemon['card_old'])): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?= htmlspecialchars($pokemon['card_old']) ?>" class="card-img-top" alt="Carta Mais Velha">
                            <div class="card-body">
                                <h5 class="card-title text-danger">Carta Mais Velha</h5>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-white">Pokémon não encontrado.</p>
        <?php endif; ?>
    </div>
    <?php include '../src/includes/footer.php'; ?>
</body>
</html>