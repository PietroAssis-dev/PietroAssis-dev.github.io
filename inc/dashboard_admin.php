<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config.php';
if (!isset($_SESSION['usuario_id'])) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . BASEURL . '/login.php');
    exit;
}
// opcional: checar tipo
if ($_SESSION['usuario_tipo'] !== 'admin') {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . BASEURL . '/inc/dashboard_usuario.php');
    exit;
}
?>
<?php


require_once '../config.php';

include(HEADER_TEMPLATE);
?>

<link rel="stylesheet" href="<?php echo BASEURL; ?>/assets/css/stylesheet/stylesheet_admin/painel.css">


<article>

    <h1>Olá, <?php echo htmlspecialchars($_SESSION["usuario_nome"]); ?>!</h1>
    <p>Bem-vindo ao painel, aqui voce consegue alterar tudo o que voce deseja!</p>

</article>
<article class="flex-dashboard">
    <div class="card card1">
        <img class="card-img-top" src="<?php echo BASEURL; ?>/assets/img/orcamento.png" alt="Card 1">
        <h3>Orçamentos</h3>
        <p class="info-text-p">Aqui voce pode checar, editar e excluir os orçamentos.<br><br></p>
        <a class="btn-go" href="<?php echo BASEURL; ?>/orçamento/dashboard_orcamento.php"> Entrar</a>
    </div>

    <div class="card card2">
        <img class="card-img-top" src="<?php echo BASEURL; ?>/assets/img/casamento.png" alt="Card 2">
        <h3>Eventos</h3>
        <p class="info-text-p">Aqui você pode, visualizar e excluir eventos antigos e adicionar eventos novos.</p>
         <a class="btn-go" href="<?php echo BASEURL; ?>/eventos/dashboard_eventos.php"> Entrar</a>
    </div>

    <div class="card card3">
        <img class="card-img-top" src="<?php echo BASEURL; ?>/assets/img/galeria.png" alt="Card 3">
        <h3>Galeria</h3>
        <p class="info-text-p">Adicione novas fotos de tatuagens realizadas, e exclua as antigas</p>
         <a class="btn-go" href="<?php echo BASEURL; ?>/galeria/dashboard_galeria.php"> Entrar</a>
    </div>
</article>



<div style="margin-bottom:600px;">
</div>

<?php include(FOOTER_TEMPLATE); ?>