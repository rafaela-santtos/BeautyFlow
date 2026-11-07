
<?php
require_once "../auth/proteger.php";
exigirLogin();

require_once "../config/conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Cliente não encontrada.");
}

// Buscar dados da cliente
$stmt = $conexao->prepare("SELECT nome, telefone FROM clientes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$cliente = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$cliente) {
    die("Cliente não encontrada.");
}

// Buscar faltas e cancelamentos da cliente
$stmt = $conexao->prepare("
    SELECT
        data_hora,
        status,
        tipo_cancelamento,
        observacoes
    FROM agendamentos
    WHERE cliente_id = ?
    AND (
        status = 'Faltou'
        OR status = 'Cancelado'
    )
    ORDER BY data_hora DESC
");

$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico da Cliente | BeautyFlow</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <h1>BeautyFlow</h1>

    <h2>Histórico da Cliente</h2>

    <h3><?php echo htmlspecialchars($cliente["nome"]); ?></h3>

    <p>
        Telefone:
        <?php echo htmlspecialchars($cliente["telefone"] ?? ""); ?>
    </p>

    <table border="1" cellpadding="10">

        <thead>
            <tr>
                <th>Data e horário</th>
                <th>Ocorrência</th>
                <th>Tipo de cancelamento</th>
                <th>Observações</th>
            </tr>
        </thead>

        <tbody>

        <?php if ($resultado->num_rows > 0) { ?>

            <?php while ($registro = $resultado->fetch_assoc()) { ?>

                <tr>
                    <td>
                        <?php echo date("d/m/Y H:i", strtotime($registro["data_hora"])); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($registro["status"]); ?>
                    </td>

                    <td>
                        <?php
                        echo htmlspecialchars(
                            $registro["tipo_cancelamento"] ?? "-"
                        );
                        ?>
                    </td>

                    <td>
                        <?php
                        echo htmlspecialchars(
                            $registro["observacoes"] ?? ""
                        );
                        ?>
                    </td>
                </tr>

            <?php } ?>

        <?php } else { ?>

            <tr>
                <td colspan="4">
                    Nenhuma falta ou cancelamento registrado.
                </td>
            </tr>

        <?php } ?>

        </tbody>

    </table>

    <br>

    <a href="relatorio.php">Voltar ao relatório</a>

    <br><br>

    <a href="../index.php">Voltar ao menu principal</a>

</body>
</html>

<?php
$stmt->close();
?>

