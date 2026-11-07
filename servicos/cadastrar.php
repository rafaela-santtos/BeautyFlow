
<?php
require_once "../auth/proteger.php";
exigirLogin();

require_once "../config/conexao.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $descricao = trim($_POST["descricao"] ?? "");
    $duracao = filter_input(INPUT_POST, "duracao", FILTER_VALIDATE_INT);

    if (
        $nome == "" ||
        $duracao === false ||
        $duracao === null ||
        $duracao <= 0
    ) {
        $mensagem = "Preencha corretamente o nome e a duração.";
    } else {
        $stmt = $conexao->prepare(
            "INSERT INTO servicos (nome, descricao, duracao_minutos)
             VALUES (?, ?, ?)"
        );

        $stmt->bind_param("ssi", $nome, $descricao, $duracao);

        if ($stmt->execute()) {
            $mensagem = "Serviço cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar serviço: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Serviço | BeautyFlow</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h1>BeautyFlow</h1>
    <h2>Cadastro de Serviços</h2>

    <p><?php echo htmlspecialchars($mensagem); ?></p>

    <form method="POST">

        <label>Nome do serviço:</label><br>
        <input type="text" name="nome" required>

        <br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao"></textarea>

        <br><br>

        <label>Duração (minutos):</label><br>
        <input type="number" name="duracao" min="1" required>

        <br><br>

        <button type="submit">Cadastrar Serviço</button>

    </form>

    <br>
    <a href="listar.php">Voltar para serviços</a>

    <br><br>
    <a href="../index.php">Voltar ao início</a>

</body>
</html>

