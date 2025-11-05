<?php
require_once '../config.php';
include(HEADER_TEMPLATE);

$mensagem = "";
$tipo = ""; // success | error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $usuario = trim($_POST["usuario"]);
    $senha = $_POST["senha"];
    $confirmar = $_POST["confirmar"];

    // Diretório das fotos
    $diretorio = '../assets/img/perfis/';
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0777, true);
    }

    // Nome padrão da foto
    $foto_nome = 'default.png';

    // Verifica se foi enviada uma foto
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
        $extensao = strtolower($extensao);
        $tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($extensao, $tiposPermitidos)) {
            $foto_nome = uniqid('perfil_') . '.' . $extensao;
            $destino = $diretorio . $foto_nome;
            move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $destino);
        } else {
            $foto_nome = 'default.png';
        }
    }

    if ($senha !== $confirmar) {
        $mensagem = "As senhas não coincidem.";
        $tipo = "error";
    } else {
        try {
            // Verifica se o usuário já existe
            $stmt_check = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = :usuario");
            $stmt_check->execute([':usuario' => $usuario]);
            $user_exists = $stmt_check->fetch();

            if ($user_exists) {
                $mensagem = "Usuário já existe, escolha outro nome de usuário.";
                $tipo = "error";
            } else {
                // Cria hash da senha
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

                // Insere usuário no banco
                $stmt_insert = $pdo->prepare("
                    INSERT INTO usuarios (nome, usuario, senha, foto_perfil)
                    VALUES (:nome, :usuario, :senha, :foto)
                ");

                $stmt_insert->execute([
                    ':nome' => $nome,
                    ':usuario' => $usuario,
                    ':senha' => $senha_hash,
                    ':foto' => $foto_nome
                ]);

                $mensagem = "Conta criada com sucesso!";
                $tipo = "success";
            }
        } catch (PDOException $e) {
            $mensagem = "Erro ao acessar o banco: " . $e->getMessage();
            $tipo = "error";
        }
    }
}
?>

<!-- ================== SEU CSS EXISTENTE ================== -->

<link rel="stylesheet" href="<?php echo BASEURL; ?>/assets/css/stylesheet/cadastro.css">

<div class="grid">
    <div class="grid-left"></div>
    <div class="grid-right">
        <h1>Crie sua conta</h1>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="text" name="usuario" placeholder="Nome de usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <input type="password" name="confirmar" placeholder="Confirmar senha" required>

            <input class="fotoperfil" type="file" name="foto_perfil" accept="image/*" id="foto_perfil">
            <label for="foto_perfil">Escolher Foto</label>

            <!-- Área de pré-visualização -->
            <div class="preview-container">
                <img id="preview-imagem" src="#" alt="Pré-visualização" style="display: none;">
            </div>


            <div class="form-footer">
                Já possui uma conta? <a href="login.php">Entre</a>
            </div>
            <button type="submit">Criar conta</button>
        </form>
    </div>
</div>

<!-- Modal -->
<div id="mensagemModal" class="modal">
    <div class="modal-content <?php echo $tipo == 'success' ? 'modal-success' : 'modal-error'; ?>">
        <h2><?php echo $tipo == 'success' ? 'Sucesso' : 'Aviso'; ?></h2>
        <p><?php echo $mensagem; ?></p>
        <?php if ($tipo == "success") { ?>
            <a href="login.php"><button class="btn-ok">Entrar</button></a>
        <?php } ?>
        <button class="btn-close" onclick="fecharModal()">Fechar</button>
    </div>
</div>

<script>
    function abrirModal() {
        document.getElementById("mensagemModal").style.display = "flex";
    }

    function fecharModal() {
        document.getElementById("mensagemModal").style.display = "none";
    }

    <?php if (!empty($mensagem)) { ?>
        abrirModal();
    <?php } ?>
</script>
<script>
document.getElementById('foto_perfil').addEventListener('change', function(event) {
    const preview = document.getElementById('preview-imagem');
    const arquivo = event.target.files[0];

    if (arquivo) {
        const leitor = new FileReader();

        leitor.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }

        leitor.readAsDataURL(arquivo);
    } else {
        preview.src = '#';
        preview.style.display = 'none';
    }
});
</script>
