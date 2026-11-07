
<?php
require_once "../auth/proteger.php";
exigirAdmin();

require_once "../config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: listar.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Cliente não encontrado.");
}

$stmt = $conexao->prepare("DELETE FROM clientes WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: listar.php");
    exit;
} else {
    echo "Erro ao excluir cliente. Verifique se ele possui agendamentos vinculados.";
}

$stmt->close();
?>
