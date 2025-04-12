<?php
session_start();
require_once '../src/utils/dados.php';
require_once '../src/utils/funcoes.php'; // Adicionado para usar sanitizeInput

// Verifique se o usuário está logado
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

$pokemons = array_merge(getPokemons(), $_SESSION['pokemons'] ?? []);

$nameFilter = sanitizeInput($_GET['name'] ?? '');
$typeFilter = sanitizeInput($_GET['type'] ?? '');
$generationFilter = sanitizeInput($_GET['generation'] ?? '');

$filteredPokemons = array_filter($pokemons, function ($pokemon) use ($nameFilter, $typeFilter, $generationFilter) {
    $matchesName = !$nameFilter || stripos($pokemon['name'], $nameFilter) !== false;
    $matchesType = !$typeFilter || stripos($pokemon['type'], $typeFilter) !== false;
    $matchesGeneration = !$generationFilter || $pokemon['generation'] == $generationFilter;
    return $matchesName && $matchesType && $matchesGeneration;
});

// Lógica para excluir um Pokémon
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];
    if (isset($_SESSION['pokemons'])) {
        $_SESSION['pokemons'] = array_filter($_SESSION['pokemons'], function ($pokemon) use ($deleteId) {
            return $pokemon['id'] != $deleteId;
        });
    }
    header('Location: filtrar.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtrar Pokémons</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/filtrar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php include '../src/includes/header.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center text-white">Filtrar Pokémons</h1>
        <div class="row">
            <div class="col-md-9">
                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="name" class="form-label text-white">Filtrar por Nome</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Digite o nome do Pokémon" value="<?= htmlspecialchars($nameFilter) ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="type" class="form-label text-white">Filtrar por Tipo</label>
                            <select id="type" name="type" class="form-select">
                                <option value="">Todos os Tipos</option>
                                <?php foreach (array_unique(array_column($pokemons, 'type')) as $type): ?>
                                    <option value="<?= htmlspecialchars($type) ?>" <?= $type === $typeFilter ? 'selected' : '' ?>><?= htmlspecialchars($type) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="generation" class="form-label text-white">Filtrar por Geração</label>
                            <select id="generation" name="generation" class="form-select">
                                <option value="">Todas as Gerações</option>
                                <?php foreach (array_unique(array_column($pokemons, 'generation')) as $generation): ?>
                                    <option value="<?= htmlspecialchars($generation) ?>" <?= $generation == $generationFilter ? 'selected' : '' ?>>Geração <?= htmlspecialchars($generation) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger btn-sm">Filtrar</button>
                </form>
            </div>
            <div class="col-md-3 text-center">
                <a href="pokedex.php" id="pokedexicon" style="display: inline-block; width: 100px; height: auto;">
                    <img src="assets/pokedexicon.png" alt="Pokédex" class="pokedexicon" style="width: 100%; height: auto;">
                </a>
            </div>
        </div>
        <div class="row card-container">
            <?php if (empty($filteredPokemons)): ?>
                <p class="text-center text-white">Nenhum Pokémon encontrado.</p>
            <?php else: ?>
                <?php foreach ($filteredPokemons as $pokemon): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?= $pokemon['image'] ?>" class="card-img-top" alt="<?= $pokemon['name'] ?>">
                            <div class="card-body">
                                <h5 class="card-title text-danger"><?= $pokemon['name'] ?></h5>
                                <p class="card-text">Tipo: <?= $pokemon['type'] ?></p>
                                <p class="card-text">Número na Pokédex: <?= $pokemon['pokedex_number'] ?></p>
                                <p class="card-text">Geração: <?= $pokemon['generation'] ?></p>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="delete_id" value="<?= $pokemon['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                </form>
                                <a href="detalhes.php?id=<?= $pokemon['id'] ?>" class="btn btn-danger btn-sm">Ver mais</a>
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
