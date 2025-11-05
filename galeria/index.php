<?php
require_once '../config.php';
include(HEADER_TEMPLATE);
?>

<link rel="stylesheet" href="<?= BASEURL ?>/assets/css/stylegaleria.css">


<div class="conteudo">
    <h1>GALERIA DE INSPIRAÇÕES</h1>
    <p class="subtitulo">Explore minha coleção de trabalhos e inspire-se para sua próxima tatuagem!</p>
    <p class="nome">Kamile Hono</p>
    <div class="filtros">
    <button class="filtro-btn active" data-filtro="todos">Todos</button>
    <button class="filtro-btn" data-filtro="fineline">Fineline</button>
    <button class="filtro-btn" data-filtro="blackwork">Blackwork</button>
    <button class="filtro-btn" data-filtro="flash">Semi-Realista</button>
</div>
</div>
<div style="margin-top: 100px;"></div>
<div class="cards-container">
<?php
$stmt = $pdo->query("SELECT * FROM galeria ORDER BY criado_em DESC");
$fotos = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($fotos as $foto){
    echo '<div class="card" data-categoria="'.$foto['categoria'].'">
            <img src="'.BASEURL.'/uploads/galeria/'.$foto['imagem'].'" alt="'.$foto['titulo'].'">
            <div class="card-body">
                <h5 class="card-title">'.$foto['titulo'].'</h5>
            </div>
          </div>';
}
?>
</div>
<div style="margin-top: 100px;"></div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const filtros = document.querySelectorAll('.filtro-btn');
    const cards = document.querySelectorAll('.card');

    filtros.forEach(filtro => {
        filtro.addEventListener('click', () => {
            // Remove "active" de todos
            filtros.forEach(btn => btn.classList.remove('active'));
            filtro.classList.add('active');

            const categoria = filtro.getAttribute('data-filtro');

            cards.forEach(card => {
                const cardCategoria = card.getAttribute('data-categoria');
                if (categoria === 'todos' || cardCategoria === categoria) {
                    card.style.display = 'flex'; // <- Alterado de block para flex
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});


</script>

<?php include(FOOTER_TEMPLATE); ?>
