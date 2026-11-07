
<?php
session_start();

if (isset($_SESSION["usuario_id"])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | BeautyFlow</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f7f3fa;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .login-container {
            background: white;
            width: 100%;
            max-width: 400px;
            padding: 40px 30px;
            border-radius: 18px;
            box-shadow: 0 5px 25px rgba(60, 30, 70, 0.12);
            text-align: center;
        }

        .login-container img {
            width: 110px;
            height: auto;
            margin-bottom: 15px;
        }

        h1 {
            color: #54265f;
            margin-bottom: 8px;
        }

        p {
            color: #777;
            margin-bottom: 28px;
        }

        label {
            display: block;
            text-align: left;
            color: #54265f;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #d8c9df;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #8d5b9b;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #54265f;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #70417c;
        }

        .rodape {
            margin-top: 25px;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>

<body>

    <div class="login-container">

        <img src="../img/logo_js.png" alt="Logo JS">

        <h1>BeautyFlow</h1>
        <p>Entre com seus dados para acessar o sistema.</p>

        <form method="POST" action="verificar.php">

            <label for="usuario">Usuário</label>
            <input
                type="text"
                id="usuario"
                name="usuario"
                placeholder="Digite seu usuário"
                required
            >

            <label for="senha">Senha</label>
            <input
                type="password"
                id="senha"
                name="senha"
                placeholder="Digite sua senha"
                required
            >

            <button type="submit">Entrar</button>

        </form>

        <div class="rodape">
            BeautyFlow | Gestão de Salão
        </div>

    </div>

</body>
</html>
