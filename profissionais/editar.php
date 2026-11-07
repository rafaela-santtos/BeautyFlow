
<?php
require_once "../auth/proteger.php";
exigirLogin();

require_once "../config/conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Profissional não encontrado.");
}

$stmt = $conexao->prepare("SELECT * FROM profissionais WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$profissional = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$profissional) {
    die("Profissional não encontrado.");
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $especialidade = trim($_POST["especialidade"] ?? "");

    if ($nome == "" || $telefone == "") {

        $mensagem = "Preencha o nome e o telefone.";

    } else {

        $stmt = $conexao->prepare(
            "UPDATE profissionais
             SET nome = ?, telefone = ?, especialidade = ?
             WHERE id = ?"
        );

        $stmt->bind_param("sssi", $nome, $telefone, $especialidade, $id);

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: listar.php");
            exit;
        } else {
            $mensagem = "Erro ao atualizar profissional.";
            $stmt->close();
        }
    }

    $profissional["nome"] = $nome;
    $profissional["telefone"] = $telefone;
    $profissional["especialidade"] = $especialidade;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Profissional | BeautyFlow</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h1>BeautyFlow</h1>
    <h2>Editar Profissional</h2>

    <p><?php echo htmlspecialchars($mensagem); ?></p>

    <form method="POST">

        <label>Nome:</label><br>
        <input type="text" name="nome"
            value="<?php echo htmlspecialchars($profissional['nome']); ?>" required>

        <br><br>

        <label>Telefone:</label><br>
        <input type="text" name="telefone"
            value="<?php echo htmlspecialchars($profissional['telefone']); ?>" required>

        <br><br>

        <label>Especialidade:</label><br>
        <input type="text" name="especialidade"
            value="<?php echo htmlspecialchars($profissional['especialidade'] ?? ''); ?>">

        <br><br>

        <button type="submit">Salvar alterações</button>

    </form>

    <br>

    <a href="listar.php">Voltar para profissionais</a>

</body>
</html>
