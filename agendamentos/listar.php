
<?php
require_once "../auth/proteger.php";
exigirLogin();

require_once "../config/conexao.php";

$eh_admin = $_SESSION["usuario_tipo"] === "admin";

$sql = "SELECT
            agendamentos.id,
            clientes.nome AS cliente,
            servicos.nome AS servico,
            profissionais.nome AS profissional,
            agendamentos.data_hora,
            agendamentos.valor_cobrado,
            agendamentos.valor_recebido,
            agendamentos.status_pagamento,
            agendamentos.status,
            agendamentos.observacoes
        FROM agendamentos
        INNER JOIN clientes ON agendamentos.cliente_id = clientes.id
        INNER JOIN servicos ON agendamentos.servico_id = servicos.id
        INNER JOIN profissionais ON agendamentos.profissional_id = profissionais.id
        ORDER BY agendamentos.data_hora DESC";

$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos | BeautyFlow</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h1>BeautyFlow</h1>
    <h2>Agendamentos cadastrados</h2>

    <a href="cadastrar.php">Novo agendamento</a>

    <br><br>

    <table border="1" cellpadding="10">

        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Serviço</th>
            <th>Profissional</th>
            <th>Valor total</th>
            <th>Valor recebido (sinal)</th>
            <th>Saldo restante</th>
            <th>Pagamento</th>
            <th>Data e horário</th>
            <th>Status</th>
            <th>Observações</th>
            <th>Ações</th>
        </tr>

        <?php while ($agendamento = $resultado->fetch_assoc()) { ?>

            <?php
            $valor_total = $agendamento["valor_cobrado"];
            $valor_recebido = (float)$agendamento["valor_recebido"];

            $saldo_restante = $valor_total !== null
                ? max(0, (float)$valor_total - $valor_recebido)
                : null;
            ?>

            <tr>
                <td><?php echo $agendamento["id"]; ?></td>

                <td><?php echo htmlspecialchars($agendamento["cliente"]); ?></td>

                <td><?php echo htmlspecialchars($agendamento["servico"]); ?></td>

                <td><?php echo htmlspecialchars($agendamento["profissional"]); ?></td>

                <td>
                    <?php
                    echo $valor_total !== null
                        ? "R$ " . number_format((float)$valor_total, 2, ",", ".")
                        : "Não informado";
                    ?>
                </td>

                <td>
                    R$ <?php echo number_format($valor_recebido, 2, ",", "."); ?>
                </td>

                <td>
                    <?php
                    echo $saldo_restante !== null
                        ? "R$ " . number_format($saldo_restante, 2, ",", ".")
                        : "Não informado";
                    ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($agendamento["status_pagamento"]); ?>
                </td>

                <td>
                    <?php echo date("d/m/Y H:i", strtotime($agendamento["data_hora"])); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($agendamento["status"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($agendamento["observacoes"] ?? ""); ?>
                </td>

                <td>
                    <a href="editar.php?id=<?php echo $agendamento['id']; ?>">
                        Editar
                    </a>

                    <?php if ($eh_admin) { ?>

                        |

                        <form method="POST" action="excluir.php"
                              style="display:inline;"
                              onsubmit="return confirm('Tem certeza que deseja excluir este agendamento?');">

                            <input type="hidden" name="id"
                                   value="<?php echo $agendamento['id']; ?>">

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



