<?php
require_once '../config.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Redireciona se não estiver logado
if (!isset($_SESSION['usuario_id'])) {
  header('Location: ' . BASEURL . '/inc/login.php');
  exit;
}

include(HEADER_TEMPLATE);

// Flag para exibir modal se houver sucesso no envio
$exibirModalSucesso = isset($_GET['sucesso']) && $_GET['sucesso'] == 1;

// Processa envio
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['nome'] ?? '';
  $telefone = $_POST['telefone'] ?? '';
  $descricao = $_POST['descricao'] ?? '';
  $local = $_POST['local'] ?? '';
  $imagem = null;

  // Cria pasta uploads
  $caminhoFisico = dirname(__DIR__) . '/uploads/orcamentos/';
  if (!is_dir($caminhoFisico)) {
    mkdir($caminhoFisico, 0777, true);
  }

  // Upload
  if (!empty($_FILES['imagem']['name'])) {
    $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $novoNome = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoFisico . $novoNome);
    $imagem = $novoNome;
  }

  // Salva no banco
  try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $stmt = $pdo->prepare("INSERT INTO orcamentos (nome, telefone, descricao, local, imagem, data_envio)
                               VALUES (:nome, :telefone, :descricao, :local, :imagem, NOW())");
    $stmt->execute([
      ':nome' => $nome,
      ':telefone' => $telefone,
      ':descricao' => $descricao,
      ':local' => $local,
      ':imagem' => $imagem
    ]);

    // Redireciona após salvar com sucesso (evita reenvio e modal repetido)
    header('Location: ' . $_SERVER['PHP_SELF'] . '?sucesso=1');
    exit;

  } catch (PDOException $e) {
    echo "<script>alert('Erro ao enviar: " . $e->getMessage() . "');</script>";
  }
}
?>
<link rel="stylesheet" href="<?php echo BASEURL; ?>/assets/css/styleorcamento.css">
<style>
  .container-img {
    width: 100%;
    height: 80vh;
    background-image: url('<?php echo BASEURL; ?>/assets/img/foto-container-orcamentos.jpg');
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 100px;
    color: #fff;
    font-weight: bold;
    margin-bottom: 50px;
  }

  @media screen and (max-width:680px){
    .container-img{
      display: none;
    }
  }


</style>

<div class="container-img">Orçamentos</div>

<div class="container">
  <div class="form-container">
    <form method="POST" enctype="multipart/form-data">
      <label for="nome">Nome Completo</label>
      <input type="text" name="nome" id="nome" required placeholder="Ex: Maria da Silva">

      <label for="telefone">Telefone</label>
      <input type="tel" name="telefone" id="telefone" required placeholder="(11) 99999-9999" maxlength="15" oninput="mascaraTelefone(this)">

      <label for="descricao">Descreva sua ideia</label>
      <textarea name="descricao" id="descricao" required placeholder="Conte com detalhes o estilo, tamanho e local desejado..."></textarea>

      <label for="local">Local do corpo</label>
      <input type="text" name="local" id="local" required placeholder="Ex: Braço, perna, ombro...">

      <label for="imagem">Enviar uma referência de imagem (opcional)</label>
      <div class="upload-box" id="uploadBox">
        <input type="file" id="upload" name="imagem" accept="image/*" style="display:none">
        <img class="upload-icon" src="<?php echo BASEURL; ?>/assets/img/icones/export.svg" alt="Upload">
        <p class="upload-text">Clique ou arraste uma imagem aqui</p>
        <span>PNG, JPG ou JPEG</span>
        <img id="preview" src="" alt="Pré-visualização" style="display:none; margin-top:10px; max-width:100%; border-radius:10px;">
      </div>

      <button class="btn-submit" type="submit">ENVIAR ORÇAMENTO</button>
    </form>
  </div>

  <div class="right-column">
    <div class="contact-box">
      <h3>Contato Direto</h3>
      <p>Prefere um contato mais direto? Fale conosco no WhatsApp!</p>
      <a href="https://api.whatsapp.com/send/?phone=5519997032404&text=Olá!+Gostaria+de+fazer+um+orçamento!"
        target="_blank" class="btn-whatsapp">CHAMAR NO WHATSAPP</a>
    </div>

    <div class="info-box">
      <h3>Informações Úteis</h3>
      <ul>
        <li><img src="<?php echo BASEURL; ?>/assets/img/icones/star.svg" alt=""> Orçamentos gratuitos</li>
        <li><img src="<?php echo BASEURL; ?>/assets/img/icones/star.svg" alt=""> Respondemos em até 24h</li>
        <li><img src="<?php echo BASEURL; ?>/assets/img/icones/star.svg" alt=""> Agendamento conforme disponibilidade</li>
        <li><img src="<?php echo BASEURL; ?>/assets/img/icones/star.svg" alt=""> Só aceitamos após aprovação do desenho</li>
      </ul>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal-overlay" id="modalSucesso">
  <div class="modal-content">
    <h2>Orçamento Enviado!</h2>
    <p>Recebemos suas informações. Entraremos em contato o quanto antes!</p>
    <button onclick="fecharModal()">Fechar</button>
  </div>
</div>

<script>
  const uploadBox = document.getElementById('uploadBox');
  const fileInput = document.getElementById('upload');
  const preview = document.getElementById('preview');

  uploadBox.addEventListener('click', () => fileInput.click());
  fileInput.addEventListener('change', e => {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = ev => {
        preview.src = ev.target.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    }
  });

  uploadBox.addEventListener('dragover', e => {
    e.preventDefault();
    uploadBox.classList.add('dragover');
  });

  uploadBox.addEventListener('dragleave', e => {
    e.preventDefault();
    uploadBox.classList.remove('dragover');
  });

  uploadBox.addEventListener('drop', e => {
    e.preventDefault();
    uploadBox.classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    if (file) {
      fileInput.files = e.dataTransfer.files;
      const reader = new FileReader();
      reader.onload = ev => {
        preview.src = ev.target.result;
        preview.style.display = 'block';
      };
      reader.readAsDataURL(file);
    }
  });

  // === Máscara de telefone ===
  function mascaraTelefone(input) {
    let numero = input.value.replace(/\D/g, '');
    if (numero.length > 10) {
      numero = numero.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
    } else if (numero.length > 6) {
      numero = numero.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
    } else if (numero.length > 2) {
      numero = numero.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
    } else {
      numero = numero.replace(/^(\d*)/, '($1');
    }
    input.value = numero;
  }

  // === Modal de sucesso ===
  function abrirModal() {
    document.getElementById('modalSucesso').style.display = 'flex';
  }

  function fecharModal() {
    document.getElementById('modalSucesso').style.display = 'none';
    window.history.replaceState(null, '', window.location.pathname); // remove ?sucesso=1 da URL
  }

  <?php if ($exibirModalSucesso): ?>
    window.addEventListener('DOMContentLoaded', abrirModal);
  <?php endif; ?>
</script>

<?php include(FOOTER_TEMPLATE); ?>
