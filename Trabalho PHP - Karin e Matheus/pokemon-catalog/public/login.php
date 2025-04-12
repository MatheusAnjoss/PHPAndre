<?php
session_start();

// Usuário e senha fixos (senha armazenada com hash)
$validUsername = 'adm';
$validPasswordHash = password_hash('1234', PASSWORD_DEFAULT); // Substituir por um hash fixo gerado previamente

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $validUsername && password_verify($password, $validPasswordHash)) {
        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = $username;
        header('Location: redirecionar.php');
        exit;
    } else {
        $error = 'Usuário ou senha incorretos!';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body.login-page {
            background: url('../assets/loginfundo1.jpg') no-repeat center center fixed;
            background-size: cover;
            backdrop-filter: blur(5px);
            color: black;
            min-height: 100vh;
            margin: 0;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            min-height: calc(100vh - 120px); /* ajuste se necessário */
        }

        .login-page .btn-primary {
            background-color: red;
            border-color: red;
        }

        .login-page .btn-primary:hover {
            background-color: darkred;
            border-color: darkred;
        }

        header, footer {
            width: 100%;
        }
    </style>
</head>
<body class="login-page">
    <?php include '../src/includes/header.php'; ?>

    <div class="login-container">
        <div class="container">
            <h1 class="text-center">Login</h1>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="mx-auto" style="max-width: 400px;">
                <div class="mb-3">
                    <label for="username" class="form-label">Usuário</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
        </div>
    </div>

    <?php include '../src/includes/footer.php'; ?>
</body>
</html>
