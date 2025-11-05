<?php
require "../config.php";
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: " . BASEURL . "/inc/login.php");
    exit;
}

$id = $_SESSION['usuario_id'];
$nome = trim($_POST['nome'] ?? '');
$usuario = trim($_POST['usuario'] ?? '');
$senha = $_POST['senha'] ?? '';
$confirmar = $_POST['confirmar_senha'] ?? '';
$foto_perfil = $_SESSION['usuario_foto'] ?? 'default.png';

// === Busca dados atuais do usuário (para manter se algo estiver em branco) ===
try {
    $stmtAtual = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmtAtual->execute([$id]);
    $dadosAtuais = $stmtAtual->fetch(PDO::FETCH_ASSOC);

    if (!$dadosAtuais) {
        die("Usuário não encontrado.");
    }
} catch (PDOException $e) {
    die("Erro ao buscar dados atuais: " . $e->getMessage());
}

// === Mantém o nome de usuário atual se o campo estiver vazio ===
if ($usuario === '') {
    $usuario = $dadosAtuais['usuario'];
}

// === Verifica se o nome de usuário já existe no banco (para outro ID) ===
try {
    $sql_check = "SELECT id FROM usuarios WHERE usuario = ? AND id != ?";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([$usuario, $id]);
    $usuario_existente = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($usuario_existente) {
        header("Location: edit_perfil.php?erro=usuario_existente");
        exit;
    }
} catch (PDOException $e) {
    die("Erro ao verificar usuário existente: " . $e->getMessage());
}

// === Upload da imagem ===
if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
    $ext = strtolower(pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (in_array($ext, $permitidas)) {
        $nomeArquivo = uniqid("perfil_") . "." . $ext;
        $destino = ABSPATH . "assets/img/perfis/" . $nomeArquivo;

        if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $destino)) {
            $foto_perfil = $nomeArquivo;

            // Remove a foto antiga (exceto se for a default)
            if (!empty($_SESSION['usuario_foto']) && $_SESSION['usuario_foto'] !== 'default.png') {
                $antiga = ABSPATH . "assets/img/perfis/" . $_SESSION['usuario_foto'];
                if (file_exists($antiga)) {
                    unlink($antiga);
                }
            }
        }
    }
}

// === Atualização no banco ===
try {
    if (!empty($senha)) {
        if ($senha !== $confirmar) {
            header("Location: edit_perfil.php?erro=senhas_diferentes");
            exit;
        }

        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET nome=?, usuario=?, senha=?, foto_perfil=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $usuario, $hash, $foto_perfil, $id]);
    } else {
        $sql = "UPDATE usuarios SET nome=?, usuario=?, foto_perfil=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $usuario, $foto_perfil, $id]);
    }

    // Atualiza sessão
    $_SESSION['usuario_nome'] = $nome;
    $_SESSION['usuario_usuario'] = $usuario;
    $_SESSION['usuario_foto'] = $foto_perfil;

    header("Location: edit_perfil.php?sucesso=1");
    exit;

} catch (PDOException $e) {
    die("Erro ao atualizar perfil: " . $e->getMessage());
}
?>
