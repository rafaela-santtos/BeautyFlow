
<?php
require_once "../config/conexao.php";

$mensagem = "";

$consulta = $conexao->query(
    "SELECT id FROM usuarios WHERE tipo_acesso = 'admin' LIMIT 1"
);

if ($consulta->num_rows > 0) {
    die("O administrador já foi cadastrado. Esta página não está mais disponível.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $usuario = trim($_POST["usuario"] ?? "");
    $senha = $_POST["senha"] ?? "";

    if ($nome === "" || $usuario === "" || strlen($senha) < 8) {
        $mensagem = "Preencha todos os campos. A senha deve ter pelo menos 8 caracteres.";
    } else {

        $verificar = $conexao->prepare(
            "SELECT id FROM usuarios WHERE usuario = ?"
        );
        $verificar->bind_param("s", $usuario);
        $verificar->execute();

        if ($verificar->get_result()->num_rows > 0) {
            $mensagem = "Esse nome de usuário já está em uso.";
        } else {

            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            $stmt = $conexao->prepare(
                "INSERT INTO usuarios (nome, usuario, senha, tipo_acesso)
                 VALUES (?, ?, ?, 'admin')"
            );

            $stmt->bind_param("sss", $nome, $usuario, $senha_hash);

            if ($stmt->execute()) {
                $mensagem = "Administradora cadastrada com sucesso!";
            } else {
                $mensagem = "Erro ao cadastrar. Tente novamente.";
            }

            $stmt->close();
        }

        $verificar->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Criar administradora | BeautyFlow</title>
</head>
<body>

    <h1>Criar acesso da dona do salão</h1>

    <p><?php echo htmlspecialchars($mensagem); ?></p>

    <?php if (strpos($mensagem, "sucesso") === false) { ?>

        <form method="POST">

            <label>Nome completo:</label><br>
            <input type="text" name="nome" required><br><br>

            <label>Nome de usuário:</label><br>
            <input type="text" name="usuario" required><br><br>

            <label>Senha (mínimo 8 caracteres):</label><br>
            <input type="password" name="senha" minlength="8" required><br><br>

            <button type="submit">Cadastrar administradora</button>

        </form>

    <?php } ?>

</body>
</html>
