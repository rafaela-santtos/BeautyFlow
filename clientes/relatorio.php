
<?php
require_once "../auth/proteger.php";
exigirLogin();

require_once "../config/conexao.php";

// Buscar todas as clientes e seus históricos
$sql = "
    SELECT
        c.id,
        c.nome,
        c.telefone,

        COUNT(CASE
            WHEN a.status = 'Faltou' THEN 1
        END) AS total_faltas,

        COUNT(CASE
            WHEN a.status = 'Cancelado'
            AND a.tipo_cancelamento = 'Com antecedência' THEN 1
        END) AS cancelamentos_antecedencia,

        COUNT(CASE
            WHEN a.status = 'Cancelado'
            AND a.tipo_cancelamento = 'Em cima da hora' THEN 1
        END) AS cancelamentos_ultima_hora

    FROM clientes c
    LEFT JOIN agendamentos a ON c.id = a.cliente_id
    GROUP BY c.id, c.nome, c.telefone
    ORDER BY c.nome
";

$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Clientes | BeautyFlow</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <h1>BeautyFlow</h1>
    <h2>Relatório de comportamento das clientes</h2>

    <p>
        Consulte o histórico de faltas e cancelamentos
        registrados nos agendamentos.
    </p>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Telefone</th>
                <th>Faltas</th>
                <th>Cancelamentos com antecedência</th>
                <th>Cancelamentos em cima da hora</th>
                <th>Histórico</th>
            </tr>
        </thead>

        <tbody>

        <?php while ($cliente = $resultado->fetch_assoc()) { ?>

            <tr>
                <td>
                    <?php echo htmlspecialchars($cliente["nome"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($cliente["telefone"] ?? ""); ?>
                </td>

                <td>
                    <?php echo $cliente["total_faltas"]; ?>
                </td>

                <td>
                    <?php echo $cliente["cancelamentos_antecedencia"]; ?>
                </td>

                <td>
                    <?php echo $cliente["cancelamentos_ultima_hora"]; ?>
                </td>

                <td>
                    <a href="historico.php?id=<?php echo $cliente["id"]; ?>">
                        Ver histórico
                    </a>
                </td>
            </tr>

        <?php } ?>

        </tbody>
    </table>

    <br>

    <a href="listar.php">Voltar para clientes</a>

    <br><br>

    <a href="../index.php">Voltar ao menu principal</a>

</body>
</html>
