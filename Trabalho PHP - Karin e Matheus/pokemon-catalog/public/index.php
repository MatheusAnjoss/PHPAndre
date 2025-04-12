<?php
session_start();

require_once(__DIR__ . '/../src/utils/dados.php');

$pokemons = getPokemons();
if (isset($_SESSION['pokemons'])) {
    $pokemons = array_merge($pokemons, $_SESSION['pokemons']);
}

$favorites = $_SESSION['favorites'] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = (int)$_POST['delete_id'];

    if (isset($_SESSION['pokemons'])) {
        $_SESSION['pokemons'] = array_filter($_SESSION['pokemons'], fn($p) => $p['id'] !== $deleteId);
    }

    if (isset($_SESSION['favorites'])) {
        $_SESSION['favorites'] = array_filter($_SESSION['favorites'], fn($p) => $p['id'] !== $deleteId);
    }

    header('Location: index.php');
    exit;
}

$pokemonsToDisplay = array_filter($pokemons, function ($pokemon) {
    return in_array($pokemon['name'], ['Rayquaza', 'Eevee', 'Metagross']);
});
$pokemonsToDisplay = array_merge($pokemonsToDisplay, $favorites);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Catalog</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .button-group {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <?php include '../src/includes/header.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center">Pokémon Catalog</h1>
        <div class="row">
            <?php foreach ($pokemonsToDisplay as $pokemon): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= htmlspecialchars($pokemon['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($pokemon['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title text-danger"><?= htmlspecialchars($pokemon['name']) ?></h5>
                            <p class="card-text">Tipos: <?= htmlspecialchars($pokemon['type']) ?></p>
                            <p class="card-text">Número na Pokédex: <?= htmlspecialchars($pokemon['pokedex_number']) ?></p>
                            <p class="card-text">Geração: <?= htmlspecialchars($pokemon['generation']) ?></p>
                            <p class="card-text"><?= htmlspecialchars($pokemon['description']) ?></p>
                            <div class="button-group">
                                <a href="detalhes.php?id=<?= $pokemon['id'] ?>" class="btn btn-danger">Ver mais</a>
                                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                                    <form method="POST" style="margin: 0;">
                                        <input type="hidden" name="delete_id" value="<?= $pokemon['id'] ?>">
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include '../src/includes/footer.php'; ?>
</body>
</html>