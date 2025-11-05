<?php
require_once '../config.php';
include(HEADER_TEMPLATE);

$pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
$stmt = $pdo->query("SELECT * FROM orcamentos ORDER BY data_envio DESC");
$orcamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="<?php echo BASEURL; ?>/assets/css/stylesheet/stylesheet_admin/dashboard_orcamento.css">

<div class="container-orcamento">
  <h2>Solicitações de Orçamento</h2>
</div>

<div class="margin"></div>

<div class="card-container">
  <?php foreach ($orcamentos as $orc): ?>
    <div class="card-orcamento">
      <?php
      $imagem = !empty($orc['imagem'])
        ? BASEURL . '/uploads/orcamentos/' . htmlspecialchars($orc['imagem'])
        : BASEURL . '/assets/img/perfis/default.png';
      ?>
      <img src="<?php echo $imagem; ?>" alt="Imagem de referência">

      <div class="card-header">
        <h3><?php echo htmlspecialchars($orc['nome']); ?></h3>
        <form method="POST" action="delete.php" class="form-delete">
          <input type="hidden" name="id" value="<?php echo $orc['id']; ?>">
          <button type="button" class="btn-delete" onclick="abrirModal(this)">
            <img src="<?php echo BASEURL; ?>/assets/img/icones/trash-icon.svg" alt="Deletar">
          </button>
        </form>
      </div>

      <div style="margin-top: 20px;"></div>

      <p><strong>Telefone:</strong> <?php echo htmlspecialchars($orc['telefone']); ?></p>
      <p><strong>Local:</strong> <?php echo htmlspecialchars($orc['local']); ?></p>
      <p><strong>Descrição:</strong> <?php echo nl2br(htmlspecialchars($orc['descricao'])); ?></p>

      <span class="data"><?php echo date('d/m/Y H:i', strtotime($orc['data_envio'])); ?></span>
    </div>
  <?php endforeach; ?>
</div>

<!-- Modal de Confirmação -->
<!-- Modal de Confirmação -->
<div class="modal-overlay" id="modalConfirmacao">
  <div class="custom-modal">
    <h3>Excluir orçamento?</h3>
    <p>Esta ação não poderá ser desfeita.</p>
    <div class="modal-buttons">
      <button class="btn-cancelar" onclick="fecharModal()">Cancelar</button>
      <button class="btn-confirmar" id="confirmarExclusao">Excluir</button>
    </div>
  </div>
</div>




<div style="margin-top: 100px;"></div>

<script>
  let formParaExcluir = null;

  // Essas funções precisam estar no escopo global para o onclick funcionar
  function abrirModal(botao) {
    formParaExcluir = botao.closest(".form-delete");
    const modal = document.getElementById("modalConfirmacao");
    if (modal) {
      modal.classList.add("active");

    }
  }

  function fecharModal() {
    const modal = document.getElementById("modalConfirmacao");
    if (modal) {
      modal.classList.remove("active");

    }
    formParaExcluir = null;
  }

  // Aguarda o DOM carregar para associar o evento de confirmação
  document.addEventListener("DOMContentLoaded", function() {
    const botaoConfirmar = document.getElementById("confirmarExclusao");
    if (botaoConfirmar) {
      botaoConfirmar.addEventListener("click", function() {
        if (formParaExcluir) formParaExcluir.submit();
      });
    }
  });
</script>

<?php include(FOOTER_TEMPLATE); ?>