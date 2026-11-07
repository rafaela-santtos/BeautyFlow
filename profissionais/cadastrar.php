
<?php
require_once "../auth/proteger.php";
exigirLogin();

require_once "../config/conexao.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $especialidade = trim($_POST["especialidade"] ?? "");

    if ($nome == "" || $telefone == "") {

        $mensagem = "Preencha o nome e o telefone.";

    } else {

        $stmt = $conexao->prepare(
            "INSERT INTO profissionais (nome, telefone, especialidade)
             VALUES (?, ?, ?)"
        );

        $stmt->bind_param("sss", $nome, $telefone, $especialidade);

        if ($stmt->execute()) {
            $mensagem = "Profissional cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar profissional.";
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
    <title>Cadastrar Profissional | BeautyFlow</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h1>BeautyFlow</h1>
    <h2>Cadastro de Profissionais</h2>

    <p><?php echo htmlspecialchars($mensagem); ?></p>

    <form method="POST">

        <label>Nome:</label><br>
        <input type="text" name="nome" required>

        <br><br>

        <label>Telefone:</label><br>
        <input type="text" name="telefone" required>

        <br><br>

        <label>Especialidade:</label><br>
        <input type="text" name="especialidade">

        <br><br>

        <button type="submit">Cadastrar Profissional</button>

    </form>

    <br>
    <a href="listar.php">Voltar para profissionais</a>

    <br><br>
    <a href="../index.php">Voltar ao início</a>

</body>
</html>
