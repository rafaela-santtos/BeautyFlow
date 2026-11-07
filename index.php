
<?php
require_once "auth/proteger.php";
exigirLogin();

require_once "config/conexao.php";

date_default_timezone_set("America/Sao_Paulo");

$eh_admin = $_SESSION["usuario_tipo"] === "admin";
$nome_usuario = $_SESSION["usuario_nome"];

// Quantidade de clientes
$total_clientes = $conexao->query(
    "SELECT COUNT(*) AS total FROM clientes"
)->fetch_assoc()["total"];

// Quantidade de serviços
$total_servicos = $conexao->query(
    "SELECT COUNT(*) AS total FROM servicos"
)->fetch_assoc()["total"];

// Quantidade de profissionais
$total_profissionais = $conexao->query(
    "SELECT COUNT(*) AS total FROM profissionais"
)->fetch_assoc()["total"];

// Agendamentos de hoje
$stmt = $conexao->prepare(
    "SELECT COUNT(*) AS total
     FROM agendamentos
     WHERE DATE(data_hora) = CURDATE()"
);

$stmt->execute();
$agendamentos_hoje = $stmt->get_result()->fetch_assoc()["total"];
$stmt->close();

// Indicadores financeiros somente para a administradora
if ($eh_admin) {

    $total_recebido = $conexao->query(
        "SELECT COALESCE(SUM(valor_recebido), 0) AS total
         FROM agendamentos"
    )->fetch_assoc()["total"];

    $saldo_pendente = $conexao->query(
        "SELECT COALESCE(
            SUM(GREATEST(valor_cobrado - valor_recebido, 0)), 0
         ) AS total
         FROM agendamentos
         WHERE status NOT IN ('Cancelado', 'Faltou')"
    )->fetch_assoc()["total"];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>BeautyFlow | Salão JS</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <main class="pagina-inicial">

        <header class="cabecalho">

            <img
                src="img/logo_js.png"
                alt="Logo JS Salão de Beleza e Estética"
                class="logo"
            >

            <h1>BeautyFlow</h1>

            <div class="subtitulo">
                Gestão de Salão de Beleza
            </div>

            <p class="boas-vindas">
                Olá, <?php echo htmlspecialchars($nome_usuario); ?>! ♡
                <br>
                Bem-vindo ao sistema BeautyFlow!
            </p>

            <a href="auth/sair.php" class="botao secundario">
                Sair do sistema
            </a>

        </header>

        <section class="menu-principal">

            <h2>★ Resumo do salão</h2>

            <div class="grade-cards">

                <article class="card">
                    <div class="icone">♧</div>
                    <div class="descricao">
                        <h3>Clientes</h3>
                        <p><?php echo $total_clientes; ?> cadastradas</p>
                    </div>
                </article>

                <article class="card">
                    <div class="icone">✂</div>
                    <div class="descricao">
                        <h3>Serviços</h3>
                        <p><?php echo $total_servicos; ?> cadastrados</p>
                    </div>
                </article>

                <article class="card">
                    <div class="icone">♙</div>
                    <div class="descricao">
                        <h3>Profissionais</h3>
                        <p><?php echo $total_profissionais; ?> cadastrados</p>
                    </div>
                </article>

                <article class="card">
                    <div class="icone">▦</div>
                    <div class="descricao">
                        <h3>Agendamentos de hoje</h3>
                        <p><?php echo $agendamentos_hoje; ?> agendamentos</p>
                    </div>
                </article>

            </div>

            <?php if ($eh_admin) { ?>

                <h2>★ Resumo financeiro</h2>

                <div class="grade-cards">

                    <article class="card">
                        <div class="icone">R$</div>
                        <div class="descricao">
                            <h3>Total recebido</h3>
                            <p>
                                R$ <?php echo number_format((float)$total_recebido, 2, ",", "."); ?>
                            </p>
                        </div>
                    </article>

                    <article class="card">
                        <div class="icone">◷</div>
                        <div class="descricao">
                            <h3>Saldo pendente</h3>
                            <p>
                                R$ <?php echo number_format((float)$saldo_pendente, 2, ",", "."); ?>
                            </p>
                        </div>
                    </article>

                </div>

            <?php } ?>

            <h2>★ Menu Principal</h2>

            <div class="grade-cards">

                <article class="card">

                    <div class="icone">♧</div>

                    <div class="descricao">
                        <h3>Clientes</h3>
                        <p>Cadastre e gerencie seus clientes.</p>
                    </div>

                    <div class="acoes">
                        <a href="clientes/cadastrar.php" class="botao">
                            + Cadastrar Cliente
                        </a>

                        <a href="clientes/listar.php" class="botao secundario">
                            ☷ Listar Clientes
                        </a>

                        <a href="clientes/relatorio.php" class="botao secundario">
                            Relatório de comportamento
                        </a>
                    </div>

                </article>

                <article class="card">

                    <div class="icone">✂</div>

                    <div class="descricao">
                        <h3>Serviços</h3>
                        <p>Cadastre e gerencie seus serviços.</p>
                    </div>

                    <div class="acoes">
                        <a href="servicos/cadastrar.php" class="botao">
                            + Cadastrar Serviço
                        </a>

                        <a href="servicos/listar.php" class="botao secundario">
                            ☷ Listar Serviços
                        </a>
                    </div>

                </article>

                <article class="card">

                    <div class="icone">♙</div>

                    <div class="descricao">
                        <h3>Profissionais</h3>
                        <p>Cadastre e gerencie sua equipe.</p>
                    </div>

                    <div class="acoes">
                        <a href="profissionais/cadastrar.php" class="botao">
                            + Cadastrar Profissional
                        </a>

                        <a href="profissionais/listar.php" class="botao secundario">
                            ☷ Listar Profissionais
                        </a>
                    </div>

                </article>

                <article class="card">

                    <div class="icone">▦</div>

                    <div class="descricao">
                        <h3>Agendamentos</h3>
                        <p>Realize e consulte agendamentos.</p>
                    </div>

                    <div class="acoes">
                        <a href="agendamentos/cadastrar.php" class="botao">
                            + Novo Agendamento
                        </a>

                        <a href="agendamentos/listar.php" class="botao secundario">
                            ☷ Listar Agendamentos
                        </a>
                    </div>

                </article>

                <?php if ($eh_admin) { ?>

                    <article class="card">

                        <div class="icone">⚙</div>

                        <div class="descricao">
                            <h3>Gerenciar usuários</h3>
                            <p>Cadastre funcionários e administre os acessos ao sistema.</p>
                        </div>

                        <div class="acoes">
                            <a href="auth/usuarios.php" class="botao">
                                Gerenciar usuários
                            </a>
                        </div>

                    </article>

                <?php } ?>

            </div>

        </section>

        <footer class="rodape">
            Aqui sua autoestima é renovada! ♡
        </footer>

    </main>

</body>
</html>


