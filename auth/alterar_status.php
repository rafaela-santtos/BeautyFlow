
<?php
require_once "../auth/proteger.php";
exigirAdmin();

require_once "../config/conexao.php";

// Aceitar somente requisições POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: usuarios.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Usuário não encontrado.");
}

// Impedir que a administradora desative a própria conta
if ($id === (int) $_SESSION["usuario_id"]) {
    die("Você não pode desativar sua própria conta.");
}

// Buscar o usuário
$stmt = $conexao->prepare(
    "SELECT id, tipo_acesso, ativo FROM usuarios WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$usuario = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$usuario) {
    die("Usuário não encontrado.");
}

// Se estiver ativo, verificar se pode ser desativado
if ((int) $usuario["ativo"] === 1) {

    // Impedir que o último administrador ativo seja desativado
    if ($usuario["tipo_acesso"] === "admin") {

        $consulta = $conexao->query(
            "SELECT COUNT(*) AS total
             FROM usuarios
             WHERE tipo_acesso = 'admin'
             AND ativo = 1"
        );

        $total_admins = (int) $consulta->fetch_assoc()["total"];

        if ($total_admins <= 1) {
            die("Não é possível desativar o último administrador ativo.");
        }
    }

    $novo_status = 0;

} else {
    // Se estiver inativo, poderá ser reativado
    $novo_status = 1;
}

// Atualizar situação
$atualizar = $conexao->prepare(
    "UPDATE usuarios SET ativo = ? WHERE id = ?"
);

$atualizar->bind_param("ii", $novo_status, $id);

if ($atualizar->execute()) {
    $atualizar->close();
    header("Location: usuarios.php");
    exit;
}

$atualizar->close();

die("Erro ao alterar a situação do usuário.");
?>
