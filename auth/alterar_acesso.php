
<?php
require_once "../auth/proteger.php";
exigirAdmin();

require_once "../config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: usuarios.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
$novo_tipo = $_POST["tipo_acesso"] ?? "";

if (
    !$id ||
    !in_array($novo_tipo, ["admin", "funcionario"], true)
) {
    die("Dados inválidos.");
}

if ($id === (int) $_SESSION["usuario_id"]) {
    die("Você não pode alterar o próprio tipo de acesso.");
}

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

if (
    $usuario["tipo_acesso"] === "admin" &&
    $novo_tipo === "funcionario" &&
    (int) $usuario["ativo"] === 1
) {
    $consulta = $conexao->query(
        "SELECT COUNT(*) AS total
         FROM usuarios
         WHERE tipo_acesso = 'admin'
         AND ativo = 1"
    );

    $total_admins = (int) $consulta->fetch_assoc()["total"];

    if ($total_admins <= 1) {
        die("Não é possível rebaixar o último administrador ativo.");
    }
}

$atualizar = $conexao->prepare(
    "UPDATE usuarios SET tipo_acesso = ? WHERE id = ?"
);

$atualizar->bind_param("si", $novo_tipo, $id);

if ($atualizar->execute()) {
    $atualizar->close();
    header("Location: usuarios.php");
    exit;
}

$atualizar->close();

die("Erro ao alterar o tipo de acesso.");
?>
