<?php
$localConfig = __DIR__ . '/database.local.php';
$exampleConfig = __DIR__ . '/database.example.php';
if (file_exists($localConfig)) {
    require $localConfig;
} elseif (file_exists($exampleConfig)) {
    require $exampleConfig;
} else {
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'micatalogo');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_CHARSET', 'utf8mb4');
}

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/') . '/';
define('BASE_URL', $protocol . '://' . $host . $basePath);
define('UPLOADS_PATH', __DIR__ . '/../public/uploads/');
define('UPLOADS_URL', BASE_URL . 'public/uploads/');

define('SITE_NAME', 'DROFAR S.A.C.');
define('SITE_DESC', 'Distribuidora Especializada en Insumos y Material Médico');
define('WHATSAPP', '51995218178');
define('WHATSAPP_MSG', 'Hola, quiero más información');
define('EMAIL', 'cotizaciones@drofarperu.com');
define('PHONE', '953571861');
define('ADDRESS', 'Vía de Evitamiento N.° 552, Sector La Encalada del Golf, Trujillo, Perú');
define('FACEBOOK', 'https://www.facebook.com/drofarsac/');
define('INSTAGRAM', 'https://www.instagram.com/drofarsac/');
define('LINKEDIN', 'https://www.linkedin.com/company/drofar-sac/');

$gitHead = __DIR__ . '/../.git/refs/heads/main';
define('ASSET_VERSION', file_exists($gitHead) ? trim(file_get_contents($gitHead)) : (string)filemtime(__FILE__));
