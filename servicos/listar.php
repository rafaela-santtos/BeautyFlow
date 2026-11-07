
<?php
require_once "../auth/proteger.php";
exigirLogin();

require_once "../config/conexao.php";

$eh_admin = $_SESSION["usuario_tipo"] === "admin";

$sql = "SELECT id, nome, descricao, duracao_minutos
        FROM servicos
        ORDER BY id DESC";

$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços | BeautyFlow</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h1>BeautyFlow</h1>
    <h2>Serviços cadastrados</h2>

    <a href="cadastrar.php">Cadastrar novo serviço</a>

    <br><br>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Duração</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($servico = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $servico["id"]; ?></td>

                    <td><?php echo htmlspecialchars($servico["nome"]); ?></td>

                    <td><?php echo htmlspecialchars($servico["descricao"] ?? ""); ?></td>

                    <td>
                        <?php echo $servico["duracao_minutos"]; ?> minutos
                    </td>

                    <td>
                        <a href="editar.php?id=<?php echo $servico['id']; ?>">
                            Editar
                        </a>

                        <?php if ($eh_admin) { ?>
                            |

                            <form method="POST" action="excluir.php"
                                  style="display:inline;"
                                  onsubmit="return confirm('Tem certeza que deseja excluir este serviço?');">

                                <input type="hidden" name="id"
                                       value="<?php echo $servico['id']; ?>">

                                <button type="submit">Excluir</button>

                            </form>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <br>
    <a href="../index.php">Voltar ao início</a>

</body>
</html>
