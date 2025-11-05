<?php
require_once '../config.php';
include(HEADER_TEMPLATE);

// Verifica se é admin
if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Conexão com o banco
try {
    $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// Verifica se veio um ID válido
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<p>ID inválido.</p>";
    exit;
}

// Busca o card pelo ID
$stmt = $pdo->prepare("SELECT * FROM cards_eventos WHERE id = ?");
$stmt->execute([$id]);
$card = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$card) {
    echo "<p>Card não encontrado.</p>";
    exit;
}

$editadoComSucesso = false;

// Atualiza o card
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $subtitulo = trim($_POST['subtitulo']);
    $texto1 = trim($_POST['texto1']);
    $texto2 = trim($_POST['texto2']);
    $texto3 = trim($_POST['texto3']);
    $texto4 = trim($_POST['texto4']);

    $imagem = $card['imagem']; // mantém imagem atual se nenhuma nova for enviada

    // Upload da nova imagem (se enviada)
    if (!empty($_FILES['imagem']['name'])) {
        $permitidos = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        if (in_array($_FILES['imagem']['type'], $permitidos) && $_FILES['imagem']['size'] <= $maxSize) {
            $pasta = "../uploads/eventos/";
            if (!is_dir($pasta)) mkdir($pasta, 0777, true);

            $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $nomeImg = uniqid("evento_", true) . "." . strtolower($ext);
            $caminhoCompleto = $pasta . $nomeImg;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoCompleto)) {
                // Remove imagem antiga (se existir)
                if (!empty($card['imagem']) && file_exists("../" . $card['imagem'])) {
                    unlink("../" . $card['imagem']);
                }
                $imagem = "uploads/eventos/" . $nomeImg;
            }
        }
    }

    // Atualiza no banco
    $stmt = $pdo->prepare("UPDATE cards_eventos 
        SET titulo=?, subtitulo=?, texto1=?, texto2=?, texto3=?, texto4=?, imagem=? 
        WHERE id=?");
    $stmt->execute([$titulo, $subtitulo, $texto1, $texto2, $texto3, $texto4, $imagem, $id]);

    $editadoComSucesso = true;
}
?>

<h2>Editar Card</h2>

<form method="POST" enctype="multipart/form-data" class="form-editar">
    <label>Título:</label>
    <input type="text" name="titulo" value="<?php echo htmlspecialchars($card['titulo']); ?>" required>

    <label>Subtítulo:</label>
    <input type="text" name="subtitulo" value="<?php echo htmlspecialchars($card['subtitulo']); ?>">

    <label>Texto 1:</label>
    <input type="text" name="texto1" value="<?php echo htmlspecialchars($card['texto1']); ?>">

    <label>Texto 2:</label>
    <input type="text" name="texto2" value="<?php echo htmlspecialchars($card['texto2']); ?>">

    <label>Texto 3:</label>
    <input type="text" name="texto3" value="<?php echo htmlspecialchars($card['texto3']); ?>">

    <label>Texto 4:</label>
    <input type="text" name="texto4" value="<?php echo htmlspecialchars($card['texto4']); ?>">

    <label>Imagem atual:</label>
    <?php if (!empty($card['imagem'])): ?>
        <img src="../<?php echo htmlspecialchars($card['imagem']); ?>" alt="Imagem do card" style="width:150px;border-radius:8px;">
    <?php else: ?>
        <p>Sem imagem cadastrada.</p>
    <?php endif; ?>

    <label>Nova imagem (opcional):</label>
    <input type="file" name="imagem" accept="image/*">

    <button type="submit">Salvar Alterações</button>
</form>

<!-- Modal de sucesso -->
<?php if ($editadoComSucesso): ?>
<div class="modal-overlay active" id="modal-sucesso">
  <div class="modal-content">
    <h3>Card atualizado com sucesso!</h3>
    <p>As alterações foram salvas no sistema.</p>
    <button onclick="fecharModal()">OK</button>
  </div>
</div>

<script>
function fecharModal() {
  document.getElementById('modal-sucesso').classList.remove('active');
  setTimeout(() => {
    window.location.href = 'dashboard_eventos.php';
  }, 300);
}
</script>
<?php endif; ?>

<style>
/* === Estilo moderno para o formulário de edição === */
body {
  background-color: #f5f6fa;
  font-family: "Poppins", sans-serif;
  margin: 0;
  padding: 0;
  color: #333;
}

/* Título */
h2 {
  text-align: center;
  margin-top: 40px;
  font-size: 2rem;
  font-weight: 600;
  color: #222;
  letter-spacing: 0.5px;
}

/* Container do formulário */
.form-editar {
  width: 100%;
  max-width: 520px;
  margin: 50px auto;
  background-color: #fff;
  border-radius: 14px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  padding: 35px 40px;
  display: flex;
  flex-direction: column;
  gap: 18px;
  box-sizing: border-box;
}

/* Labels */
.form-editar label {
  text-align: left;
  font-weight: 600;
  color: #444;
  font-size: 0.95rem;
}

/* Inputs */
.form-editar input[type="text"],
.form-editar input[type="file"] {
  padding: 10px 12px;
  border: 1px solid #d0d0d0;
  border-radius: 8px;
  font-size: 0.95rem;
  transition: all 0.25s ease;
  outline: none;
}

.form-editar input[type="text"]:focus,
.form-editar input[type="file"]:focus {
  border-color: #4c53a9;
  box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.15);
}

/* Botão */
.form-editar button {
  background-color: #4c53a9;
  color: #fff;
  border: none;
  border-radius: 30px;
  padding: 10px 25px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  align-self: flex-end;
}

.form-editar button:hover {
  background-color: #303894;
}

/* === Modal de sucesso === */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.55);
  display: none;
  align-items: center;
  justify-content: center;
  z-index: 999;
}

.modal-overlay.active {
  display: flex;
  animation: fadeIn 0.3s ease forwards;
}

.modal-content {
  background: #fff;
  border-radius: 12px;
  padding: 30px 40px;
  text-align: center;
  box-shadow: 0 4px 25px rgba(0,0,0,0.25);
  animation: slideUp 0.35s ease;
  max-width: 400px;
}

.modal-content h3 {
  color: #2ecc71;
  margin-bottom: 10px;
  font-size: 1.5rem;
}

.modal-content p {
  color: #444;
  font-size: 1rem;
  margin-bottom: 20px;
}

.modal-content button {
  background-color: #4c53a9;
  color: white;
  border: none;
  border-radius: 25px;
  padding: 8px 25px;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.3s;
}

.modal-content button:hover {
  background-color: #303894;
}

@keyframes fadeIn {
  from {opacity: 0;}
  to {opacity: 1;}
}

@keyframes slideUp {
  from {transform: translateY(30px); opacity: 0;}
  to {transform: translateY(0); opacity: 1;}
}

/* Responsividade */
@media (max-width: 600px) {
  .form-editar {
    max-width: 90%;
    padding: 25px;
  }

  h2 {
    font-size: 1.7rem;
  }

  .modal-content {
    width: 85%;
    padding: 25px;
  }
}
</style>

<?php include(FOOTER_TEMPLATE); ?>
