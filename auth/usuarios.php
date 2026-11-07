
<?php
require_once "../auth/proteger.php";
exigirAdmin();

require_once "../config/conexao.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $usuario = trim($_POST["usuario"] ?? "");
    $senha = $_POST["senha"] ?? "";
    $tipo_acesso = $_POST["tipo_acesso"] ?? "";

    if (
        $nome === "" ||
        $usuario === "" ||
        strlen($senha) < 8 ||
        !in_array($tipo_acesso, ["admin", "funcionario"], true)
    ) {
        $mensagem = "Preencha os campos corretamente. A senha deve ter pelo menos 8 caracteres.";

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
                 VALUES (?, ?, ?, ?)"
            );

            $stmt->bind_param("ssss", $nome, $usuario, $senha_hash, $tipo_acesso);

            if ($stmt->execute()) {
                $mensagem = "Usuário cadastrado com sucesso!";
            } else {
                $mensagem = "Erro ao cadastrar usuário.";
            }

            $stmt->close();
        }

        $verificar->close();
    }
}

$sql = "SELECT id, nome, usuario, tipo_acesso, ativo, data_criacao
        FROM usuarios
        ORDER BY nome ASC";

$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar usuários | BeautyFlow</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h1>Gerenciar usuários</h1>

    <p>Área exclusiva da administradora.</p>

    <p>
        <a href="../index.php">Voltar ao painel inicial</a>
    </p>

    <h2>Cadastrar novo usuário</h2>

    <p><?php echo htmlspecialchars($mensagem); ?></p>

    <form method="POST">

        <label>Nome completo:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Nome de usuário:</label><br>
        <input type="text" name="usuario" required><br><br>

        <label>Senha (mínimo 8 caracteres):</label><br>
        <input type="password" name="senha" minlength="8" required><br><br>

        <label>Tipo de acesso:</label><br>
        <select name="tipo_acesso" required>
            <option value="">Selecione</option>
            <option value="funcionario">Funcionário</option>
            <option value="admin">Administrador</option>
        </select><br><br>

        <button type="submit">Cadastrar usuário</button>

    </form>

    <hr>

    <h2>Usuários cadastrados</h2>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Usuário</th>
                <th>Tipo de acesso</th>
                <th>Situação</th>
                <th>Ação</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($usuario = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($usuario["nome"]); ?></td>

                    <td><?php echo htmlspecialchars($usuario["usuario"]); ?></td>

                    <td>
                        <?php echo $usuario["tipo_acesso"] === "admin"
                            ? "Administrador"
                            : "Funcionário"; ?>
                    </td>

                    <td>
                        <?php echo $usuario["ativo"] ? "Ativo" : "Inativo"; ?>
                    </td>

                    <td>
                        <?php if ((int) $usuario["id"] !== (int) $_SESSION["usuario_id"]) { ?>

                            <a href="editar_usuario.php?id=<?php echo (int) $usuario["id"]; ?>">
                                Editar
                            </a>

                            <form method="POST" action="alterar_status.php">
                                <input type="hidden" name="id"
                                    value="<?php echo (int) $usuario["id"]; ?>">

                                <button type="submit">
                                    <?php echo $usuario["ativo"] ? "Desativar" : "Ativar"; ?>
                                </button>
                            </form>

                            <form method="POST" action="alterar_acesso.php">

                                <input type="hidden" name="id"
                                    value="<?php echo (int) $usuario["id"]; ?>">

                                <select name="tipo_acesso" required>
                                    <option value="admin"
                                        <?php echo $usuario["tipo_acesso"] === "admin" ? "selected" : ""; ?>>
                                        Administrador
                                    </option>

                                    <option value="funcionario"
                                        <?php echo $usuario["tipo_acesso"] === "funcionario" ? "selected" : ""; ?>>
                                        Funcionário
                                    </option>
                                </select>

                                <button type="submit">Alterar acesso</button>

                            </form>

                        <?php } else { ?>

                            Conta atual

                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>



