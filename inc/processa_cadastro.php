<?php
require_once '../config.php';

$mensagem = "";
$tipo = ""; // success | error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $usuario = trim($_POST["usuario"]);
    $senha = $_POST["senha"];
    $confirmar = $_POST["confirmar"];

    if ($senha !== $confirmar) {
        $mensagem = "As senhas não coincidem.";
        $tipo = "error";
    } else {
        // Verificar se o usuário já existe
        $sql_check = "SELECT id FROM usuarios WHERE usuario = ?";
        $stmt_check = $mysqli->prepare($sql_check);
        $stmt_check->bind_param("s", $usuario);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $mensagem = "Usuário já existe, escolha outro nome de usuário.";
            $tipo = "error";
        } else {
            // Criar o hash da senha
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            // Força todos novos usuários como 'usuario'
            $tipo_usuario = 'usuario';

            $sql = "INSERT INTO usuarios (nome, usuario, senha, tipo) VALUES (?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("ssss", $nome, $usuario, $senha_hash, $tipo_usuario);

            if ($stmt->execute()) {
                $mensagem = "Conta criada com sucesso!";
                $tipo = "success";
            } else {
                $mensagem = "Erro: " . $stmt->error;
                $tipo = "error";
            }
        }
        $stmt_check->close();
    }
}
