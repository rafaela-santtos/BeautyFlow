
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function exigirLogin() {
    if (!isset($_SESSION["usuario_id"])) {
        header("Location: /BeautyFlow/auth/login.php");
        exit;
    }
}

function exigirAdmin() {
    exigirLogin();

    if ($_SESSION["usuario_tipo"] !== "admin") {
        header("Location: /BeautyFlow/index.php");
        exit;
    }
}

?>