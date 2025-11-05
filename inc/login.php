<?php
require_once '../config.php';
include(HEADER_TEMPLATE);

// Verifica se há erro via GET
$mensagem = "";
$tipo = "";

if (isset($_GET['erro'])) {
    switch ($_GET['erro']) {
        case 'usuario':
            $mensagem = "Usuário não encontrado.";
            $tipo = "error";
            break;
        case 'senha':
            $mensagem = "Senha incorreta. Tente novamente.";
            $tipo = "error";
            break;
        case 'banco':
            $mensagem = "Erro ao acessar o banco de dados.";
            $tipo = "error";
            break;
    }
}
?>

<style>
    .grid-info-text {
        background-image: url('<?php echo BASEURL; ?>/assets/img/teste.png');
    }

    /* ==== MODAL ==== */

</style>

<link rel="stylesheet" href="<?php echo BASEURL; ?>/assets/css/stylesheet/login.css">

<div class="grid">
    <div class="grid-log">
        <h1>Bem-vindo</h1>

        <div class="form-container">
            <form action="processa_login.php" method="POST">
                <input type="text" id="usuario" name="usuario" placeholder="Usuário" required>
                <input type="password" id="senha" name="senha" placeholder="Senha" required>

                <div class="link-registro">
                    Não tem uma conta? <a href="cadastro.php">Registre-se</a>
                </div>

                <button type="submit">Entrar</button>
            </form>
        </div>
    </div>

    <div class="grid-info-text">
        <p>Faça login para acessar seu perfil, agendar sessões<br>e acompanhar seus orçamentos.</p>
    </div>
</div>


<div id="mensagemModal" class="modal">
    <div class="modal-content modal-error">
        <h2>Aviso</h2>
        <p><?php echo $mensagem; ?></p>
        <div style="text-align: center;">
            <a class="btn-close" onclick="fecharModal()">Fechar</a>
        </div>
    </div>
</div>

<script>
    function abrirModal() {
        document.getElementById("mensagemModal").style.display = "flex";
    }

    function fecharModal() {
        document.getElementById("mensagemModal").style.display = "none";
        // Remove o parâmetro da URL depois de fechar o modal
        const url = new URL(window.location.href);
        url.searchParams.delete('erro');
        window.history.replaceState({}, document.title, url.toString());
    }

    <?php if (!empty($mensagem)) { ?>
        abrirModal();
    <?php } ?>
</script>
