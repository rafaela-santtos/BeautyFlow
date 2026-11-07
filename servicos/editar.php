
<?php
require_once "../auth/proteger.php";
exigirLogin();

require_once "../config/conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Serviço não encontrado.");
}

$stmt = $conexao->prepare(
    "SELECT id, nome, descricao, duracao_minutos
     FROM servicos
     WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$servico = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$servico) {
    die("Serviço não encontrado.");
}

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
            "UPDATE servicos
             SET nome = ?, descricao = ?, duracao_minutos = ?
             WHERE id = ?"
        );

        $stmt->bind_param("ssii", $nome, $descricao, $duracao, $id);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: listar.php");
            exit;
        } else {
            $mensagem = "Erro ao atualizar serviço.";
            $stmt->close();
        }
    }

    $servico["nome"] = $nome;
    $servico["descricao"] = $descricao;
    $servico["duracao_minutos"] = $duracao;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Serviço | BeautyFlow</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h1>BeautyFlow</h1>
    <h2>Editar Serviço</h2>

    <p><?php echo htmlspecialchars($mensagem); ?></p>

    <form method="POST">

        <label>Nome do serviço:</label><br>
        <input
            type="text"
            name="nome"
            value="<?php echo htmlspecialchars($servico["nome"]); ?>"
            required
        >

        <br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao"><?php echo htmlspecialchars($servico["descricao"] ?? ""); ?></textarea>

        <br><br>

        <label>Duração (minutos):</label><br>
        <input
            type="number"
            name="duracao"
            min="1"
            value="<?php echo htmlspecialchars((string)$servico["duracao_minutos"]); ?>"
            required
        >

        <br><br>

        <button type="submit">Salvar alterações</button>

    </form>

    <br>

    <a href="listar.php">Voltar para serviços</a>

</body>
</html>
