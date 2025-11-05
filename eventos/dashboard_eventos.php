<?php 
require_once '../config.php';
include(HEADER_TEMPLATE);

if (session_status() === PHP_SESSION_NONE) session_start();

// Verifica se é admin
if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Conexão com o banco
$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Busca os cards de eventos
$stmt = $pdo->query("SELECT * FROM cards_eventos ORDER BY id ASC");
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="<?php echo BASEURL; ?>/assets/css/stylesheet/stylesheet_admin/dashboard_eventos.css">

<div class="cards-eventos">
    <?php foreach ($cards as $card): ?>
        <div class="card-evento">
            <?php
                // Detecta o caminho correto da imagem
                $imgPath = $card['imagem'];
                if (str_starts_with($imgPath, 'uploads/')) {
                    // Imagem enviada pelo admin
                    $imgSrc = BASEURL . '/' . htmlspecialchars($imgPath);
                } else {
                    // Imagem padrão dentro de assets
                    $imgSrc = BASEURL . '/assets/img/' . htmlspecialchars($imgPath);
                }
            ?>

            <img 
                class="card-img-top" 
                src="<?php echo $imgSrc; ?>" 
                alt="<?php echo htmlspecialchars($card['titulo']); ?>"
                onerror="this.src='<?php echo BASEURL; ?>/assets/img/default.jpg';"
            >

            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($card['titulo']); ?></h5>
                <p class="subtitulo"><?php echo htmlspecialchars($card['subtitulo']); ?></p>

                <div class="card-list">
                    <div class="card-item"><p><?php echo htmlspecialchars($card['texto1']); ?></p></div>
                    <div class="card-item"><p><?php echo htmlspecialchars($card['texto2']); ?></p></div>
                    <div class="card-item"><p><?php echo htmlspecialchars($card['texto3']); ?></p></div>
                    <div class="card-item"><p><?php echo htmlspecialchars($card['texto4']); ?></p></div>
                </div>
            </div>

            <a href="edit.php?id=<?php echo $card['id']; ?>" class="btn-editar">Editar</a>
        </div>
    <?php endforeach; ?>
</div>

<div style="margin-bottom: 100px;"></div>


<?php include(FOOTER_TEMPLATE); ?>
