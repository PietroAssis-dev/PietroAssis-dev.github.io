<?php
require_once '../config.php';

if(isset($_GET['id'])){
    $id = intval($_GET['id']);

    // Pegar o nome da imagem antes de deletar
    $stmt = $pdo->prepare("SELECT imagem FROM galeria WHERE id = ?");
    $stmt->execute([$id]);
    $foto = $stmt->fetch(PDO::FETCH_ASSOC);

    if($foto){
        $caminho = '../uploads/galeria/' . $foto['imagem'];
        if(file_exists($caminho)){
            unlink($caminho); // deleta o arquivo do servidor
        }

        // Deletar do banco
        $stmt = $pdo->prepare("DELETE FROM galeria WHERE id = ?");
        $stmt->execute([$id]);
    }
}

header('Location: dashboard_galeria.php');
exit;
?>
