<?php
require "../config.php";
include(HEADER_TEMPLATE);

if (session_status() === PHP_SESSION_NONE) session_start();

// Garante que o usuário esteja logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASEURL . "/inc/login.php");
    exit;
}

$idUsuario = $_SESSION['usuario_id'];
$nomeUsuario = $_SESSION['usuario_nome'] ?? '';
$usuarioLogin = $_SESSION['usuario_usuario'] ?? '';
$fotoUsuario = $_SESSION['usuario_foto'] ?? 'default.png';

// Verifica mensagens de sucesso/erro
$mensagem = "";
$tipo = ""; // success | error
if (isset($_GET['erro']) && $_GET['erro'] === 'usuario_existente') {
    $mensagem = "Este nome de usuário já está sendo usado. Escolha outro.";
    $tipo = "error";
} elseif (isset($_GET['erro']) && $_GET['erro'] === 'senhas_diferentes') {
    $mensagem = "As senhas não coincidem.";
    $tipo = "error";
} elseif (isset($_GET['sucesso'])) {
    $mensagem = "Perfil atualizado com sucesso!";
    $tipo = "success";
}
?>

<link rel="stylesheet" href="<?php echo BASEURL; ?>/assets/css/styleedit.css">



<body>
    <article class="grid-edit">
        <!-- Coluna 1: Card da foto -->
        <div class="info-perf">
            <div class="card-perfil">
                <h1>Alterar foto de perfil</h1>
                <div class="foto-perf">
                    <label for="foto" style="cursor: pointer;">
                        <img src="<?php echo BASEURL; ?>/assets/img/perfis/<?php echo htmlspecialchars($fotoUsuario); ?>"
                             alt="Foto de perfil" id="previewFoto">
                    </label>
                </div>
            </div>
        </div>

        <!-- Coluna 2: Campos de edição -->
        <form class="edit-perfil-coluna" action="salvar_perfil.php" method="POST" enctype="multipart/form-data">
            <input type="file" id="foto" name="foto_perfil" accept="image/*" style="display: none;">

            <div class="edit-perfil-infos">
                <label for="nome">Nome Completo</label>
                <input type="text" name="nome" id="nome"
                       value="<?php echo htmlspecialchars($nomeUsuario); ?>" required>
            </div>

            <div class="edit-perfil-infos">
                <label for="usuario">Nome de Usuário</label>
                <input type="text" name="usuario" id="usuario"
                       value="<?php echo htmlspecialchars($usuarioLogin); ?>" placeholder="Deixe em branco para manter a atual">
            </div>

            <div class="edit-perfil-infos">
                <label for="senha">Nova Senha</label>
                <input type="password" name="senha" id="senha"
                       placeholder="Deixe em branco para manter a atual">
            </div>

            <div class="edit-perfil-infos">
                <label for="confirmar_senha">Confirmar Senha</label>
                <input type="password" name="confirmar_senha" id="confirmar_senha"
                       placeholder="Confirme a senha">
            </div>

            <div class="btns">
                <a class="btn-cancel" href="<?php echo BASEURL; ?>/index.php">Cancelar</a>
                <button type="submit" class="btn-save">Salvar alterações</button>
            </div>

            <input type="hidden" name="id" value="<?php echo $idUsuario; ?>">
        </form>
    </article>

    <!-- Modal -->
    <div id="mensagemModal" class="modal">
        <div class="modal-content <?php echo $tipo === 'success' ? 'modal-success' : 'modal-error'; ?>">
            <h2><?php echo $tipo === 'success' ? 'Sucesso' : 'Aviso'; ?></h2>
            <p><?php echo htmlspecialchars($mensagem); ?></p>
            <?php if ($tipo === 'success'): ?>
                <a href="<?php echo BASEURL; ?>/index.php"><button class="btn-ok">OK</button></a>
            <?php endif; ?>
            <a class="btn-add" onclick="fecharModal()">Fechar</a>
        </div>
    </div>

    <script>
    // Abre modal
    function abrirModal() {
        document.getElementById('mensagemModal').style.display = 'flex';
    }

    // Fecha modal
    function fecharModal() {
        document.getElementById('mensagemModal').style.display = 'none';
    }

    // Mostra modal automaticamente se houver mensagem
    <?php if (!empty($mensagem)) { echo "abrirModal();"; } ?>

    // ==============================
    // Correção do clique da foto
    // ==============================

    const fotoInput = document.getElementById('foto');
    const preview = document.getElementById('previewFoto');
    const label = preview.closest('label');

    // Garante que o clique funcione em mobile e desktop
    label.addEventListener('click', (e) => {
        e.preventDefault();
        fotoInput.click();
    });

    // Mostra prévia da imagem selecionada
    fotoInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    </script>
</body>
