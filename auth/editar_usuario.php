
<?php
require_once "../auth/proteger.php";
exigirAdmin();

require_once "../config/conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Usuário não encontrado.");
}

$stmt = $conexao->prepare(
    "SELECT id, nome, usuario FROM usuarios WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$usuario = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$usuario) {
    die("Usuário não encontrado.");
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $novo_usuario = trim($_POST["usuario"] ?? "");
    $senha = $_POST["senha"] ?? "";

    if ($nome === "" || $novo_usuario === "") {

        $mensagem = "Preencha o nome e o nome de usuário.";

    } else {

        // Verificar se o nome de usuário já pertence a outra pessoa
        $verificar = $conexao->prepare(
            "SELECT id FROM usuarios WHERE usuario = ? AND id <> ?"
        );

        $verificar->bind_param("si", $novo_usuario, $id);
        $verificar->execute();

        if ($verificar->get_result()->num_rows > 0) {

            $mensagem = "Esse nome de usuário já está em uso.";

        } elseif ($senha !== "" && strlen($senha) < 8) {

            $mensagem = "A nova senha deve ter pelo menos 8 caracteres.";

        } else {

            if ($senha !== "") {

                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

                $atualizar = $conexao->prepare(
                    "UPDATE usuarios
                     SET nome = ?, usuario = ?, senha = ?
                     WHERE id = ?"
                );

                $atualizar->bind_param(
                    "sssi",
                    $nome,
                    $novo_usuario,
                    $senha_hash,
                    $id
                );

            } else {

                $atualizar = $conexao->prepare(
                    "UPDATE usuarios
                     SET nome = ?, usuario = ?
                     WHERE id = ?"
                );

                $atualizar->bind_param(
                    "ssi",
                    $nome,
                    $novo_usuario,
                    $id
                );
            }

            if ($atualizar->execute()) {
                $atualizar->close();
                header("Location: usuarios.php");
                exit;
            }

            $atualizar->close();
            $mensagem = "Erro ao atualizar usuário.";
        }

        $verificar->close();
    }

    // Atualizar os dados exibidos no formulário
    $usuario["nome"] = $nome;
    $usuario["usuario"] = $novo_usuario;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuário | BeautyFlow</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h1>Editar usuário</h1>

    <p><?php echo htmlspecialchars($mensagem); ?></p>

    <form method="POST">

        <label>Nome completo:</label><br>
        <input
            type="text"
            name="nome"
            value="<?php echo htmlspecialchars($usuario["nome"]); ?>"
            required
        ><br><br>

        <label>Nome de usuário:</label><br>
        <input
            type="text"
            name="usuario"
            value="<?php echo htmlspecialchars($usuario["usuario"]); ?>"
            required
        ><br><br>

        <label>Nova senha:</label><br>
        <input
            type="password"
            name="senha"
            minlength="8"
            placeholder="Deixe em branco para manter a senha atual"
        ><br><br>

        <button type="submit">Salvar alterações</button>

    </form>

    <p>
        <a href="usuarios.php">Voltar aos usuários</a>
    </p>

</body>
</html>
