<?php
require_once '../config.php';
include(HEADER_TEMPLATE);

$stmt = $pdo->query("SELECT * FROM galeria ORDER BY criado_em DESC");
$fotos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- CSS EXTERNO -->
<link rel="stylesheet" href="<?= BASEURL ?>/assets/css/stylesheet/stylesheet_admin/dashboard_galeria.css">

<div class="conteudo">
    <h1>GALERIA - ADMIN</h1>
    <p class="subtitulo">Gerencie todas as fotos da galeria</p>

    <div class="filtros">
        <button class="filtro-btn active" data-filtro="todos">Todos</button>
        <button class="filtro-btn" data-filtro="fineline">Fineline</button>
        <button class="filtro-btn" data-filtro="blackwork">Blackwork</button>
        <button class="filtro-btn" data-filtro="flash">Semi-Realista</button>
    </div>

    <div class="add-foto">
        <form method="POST" action="add.php" enctype="multipart/form-data">
            <input type="text" name="titulo" placeholder="Título da Tattoo" required>
            <select name="categoria" required>
                <option value="fineline">Fineline</option>
                <option value="blackwork">Blackwork</option>
                <option value="flash">Semi-Realista</option>
            </select>
            <input type="file" name="imagem" accept="image/*" required>
            <button type="submit">Adicionar</button>
        </form>
    </div>
</div>

<div style="margin-top: 100px;"></div>

<div class="cards-container">
    <?php foreach ($fotos as $foto): ?>
        <div class="card" data-categoria="<?= $foto['categoria'] ?>">
            <img src="<?= BASEURL ?>/uploads/galeria/<?= htmlspecialchars($foto['imagem']) ?>" alt="<?= htmlspecialchars($foto['titulo']) ?>">

            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($foto['titulo']) ?></h5>
                <div class="del-container">
                    <!-- botão de exclusão agora abre modal -->
                    <a href="delete.php?id=<?= $foto['id'] ?>" class="btn-del" data-id="<?= $foto['id'] ?>">Deletar</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div style="margin-top: 100px;"></div>

<!-- ===== MODAL DE CONFIRMAÇÃO ===== -->
<div class="modal-overlay" id="modal-confirmar">
  <div class="modal-content">
    <h3>Tem certeza que deseja excluir?</h3>
    <p>Essa ação não poderá ser desfeita.</p>
    <div class="modal-buttons">
      <button class="btn-cancelar" onclick="fecharModal()">Cancelar</button>
      <button class="btn-confirmar" id="confirmarDelete">Excluir</button>
    </div>
  </div>
</div>

<script>
  // ====== FILTRO DAS FOTOS ======
  const filtros = document.querySelectorAll('.filtro-btn');
  const cards = document.querySelectorAll('.card');

  filtros.forEach(filtro => {
      filtro.addEventListener('click', () => {
          filtros.forEach(btn => btn.classList.remove('active'));
          filtro.classList.add('active');

          const categoria = filtro.getAttribute('data-filtro');
          cards.forEach(card => {
              if (categoria === 'todos' || card.getAttribute('data-categoria') === categoria) {
                  card.style.display = 'block';
              } else {
                  card.style.display = 'none';
              }
          });
      });
  });

  // ====== MODAL DE CONFIRMAÇÃO ======
  let deleteUrl = null;

  document.querySelectorAll('.btn-del').forEach(btn => {
      btn.addEventListener('click', e => {
          e.preventDefault();
          deleteUrl = btn.getAttribute('href');
          abrirModal();
      });
  });

  function abrirModal() {
      document.getElementById('modal-confirmar').classList.add('active');
  }

  function fecharModal() {
      document.getElementById('modal-confirmar').classList.remove('active');
      deleteUrl = null;
  }

  document.getElementById('confirmarDelete').addEventListener('click', () => {
      if (deleteUrl) {
          window.location.href = deleteUrl;
      }
  });
</script>

<?php include(FOOTER_TEMPLATE); ?>
