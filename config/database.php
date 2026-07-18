<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'micatalogo');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

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
define('FACEBOOK', '#');
define('INSTAGRAM', '#');
define('LINKEDIN', '#');
