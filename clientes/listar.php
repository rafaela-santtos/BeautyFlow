
<?php
require_once "../auth/proteger.php";
exigirLogin();

require_once "../config/conexao.php";

$eh_admin = $_SESSION["usuario_tipo"] === "admin";

$sql = "SELECT * FROM clientes ORDER BY id DESC";
$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes | BeautyFlow</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h1>BeautyFlow</h1>
    <h2>Clientes cadastrados</h2>

    <a href="cadastrar.php">Cadastrar novo cliente</a>

    <br><br>

    <a href="relatorio.php">Relatório de comportamento das clientes</a>

    <br><br>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>E-mail</th>
            <th>Ações</th>
        </tr>

        <?php while ($cliente = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $cliente["id"]; ?></td>

                <td><?php echo htmlspecialchars($cliente["nome"]); ?></td>

                <td><?php echo htmlspecialchars($cliente["telefone"]); ?></td>

                <td><?php echo htmlspecialchars($cliente["email"] ?? ""); ?></td>

                <td>
                    <a href="editar.php?id=<?php echo $cliente['id']; ?>">
                        Editar
                    </a>

                    <?php if ($eh_admin) { ?>

                        |

                        <form method="POST" action="excluir.php"
                              style="display:inline;"
                              onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">

                            <input type="hidden" name="id"
                                   value="<?php echo $cliente['id']; ?>">

                            <button type="submit">Excluir</button>

                        </form>

                    <?php } ?>
                </td>
            </tr>
        <?php } ?>

    </table>

    <br>

    <a href="../index.php">Voltar ao menu principal</a>

</body>
</html>


