<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/header.css"> <!-- Certifique-se de que o caminho está correto -->
    <title>Pokémon Catálogo</title>
</head>
<body>
<header class="navbar d-flex justify-content-between align-items-center nav-red">
    <h1 class="ms-3">Pokémon Catálogo</h1> <!-- Título alinhado à esquerda -->
    <nav class="d-flex gap-3 me-3"> <!-- Botões alinhados lado a lado -->
        <a href="index.php" class="nav-link">Home</a>
        <a href="filtrar.php" class="nav-link">Filtrar</a> <!-- Sempre visível -->
        <a href="<?= isset($_SESSION['logged_in']) && $_SESSION['logged_in'] ? 'protegido.php' : 'login.php' ?>" class="nav-link">Administração</a>
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
            <a href="deslogar.php" class="nav-link">Deslogar</a>
        <?php else: ?>
            <a href="login.php" class="nav-link">Login</a>
        <?php endif; ?>
    </nav>
</header>
</body>
</html>
