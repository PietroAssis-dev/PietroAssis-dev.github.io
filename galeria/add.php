<?php
require_once '../config.php';
include(HEADER_TEMPLATE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $categoria = $_POST['categoria'];

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
        // Normaliza a extensão
        $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));

        // Extensões permitidas
        $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($ext, $permitidas)) {
            // Garante que a pasta exista
            if (!is_dir('../uploads/galeria')) {
                mkdir('../uploads/galeria', 0777, true);
            }

            // Nome único e destino final (sempre .jpg)
            $nome_arquivo = uniqid('img_') . '.jpg';
            $destino = '../uploads/galeria/' . $nome_arquivo;

            // === Conversão para JPG ===
            switch ($ext) {
                case 'jpg':
                case 'jpeg':
                    $imagem = imagecreatefromjpeg($_FILES['imagem']['tmp_name']);
                    break;
                case 'png':
                    $imagem = imagecreatefrompng($_FILES['imagem']['tmp_name']);
                    imagepalettetotruecolor($imagem);
                    imagealphablending($imagem, true);
                    imagesavealpha($imagem, false);
                    break;
                case 'gif':
                    $imagem = imagecreatefromgif($_FILES['imagem']['tmp_name']);
                    break;
                case 'webp':
                    $imagem = imagecreatefromwebp($_FILES['imagem']['tmp_name']);
                    break;
                default:
                    $imagem = null;
                    break;
            }

            if ($imagem) {
                // Salva como JPG (qualidade 90)
                imagejpeg($imagem, $destino, 90);
                imagedestroy($imagem);

                // Salva no banco de dados
                $stmt = $pdo->prepare("INSERT INTO galeria (titulo, imagem, categoria) VALUES (?, ?, ?)");
                $stmt->execute([$titulo, $nome_arquivo, $categoria]);

                header('Location: dashboard_galeria.php');
                exit;
            } else {
                echo "<p style='color:red;'>Erro ao processar a imagem enviada.</p>";
            }
        } else {
            echo "<p style='color:red;'>Formato não permitido. Envie JPG, JPEG, PNG, GIF ou WEBP.</p>";
        }
    } else {
        echo "<p style='color:red;'>Erro no upload do arquivo.</p>";
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="titulo" placeholder="Título da Tattoo" required>
    <select name="categoria" required>
        <option value="fineline">Fineline</option>
        <option value="blackwork">Blackwork</option>
        <option value="flash">Semi-Realista</option>
    </select>
    <input type="file" name="imagem" accept="image/*" required>
    <button type="submit">Enviar</button>
</form>
