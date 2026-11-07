
<?php
require_once "../auth/proteger.php";
exigirLogin();

require_once "../config/conexao.php";

$mensagem = "";

// Buscar clientes e a quantidade de faltas de cada um
$clientes = $conexao->query("
    SELECT
        c.id,
        c.nome,
        (
            SELECT COUNT(*)
            FROM agendamentos a
            WHERE a.cliente_id = c.id
            AND a.status = 'Faltou'
        ) AS total_faltas
    FROM clientes c
    ORDER BY c.nome
");

// Buscar serviços
$servicos = $conexao->query("SELECT * FROM servicos ORDER BY nome");

// Buscar profissionais
$profissionais = $conexao->query("SELECT * FROM profissionais ORDER BY nome");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $cliente_id = filter_input(INPUT_POST, "cliente_id", FILTER_VALIDATE_INT);
    $servico_id = filter_input(INPUT_POST, "servico_id", FILTER_VALIDATE_INT);
    $profissional_id = filter_input(INPUT_POST, "profissional_id", FILTER_VALIDATE_INT);

    $data_hora = str_replace("T", " ", $_POST["data_hora"] ?? "");
    $valor_cobrado = str_replace(",", ".", $_POST["valor_cobrado"] ?? "");
    $valor_recebido = str_replace(",", ".", $_POST["valor_recebido"] ?? "0");
    $exigir_sinal = $_POST["exigir_sinal"] ?? "nao";
    $observacoes = trim($_POST["observacoes"] ?? "");

    if (
        !$cliente_id ||
        !$servico_id ||
        !$profissional_id ||
        $data_hora == "" ||
        $valor_cobrado === "" ||
        !is_numeric($valor_cobrado) ||
        !is_numeric($valor_recebido) ||
        (float)$valor_cobrado < 0 ||
        (float)$valor_recebido < 0 ||
        (float)$valor_recebido > (float)$valor_cobrado ||
        !in_array($exigir_sinal, ["sim", "nao"], true) ||
        ($exigir_sinal === "sim" && (float)$valor_recebido <= 0)
    ) {

        $mensagem = "Confira os campos. Se optar por exigir sinal, informe um valor recebido maior que zero.";

    } else {

        $valor_cobrado = (float)$valor_cobrado;
        $valor_recebido = (float)$valor_recebido;

        if ($valor_recebido == 0) {
            $status_pagamento = "Pendente";
        } elseif ($valor_recebido < $valor_cobrado) {
            $status_pagamento = "Parcial";
        } else {
            $status_pagamento = "Pago";
        }

        if (strlen($data_hora) == 16) {
            $data_hora .= ":00";
        }

        $stmt = $conexao->prepare("
            INSERT INTO agendamentos
            (
                cliente_id,
                servico_id,
                profissional_id,
                data_hora,
                valor_cobrado,
                valor_recebido,
                status_pagamento,
                observacoes
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "iiisddss",
            $cliente_id,
            $servico_id,
            $profissional_id,
            $data_hora,
            $valor_cobrado,
            $valor_recebido,
            $status_pagamento,
            $observacoes
        );

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: listar.php");
            exit;
        } else {
            $mensagem = "Erro ao cadastrar agendamento: " . $stmt->error;
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Agendamento | BeautyFlow</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <h1>BeautyFlow</h1>
    <h2>Novo Agendamento</h2>

    <?php if ($mensagem != "") { ?>
        <p><?php echo htmlspecialchars($mensagem); ?></p>
    <?php } ?>

    <form method="POST">

        <label>Cliente:</label><br>
        <select name="cliente_id" id="cliente_id" required>
            <option value="">Selecione uma cliente</option>

            <?php while ($cliente = $clientes->fetch_assoc()) { ?>
                <option
                    value="<?php echo $cliente["id"]; ?>"
                    data-faltas="<?php echo $cliente["total_faltas"]; ?>"
                    <?php if (($_POST["cliente_id"] ?? "") == $cliente["id"]) echo "selected"; ?>
                >
                    <?php echo htmlspecialchars($cliente["nome"]); ?>
                </option>
            <?php } ?>
        </select>

        <br><br>

        <div id="aviso-faltas" style="display:none; padding:12px; margin-bottom:15px; background:#fff0f0; border:1px solid #d88; border-radius:8px;">
        </div>

        <label>Serviço:</label><br>
        <select name="servico_id" required>
            <option value="">Selecione um serviço</option>

            <?php while ($servico = $servicos->fetch_assoc()) { ?>
                <option
                    value="<?php echo $servico["id"]; ?>"
                    <?php if (($_POST["servico_id"] ?? "") == $servico["id"]) echo "selected"; ?>
                >
                    <?php echo htmlspecialchars($servico["nome"]); ?>
                </option>
            <?php } ?>
        </select>

        <br><br>

        <label>Profissional:</label><br>
        <select name="profissional_id" required>
            <option value="">Selecione um profissional</option>

            <?php while ($profissional = $profissionais->fetch_assoc()) { ?>
                <option
                    value="<?php echo $profissional["id"]; ?>"
                    <?php if (($_POST["profissional_id"] ?? "") == $profissional["id"]) echo "selected"; ?>
                >
                    <?php echo htmlspecialchars($profissional["nome"]); ?>
                </option>
            <?php } ?>
        </select>

        <br><br>

        <label>Data e horário:</label><br>
        <input
            type="datetime-local"
            name="data_hora"
            value="<?php echo htmlspecialchars($_POST["data_hora"] ?? ""); ?>"
            required
        >

        <br><br>

        <label>Valor total do serviço (R$):</label><br>
        <input
            type="number"
            name="valor_cobrado"
            step="0.01"
            min="0"
            value="<?php echo htmlspecialchars($_POST["valor_cobrado"] ?? ""); ?>"
            required
        >

        <br><br>

        <label>Valor recebido / sinal (R$):</label><br>
        <input
            type="number"
            name="valor_recebido"
            step="0.01"
            min="0"
            value="<?php echo htmlspecialchars($_POST["valor_recebido"] ?? "0"); ?>"
            required
        >

        <br><br>

        <label>Decisão sobre o sinal:</label><br>
        <select name="exigir_sinal" required>
            <option value="nao" <?php if (($_POST["exigir_sinal"] ?? "nao") == "nao") echo "selected"; ?>>
                Não exigir sinal - liberar agendamento
            </option>

            <option value="sim" <?php if (($_POST["exigir_sinal"] ?? "") == "sim") echo "selected"; ?>>
                Exigir sinal para confirmar
            </option>
        </select>

        <br><br>

        <label>Observações:</label><br>
        <textarea name="observacoes"><?php echo htmlspecialchars($_POST["observacoes"] ?? ""); ?></textarea>

        <br><br>

        <button type="submit">Cadastrar agendamento</button>

    </form>

    <br>

    <a href="listar.php">Voltar para agendamentos</a>

    <script>
        const clienteSelect = document.getElementById("cliente_id");
        const avisoFaltas = document.getElementById("aviso-faltas");

        function verificarFaltas() {
            const opcao = clienteSelect.options[clienteSelect.selectedIndex];
            const faltas = Number(opcao.dataset.faltas || 0);

            if (faltas > 0) {
                avisoFaltas.style.display = "block";

                avisoFaltas.innerHTML =
                    "<strong>Atenção!</strong><br>" +
                    "Esta cliente possui " + faltas +
                    " falta(s) registrada(s) anteriormente.<br>" +
                    "Recomendação: avaliar a cobrança de sinal no próximo agendamento.";
            } else {
                avisoFaltas.style.display = "none";
                avisoFaltas.innerHTML = "";
            }
        }

        clienteSelect.addEventListener("change", verificarFaltas);

        verificarFaltas();
    </script>

</body>
</html>
