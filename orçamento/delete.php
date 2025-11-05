<?php
require_once '../config.php';
session_start();

// Só admin pode deletar
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);

        // Primeiro, pega o nome do arquivo de imagem (para deletar do servidor)
        $stmt = $pdo->prepare("SELECT imagem FROM orcamentos WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $orc = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($orc && $orc['imagem']) {
            $caminhoFisico = dirname(__DIR__) . '/uploads/orcamentos/' . $orc['imagem'];
            if (file_exists($caminhoFisico)) {
                unlink($caminhoFisico); // deleta a imagem
            }
        }

        // Deleta do banco
        $stmt = $pdo->prepare("DELETE FROM orcamentos WHERE id = :id");
        $stmt->execute([':id' => $id]);

        header("Location: dashboard_orcamento.php");
        exit;

    } catch (PDOException $e) {
        die("Erro ao deletar: " . $e->getMessage());
    }
}
?>
