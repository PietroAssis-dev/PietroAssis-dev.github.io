<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: text/html; charset=utf-8');


// Define os links corretos conforme o tipo de usuário
if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin') {
    $homeLink = BASEURL . '/inc/dashboard_admin.php';
    $orcamentoLink = BASEURL . '/orçamento/dashboard_orcamento.php';
    $galeriaLink = BASEURL . '/galeria/dashboard_galeria.php';
    $eventosLink = BASEURL . '/eventos/dashboard_eventos.php';
} else {
    $homeLink = BASEURL . '/index.php';
    $orcamentoLink = BASEURL . '/orçamento/index.php';
    $galeriaLink = BASEURL . '/galeria/index.php';
    $eventosLink = BASEURL . '/eventos/index.php';
}

$sobreLink = BASEURL . '/sobre/index.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>HONOINK</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo BASEURL; ?>/assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="<?php echo BASEURL; ?>/assets/img/logo.png">
	<meta charset="UTF-8">


</head>

<body>
    <header>
        <nav class="navbar">
            <a href="<?php echo $homeLink; ?>">
                <img src="<?php echo BASEURL; ?>/assets/img/logo.png" alt="logo" class="img-logo">
            </a>

            <div class="nav-menu">
                <ul class="list-style"><li><a href="<?php echo $homeLink; ?>" class="list-text">Home</a></li></ul>
                <ul class="list-style"><li><a href="<?php echo $orcamentoLink; ?>" class="list-text">Orçamentos</a></li></ul>
                <ul class="list-style">
                    <li class="has-submenu">
                        <a href="<?php echo $eventosLink; ?>" class="list-text">Eventos</a>
                    </li>
                </ul>
                <ul class="list-style"><li><a href="<?php echo $galeriaLink; ?>" class="list-text">Galeria</a></li></ul>
                <ul class="list-style"><li><a href="<?php echo $sobreLink; ?>" class="list-text">Sobre</a></li></ul>
            </div>


            <div class="nav-user">
                <?php if (isset($_SESSION["usuario_nome"])): ?>
                    <?php
                    $fotoUsuario = $_SESSION["usuario_foto"] ?? 'default.png';
                    $nomeUsuario = htmlspecialchars($_SESSION["usuario_nome"]);
                    ?>
                    <div class="user-info" id="userInfo">
                        <!-- FOTO (ativa o dropdown) -->
                        <img src="<?php echo BASEURL; ?>/assets/img/perfis/<?php echo htmlspecialchars($fotoUsuario); ?>"
                            alt="Foto de perfil" class="foto-perfil" id="fotoPerfil">
                        

      
                        <div class="dropdown-user" id="userDropdown">
                            <a href="<?php echo BASEURL; ?>/inc/edit_perfil.php">Editar perfil</a>
                        </div>
                    </div>

                    <!-- BOTÃO SAIR (mantido exatamente igual) -->
                    <a href="<?php echo BASEURL; ?>/inc/logout.php" class="btn-sair">Sair</a>
                <?php endif; ?>
            </div>


            <div class="nav-buttons">
                <?php if (!isset($_SESSION["usuario_nome"])): ?>
                    <a href="<?php echo BASEURL; ?>/inc/login.php" class="btn-log">Entrar</a>
                    <a href="<?php echo BASEURL; ?>/inc/cadastro.php" class="btn-add">Criar uma conta</a>
                <?php endif; ?>
            </div>

            <div class="hamburger" onclick="toggleMenu()">
                <span></span><span></span><span></span>
            </div>
        </nav>

        <div class="mobile-menu" id="mobileMenu">
            <a href="<?php echo $homeLink; ?>">Home</a>
            <a href="<?php echo $orcamentoLink; ?>">Orçamentos</a>
            <a href="<?php echo $eventosLink; ?>">Eventos</a>
            <a href="<?php echo $galeriaLink; ?>">Galeria</a>
            <a href="<?php echo $sobreLink; ?>">Sobre</a>

            <?php if (isset($_SESSION["usuario_nome"])): ?>
                <div class="mobile-user">

                    <a class="btn-logout" href="<?php echo BASEURL; ?>/inc/logout.php">Sair</a>
                </div>
            <?php else: ?>
                <a href="<?php echo BASEURL; ?>/inc/login.php">Entrar</a>
                <a href="<?php echo BASEURL; ?>/inc/cadastro.php">Criar uma conta</a>
            <?php endif; ?>
        </div>
    </header>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('active');
        }

        const fotoPerfil = document.getElementById('fotoPerfil');
        const userDropdown = document.getElementById('userDropdown');

        if (fotoPerfil) {
            fotoPerfil.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('active');
            });

            window.addEventListener('click', (e) => {
                if (!userDropdown.contains(e.target) && e.target !== fotoPerfil) {
                    userDropdown.classList.remove('active');
                }
            });
        }
    </script>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>
