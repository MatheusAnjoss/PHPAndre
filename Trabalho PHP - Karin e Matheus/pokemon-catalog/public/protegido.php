<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['user']) || $_SESSION['user'] !== 'adm') {
    header('Location: login.php');
    exit;
}

require_once(__DIR__ . '/../src/utils/dados.php');

$pokemons = getPokemons();
$validTypes = ['Normal', 'Fogo', 'Água', 'Elétrico', 'Grama', 'Gelo', 'Lutador', 'Venenoso', 'Terra', 'Voador', 'Psíquico', 'Inseto', 'Pedra', 'Fantasma', 'Dragão', 'Sombrio', 'Fada', 'Aço'];
$validGenerations = range(1, 9);
$error = '';

if (isset($_SESSION['pokemons'])) {
    $pokemons = array_merge($pokemons, $_SESSION['pokemons']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $types = $_POST['types'] ?? [];
    $generation = $_POST['generation'] ?? '';
    $pokedexNumber = $_POST['pokedex_number'] ?? '';
    $image = $_POST['image'] ?? '';
    $cardNew = $_POST['card_new'] ?? '';
    $cardOld = $_POST['card_old'] ?? '';
    $description = $_POST['description'] ?? '';
    $favorite = isset($_POST['favorite']) ? true : false;

    if (!filter_var($image, FILTER_VALIDATE_URL) || !preg_match('/^https:\/\//', $image)) {
        $error = 'A URL da imagem deve ser válida e começar com "https://".';
    } elseif ($cardNew && !filter_var($cardNew, FILTER_VALIDATE_URL)) {
        $error = 'A URL da carta nova deve ser válida, se fornecida.';
    } elseif ($cardOld && !filter_var($cardOld, FILTER_VALIDATE_URL)) {
        $error = 'A URL da carta velha deve ser válida, se fornecida.';
    } elseif (!in_array((int)$generation, $validGenerations)) {
        $error = 'Selecione uma geração válida.';
    } elseif (!is_numeric($pokedexNumber) || $pokedexNumber <= 0) {
        $error = 'O número na Pokédex deve ser um número válido e maior que 0.';
    } elseif (count($types) > 2 || array_diff($types, $validTypes)) {
        $error = 'Selecione até 2 tipos válidos.';
    } elseif (array_filter($pokemons, fn($p) => $p['name'] === $name || $p['pokedex_number'] == $pokedexNumber)) {
        $error = 'Já existe um Pokémon com o mesmo nome ou número na Pokédex.';
    } else {
        $newPokemon = [
            'id' => count($pokemons) + 1,
            'name' => $name,
            'type' => implode('/', $types),
            'generation' => $generation,
            'pokedex_number' => $pokedexNumber,
            'image' => $image,
            'card_new' => $cardNew,
            'card_old' => $cardOld,
            'description' => $description,
            'favorite' => $favorite
        ];

        if (!isset($_SESSION['pokemons'])) {
            $_SESSION['pokemons'] = [];
        }
        $_SESSION['pokemons'][] = $newPokemon;

        if ($favorite) {
            if (!isset($_SESSION['favorites'])) {
                $_SESSION['favorites'] = [];
            }
            $_SESSION['favorites'][] = $newPokemon;
        }

        if (!isset($_SESSION['pokedex'])) {
            $_SESSION['pokedex'] = [];
        }
        $_SESSION['pokedex'][] = [
            'id' => $newPokemon['id'],
            'name' => $newPokemon['name'],
            'description' => $newPokemon['description'],
            'generation' => $newPokemon['generation']
        ];

        $_SESSION['success_message'] = "Pokémon '{$newPokemon['name']}' foi adicionado com sucesso!";

        header('Location: protegido.php');
        exit;
    }
}

$successMessage = $_SESSION['success_message'] ?? null;
unset($_SESSION['success_message']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área Protegida</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/protegido.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function addType() {
            const typeSelect = document.getElementById('type-select');
            const selectedType = typeSelect.value;
            const typeList = document.getElementById('type-list');
            const existingTypes = Array.from(typeList.children).map(li => li.dataset.type);

            if (selectedType && !existingTypes.includes(selectedType) && existingTypes.length < 2) {
                const li = document.createElement('li');
                li.textContent = selectedType;
                li.dataset.type = selectedType;

                const removeButton = document.createElement('button');
                removeButton.textContent = 'x';
                removeButton.className = 'remove-type';
                removeButton.onclick = () => li.remove();

                li.appendChild(removeButton);
                typeList.appendChild(li);

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'types[]';
                hiddenInput.value = selectedType;
                li.appendChild(hiddenInput);
            }
        }
    </script>
</head>
<body>
    <?php include '../src/includes/header.php'; ?>
    <div class="container mt-5">
        <?php if ($successMessage): ?>
            <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>

        <h1 class="text-center" style="color: white;">Administração</h1>
        <p class="text-center">Bem-vindo à área de administração.</p>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST" class="mb-4">
            <div class="mb-3">
                <label for="name" class="form-label">Nome do Pokémon</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="type-select" class="form-label">Tipo</label>
                <select id="type-select" class="form-select" required>
                    <option value="">Selecione um tipo</option>
                    <?php foreach ($validTypes as $validType): ?>
                        <option value="<?= $validType ?>"><?= $validType ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="button" class="btn btn-red mt-2" onclick="addType()">Adicionar Tipo</button>
                <ul id="type-list" class="type-list"></ul>
                <small class="form-text text-white">Selecione até 2 tipos.</small>
            </div>
            <div class="mb-3">
                <label for="generation" class="form-label">Geração</label>
                <select id="generation" name="generation" class="form-select" required>
                    <option value="">Selecione uma geração</option>
                    <?php foreach ($validGenerations as $gen): ?>
                        <option value="<?= $gen ?>"><?= $gen ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="pokedex_number" class="form-label">Número na Pokédex</label>
                <input type="number" id="pokedex_number" name="pokedex_number" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">URL da Imagem</label>
                <input type="text" id="image" name="image" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="card_new" class="form-label">URL da Carta Nova</label>
                <input type="text" id="card_new" name="card_new" class="form-control">
            </div>
            <div class="mb-3">
                <label for="card_old" class="form-label">URL da Carta Antiga</label>
                <input type="text" id="card_old" name="card_old" class="form-control">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descrição</label>
                <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" id="favorite" name="favorite" class="form-check-input">
                <label for="favorite" class="form-check-label">Marcar como Pokémon Favorito</label>
            </div>
            <button type="submit" class="btn btn-red">Adicionar Pokémon</button>
        </form>
    </div>
    <?php include '../src/includes/footer.php'; ?>
</body>
</html>