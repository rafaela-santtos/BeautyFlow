
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
    die("Profissional não encontrado.");
}

$stmt = $conexao->prepare("DELETE FROM profissionais WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $stmt->close();
    header("Location: listar.php");
    exit;
} else {
    echo "Erro ao excluir profissional. Verifique se ele possui agendamentos vinculados.";
}

$stmt->close();
?>
