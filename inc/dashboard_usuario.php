<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config.php';
if (!isset($_SESSION['usuario_id'])) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . BASEURL . '/login.php');
    exit;
}
// opcional: checar tipo
if ($_SESSION['usuario_tipo'] !== 'usuario') {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . BASEURL . '/inc/dashboard_usuario.php');
    exit;
}
?>
<?php

require_once '../config.php';

include(HEADER_TEMPLATE);
?>


<style>
    .btn-log,
    .btn-add {
        display: none;
    }

    .grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        height: 100vh;
    }
</style>

<h1>Olá, <?php echo htmlspecialchars($_SESSION["usuario_nome"]); ?>!</h1>
<p>Bem-vindo ao painel.</p>
<a href="logout.php">Sair</a>

<div style="margin-bottom:600px;">
</div>

<?php include(FOOTER_TEMPLATE); ?>