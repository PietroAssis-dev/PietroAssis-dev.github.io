<?php
session_start();
require_once '../config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"]);
    $senha   = $_POST["senha"];

    try {
        $sql = "SELECT id, nome, usuario, senha, tipo, foto_perfil 
                FROM usuarios 
                WHERE usuario = :usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':usuario' => $usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($senha, $user['senha'])) {
                // Define variáveis de sessão
                $_SESSION['usuario_id']   = $user['id'];
                $_SESSION['usuario_nome'] = $user['nome'];
                $_SESSION['usuario_tipo'] = $user['tipo'];
                $_SESSION['usuario_foto'] = $user['foto_perfil'] ?? 'default.png';

                // Redireciona conforme o tipo de usuário
                if ($user['tipo'] === 'admin') {
                    header("Location: ../inc/dashboard_admin.php");
                } else {
                    header("Location: ../index.php");
                }
                exit;
            } else {
                header("Location: login.php?erro=senha");
                exit;
            }
        } else {
            header("Location: login.php?erro=usuario");
            exit;
        }
    } catch (PDOException $e) {
        header("Location: login.php?erro=banco");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
