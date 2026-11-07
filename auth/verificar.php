
<?php
session_start();

require_once "../config/conexao.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

$usuario = trim($_POST["usuario"] ?? "");
$senha = $_POST["senha"] ?? "";

if ($usuario === "" || $senha === "") {
    header("Location: login.php");
    exit;
}

$stmt = $conexao->prepare(
    "SELECT id, nome, usuario, senha, tipo_acesso
     FROM usuarios
     WHERE usuario = ? AND ativo = 1
     LIMIT 1"
);

$stmt->bind_param("s", $usuario);
$stmt->execute();

$resultado = $stmt->get_result();
$dados = $resultado->fetch_assoc();

$stmt->close();

if ($dados && password_verify($senha, $dados["senha"])) {

    session_regenerate_id(true);

    $_SESSION["usuario_id"] = $dados["id"];
    $_SESSION["usuario_nome"] = $dados["nome"];
    $_SESSION["usuario_tipo"] = $dados["tipo_acesso"];

    header("Location: ../index.php");
    exit;

} else {
    echo "<script>
        alert('Usuário ou senha incorretos!');
        window.location.href = 'login.php';
    </script>";
    exit;
}
?>
