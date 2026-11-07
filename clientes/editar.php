
<?php
require_once "../auth/proteger.php";
exigirLogin();

require_once "../config/conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Cliente não encontrado.");
}

$stmt = $conexao->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$cliente = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$cliente) {
    die("Cliente não encontrado.");
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $telefone = trim($_POST["telefone"]);
    $email = trim($_POST["email"]);

    if ($nome == "" || $telefone == "") {
        $mensagem = "Preencha o nome e o telefone.";
    } else {
        $stmt = $conexao->prepare(
            "UPDATE clientes SET nome = ?, telefone = ?, email = ? WHERE id = ?"
        );
        $stmt->bind_param("sssi", $nome, $telefone, $email, $id);

        if ($stmt->execute()) {
            header("Location: listar.php");
            exit;
        } else {
            $mensagem = "Erro ao atualizar cliente.";
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
    <title>Editar Cliente | BeautyFlow</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<main class="pagina-inicial">

    <h1>BeautyFlow</h1>
    <h2>Editar Cliente</h2>

    <p><?php echo htmlspecialchars($mensagem); ?></p>

    <form method="POST">
        <label>Nome:</label><br>
        <input type="text" name="nome"
            value="<?php echo htmlspecialchars($cliente['nome']); ?>" required>
        <br><br>

        <label>Telefone:</label><br>
        <input type="text" name="telefone"
            value="<?php echo htmlspecialchars($cliente['telefone']); ?>" required>
        <br><br>

        <label>E-mail:</label><br>
        <input type="email" name="email"
            value="<?php echo htmlspecialchars($cliente['email'] ?? ''); ?>">
        <br><br>

        <button type="submit">Salvar alterações</button>
    </form>

    <br>
    <a href="listar.php">Voltar para clientes</a>

</main>

</body>
</html>
