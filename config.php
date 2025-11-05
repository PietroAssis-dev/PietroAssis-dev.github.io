<?php
// Inicia a sessão
if (!isset($_SESSION)) session_start();

// Define codificação
header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding("UTF-8");

// Constantes de caminho e URL
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

if (!defined('BASEURL')) {
    define('BASEURL', '/siteTCC');
}

if (!defined('HEADER_TEMPLATE')) {
    define('HEADER_TEMPLATE', ABSPATH . 'inc/header.php');
}

if (!defined('FOOTER_TEMPLATE')) {
    define('FOOTER_TEMPLATE', ABSPATH . 'inc/footer.php');
}

// Configurações do banco de dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'honoink');
define('DB_CHARSET', 'utf8mb4');

// Conexão PDO
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    die("Falha na conexão: " . $e->getMessage());
}

// Exibe erros (apenas para desenvolvimento)
error_reporting(E_ALL);
ini_set('display_errors', 1);
