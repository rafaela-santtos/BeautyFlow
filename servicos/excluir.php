
<?php
require_once "../auth/proteger.php";
exigirAdmin();

require_once "../config/conexao.php";

// Aceitar somente requisições POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: listar.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Serviço não encontrado.");
}

$stmt = $conexao->prepare("DELETE FROM servicos WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: listar.php");
    exit;
} else {
    echo "Erro ao excluir serviço. Verifique se existem agendamentos vinculados.";
}

$stmt->close();
?>
