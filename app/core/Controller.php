<?php
namespace App\Core;

function h($str) {
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

class Controller
{
    protected function render($view, $data = [])
    {
        extract($data);
        $viewPath = __DIR__ . '/../views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            die("Vista no encontrada: " . $view);
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
