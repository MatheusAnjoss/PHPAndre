<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecionando</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            text-align: center;
            overflow: hidden;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .pokeball {
            width: 100px;
            height: 100px;
            background: url('assets/pokebola.png') no-repeat center center;
            background-size: contain;
            animation: spin 2s linear infinite;
        }
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        h1 {
            font-size: 24px;
            color: #333;
            margin-top: 20px;
        }
    </style>
    <script>
        setTimeout(() => {
            window.location.href = 'index.php';
        }, 3000);
    </script>
</head>
<body>
    <div class="container">
        <div class="pokeball"></div>
        <h1>Redirecionando para a página inicial...</h1>
    </div>
</body>
</html>