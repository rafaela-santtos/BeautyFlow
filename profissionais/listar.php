
<?php
require_once "../auth/proteger.php";
exigirLogin();

require_once "../config/conexao.php";

$eh_admin = $_SESSION["usuario_tipo"] === "admin";

$sql = "SELECT * FROM profissionais ORDER BY id DESC";
$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profissionais | BeautyFlow</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h1>BeautyFlow</h1>
    <h2>Profissionais cadastrados</h2>

    <a href="cadastrar.php">Cadastrar novo profissional</a>

    <br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Especialidade</th>
            <th>Ações</th>
        </tr>

        <?php while ($profissional = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $profissional["id"]; ?></td>

                <td><?php echo htmlspecialchars($profissional["nome"]); ?></td>

                <td><?php echo htmlspecialchars($profissional["telefone"]); ?></td>

                <td><?php echo htmlspecialchars($profissional["especialidade"] ?? ""); ?></td>

                <td>
                    <a href="editar.php?id=<?php echo $profissional['id']; ?>">
                        Editar
                    </a>

                    <?php if ($eh_admin) { ?>
                        |

                        <form method="POST" action="excluir.php"
                              style="display:inline;"
                              onsubmit="return confirm('Tem certeza que deseja excluir este profissional?');">

                            <input type="hidden" name="id" value="<?php echo $profissional['id']; ?>">

                            <button type="submit">Excluir</button>

                        </form>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>

    </table>

    <br>
    <a href="../index.php">Voltar ao início</a>

</body>
</html>
