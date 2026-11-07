

<?php
require_once "../auth/proteger.php";
exigirLogin();

require_once "../config/conexao.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $telefone = trim($_POST["telefone"]);
    $email = trim($_POST["email"]);

    if ($nome == "" || $telefone == "") {
        $mensagem = "Preencha o nome e o telefone.";
    } else {
        $sql = "INSERT INTO clientes (nome, telefone, email)
                VALUES (?, ?, ?)";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("sss", $nome, $telefone, $email);

        if ($stmt->execute()) {
            $mensagem = "Cliente cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar cliente.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Cliente | BeautyFlow</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h1>BeautyFlow</h1>
    <h2>Cadastro de Clientes</h2>

    <p><?php echo htmlspecialchars($mensagem); ?></p>

    <form method="POST">
        <label>Nome:</label><br>
        <input type="text" name="nome" required>
        <br><br>

        <label>Telefone:</label><br>
        <input type="text" name="telefone" required>
        <br><br>

        <label>E-mail:</label><br>
        <input type="email" name="email">
        <br><br>

        <button type="submit">Cadastrar Cliente</button>
    </form>

    <br>
    <a href="listar.php">Ver clientes cadastrados</a>

    <br><br>
    <a href="../index.php">Voltar ao menu principal</a>

</body>
</html>
