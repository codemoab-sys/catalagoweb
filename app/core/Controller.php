<?php
namespace App\Core;

function h($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

function csrf_field() {
    return '<input type="hidden" name="_token" value="' . htmlspecialchars($_SESSION['_csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') . '">';
}

class Controller
{
    protected function generateCsrfToken()
    {
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }

    protected function checkRateLimit($key = 'login', $maxAttempts = 5, $window = 60)
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $file = sys_get_temp_dir() . "/ratelimit_{$key}_{$ip}";
        $now = time();
        $attempts = [];
        if (file_exists($file)) {
            $attempts = json_decode(file_get_contents($file), true) ?? [];
            $attempts = array_filter($attempts, fn($t) => $t > $now - $window);
        }
        if (count($attempts) >= $maxAttempts) {
            if (function_exists('error_log')) {
                error_log("[RateLimit] {$key} bloqueado para {$ip}");
            }
            http_response_code(429);
            die('Demasiados intentos. Espera un minuto e intenta de nuevo.');
        }
        $attempts[] = $now;
        file_put_contents($file, json_encode($attempts), LOCK_EX);
    }

    protected function resetRateLimit($key = 'login')
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $file = sys_get_temp_dir() . "/ratelimit_{$key}_{$ip}";
        if (file_exists($file)) unlink($file);
    }

    protected function validateCsrfToken()
    {
        $token = $_POST['_token'] ?? '';
        if (empty($_SESSION['_csrf_token']) || !hash_equals($_SESSION['_csrf_token'], $token)) {
            if (function_exists('error_log')) {
                error_log('[CSRF] Token inválido desde ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
            }
            http_response_code(419);
            die('Sesión expirada o token inválido. Recarga la página e intenta de nuevo.');
        }
    }

    protected function render($view, $data = [])
    {
        extract($data);
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            if (function_exists('error_log')) {
                error_log("[Controller] Vista no encontrada: {$viewPath}");
            }
            http_response_code(500);
            echo 'Error interno del servidor.';
        }
    }

    protected function json($data, $code = 200)
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function redirect($url)
    {
        header('Location: ' . BASE_URL . $url);
        exit;
    }

    protected function model($name)
    {
        $class = "App\\Models\\{$name}";
        return new $class();
    }

    protected function uploadFile($file, $folder = 'productos')
    {
        if ($file['error'] !== UPLOAD_ERR_OK) return null;

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $ext;
        $targetDir = __DIR__ . '/../../public/uploads/' . $folder . '/';

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $targetDir . $filename)) {
            return 'public/uploads/' . $folder . '/' . $filename;
        }
        return null;
    }

    protected function deleteFile($path)
    {
        if ($path) {
            $fullPath = __DIR__ . '/../../' . $path;
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}
