
<?php
require_once "../auth/proteger.php";
exigirLogin();

require_once "../config/conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Agendamento não encontrado.");
}

$stmt = $conexao->prepare("SELECT * FROM agendamentos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$agendamento = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$agendamento) {
    die("Agendamento não encontrado.");
}

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $data_hora = str_replace("T", " ", $_POST["data_hora"] ?? "");
    $valor_cobrado = str_replace(",", ".", $_POST["valor_cobrado"] ?? "");
    $valor_recebido = str_replace(",", ".", $_POST["valor_recebido"] ?? "0");
    $status = $_POST["status"] ?? "";
    $tipo_cancelamento = $_POST["tipo_cancelamento"] ?? "";
    $observacoes = trim($_POST["observacoes"] ?? "");

    $status_validos = ["Agendado", "Confirmado", "Concluído", "Cancelado", "Faltou"];
    $tipos_validos = ["Com antecedência", "Em cima da hora"];

    if ($status !== "Cancelado") {
        $tipo_cancelamento = null;
    }

    if (
        $data_hora == "" ||
        $valor_cobrado === "" ||
        !is_numeric($valor_cobrado) ||
        !is_numeric($valor_recebido) ||
        (float)$valor_cobrado < 0 ||
        (float)$valor_recebido < 0 ||
        (float)$valor_recebido > (float)$valor_cobrado ||
        !in_array($status, $status_validos, true) ||
        ($status === "Cancelado" &&
         !in_array($tipo_cancelamento, $tipos_validos, true))
    ) {

        $mensagem = "Confira os campos. Se o agendamento estiver cancelado, informe o tipo de cancelamento.";

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

        $stmt = $conexao->prepare(
            "UPDATE agendamentos
             SET data_hora = ?,
                 valor_cobrado = ?,
                 valor_recebido = ?,
                 status_pagamento = ?,
                 status = ?,
                 tipo_cancelamento = ?,
                 observacoes = ?
             WHERE id = ?"
        );

        $stmt->bind_param(
            "sddssssi",
            $data_hora,
            $valor_cobrado,
            $valor_recebido,
            $status_pagamento,
            $status,
            $tipo_cancelamento,
            $observacoes,
            $id
        );

        if ($stmt->execute()) {
            $stmt->close();
            header("Location: listar.php");
            exit;
        } else {
            $mensagem = "Erro ao atualizar agendamento: " . $stmt->error;
            $stmt->close();
        }
    }

    $agendamento["data_hora"] = $data_hora;
    $agendamento["valor_cobrado"] = $valor_cobrado;
    $agendamento["valor_recebido"] = $valor_recebido;
    $agendamento["status"] = $status;
    $agendamento["tipo_cancelamento"] = $tipo_cancelamento;
    $agendamento["observacoes"] = $observacoes;
}

$data_hora_formulario = date(
    "Y-m-d\TH:i",
    strtotime($agendamento["data_hora"])
);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Agendamento | BeautyFlow</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <h1>BeautyFlow</h1>
    <h2>Editar Agendamento</h2>

    <p><?php echo htmlspecialchars($mensagem); ?></p>

    <form method="POST">

        <label>Valor total do serviço (R$):</label><br>
        <input
            type="number"
            name="valor_cobrado"
            step="0.01"
            min="0"
            value="<?php echo htmlspecialchars((string)($agendamento["valor_cobrado"] ?? "")); ?>"
            required
        >

        <br><br>

        <label>Valor já recebido / sinal (R$):</label><br>
        <input
            type="number"
            name="valor_recebido"
            step="0.01"
            min="0"
            value="<?php echo htmlspecialchars((string)($agendamento["valor_recebido"] ?? "0")); ?>"
            required
        >

        <br><br>

        <label>Data e horário:</label><br>
        <input
            type="datetime-local"
            name="data_hora"
            value="<?php echo htmlspecialchars($data_hora_formulario); ?>"
            required
        >

        <br><br>

        <label>Status do agendamento:</label><br>
        <select name="status" id="status" required>
            <?php
            foreach (["Agendado", "Confirmado", "Concluído", "Cancelado", "Faltou"] as $opcao) {
                $selecionado = ($agendamento["status"] == $opcao) ? "selected" : "";
                echo "<option value=\"" . htmlspecialchars($opcao) . "\" $selecionado>" . htmlspecialchars($opcao) . "</option>";
            }
            ?>
        </select>

        <br><br>

        <div id="campo-cancelamento">
            <label>Tipo de cancelamento:</label><br>
            <select name="tipo_cancelamento" id="tipo_cancelamento">
                <option value="">Selecione</option>
                <option value="Com antecedência"
                    <?php if (($agendamento["tipo_cancelamento"] ?? "") == "Com antecedência") echo "selected"; ?>>
                    Com antecedência
                </option>
                <option value="Em cima da hora"
                    <?php if (($agendamento["tipo_cancelamento"] ?? "") == "Em cima da hora") echo "selected"; ?>>
                    Em cima da hora
                </option>
            </select>
            <br><br>
        </div>

        <label>Observações:</label><br>
        <textarea name="observacoes"><?php echo htmlspecialchars($agendamento["observacoes"] ?? ""); ?></textarea>

        <br><br>

        <button type="submit">Salvar alterações</button>

    </form>

    <br>
    <a href="listar.php">Voltar para agendamentos</a>

    <script>
        const statusSelect = document.getElementById("status");
        const campoCancelamento = document.getElementById("campo-cancelamento");
        const tipoCancelamento = document.getElementById("tipo_cancelamento");

        function atualizarCampoCancelamento() {
            const cancelado = statusSelect.value === "Cancelado";

            campoCancelamento.style.display = cancelado ? "block" : "none";
            tipoCancelamento.required = cancelado;
        }

        statusSelect.addEventListener("change", atualizarCampoCancelamento);

        atualizarCampoCancelamento();
    </script>

</body>
</html>
