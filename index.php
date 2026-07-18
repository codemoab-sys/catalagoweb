<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require __DIR__ . '/config/database.php';

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relativeClass = substr($class, $len);
    $parts = explode('\\', $relativeClass);
    $parts[0] = lcfirst($parts[0]); // lowercase first dir (core, controllers, models)
    $file = $baseDir . implode('/', $parts) . '.php';
    if (file_exists($file)) require $file;
});

use App\Core\Router;
use App\Controllers\AdminController;
use App\Controllers\CatalogController;

$router = new Router();

// Catalog
$router->get('/', [CatalogController::class, 'index']);
$router->get('/categoria/{slug}', [CatalogController::class, 'categoria']);
$router->get('/producto/{id}', [CatalogController::class, 'detalle']);
$router->get('/buscar', [CatalogController::class, 'search']);
$router->get('/api/buscar', [CatalogController::class, 'apiSearch']);

// Admin
$router->get('/admin', [AdminController::class, 'dashboard']);
$router->post('/admin/login', [AdminController::class, 'login']);
$router->get('/admin/logout', [AdminController::class, 'logout']);

// Admin - Familias
$router->get('/admin/familias', [AdminController::class, 'familias']);
$router->post('/admin/familias/guardar', [AdminController::class, 'familiaGuardar']);
$router->get('/admin/familias/data/{id}', [AdminController::class, 'familiaData']);
$router->post('/admin/familias/eliminar/{id}', [AdminController::class, 'familiaDelete']);

// Admin - Marcas
$router->get('/admin/marcas', [AdminController::class, 'marcas']);
$router->post('/admin/marcas/guardar', [AdminController::class, 'marcaGuardar']);
$router->get('/admin/marcas/data/{id}', [AdminController::class, 'marcaData']);
$router->post('/admin/marcas/eliminar/{id}', [AdminController::class, 'marcaDelete']);

// Admin - Productos
$router->get('/admin/productos', [AdminController::class, 'productos']);
$router->get('/admin/productos/crear', [AdminController::class, 'productoCreate']);
$router->post('/admin/productos/crear', [AdminController::class, 'productoCreate']);
$router->get('/admin/productos/editar/{id}', [AdminController::class, 'productoEdit']);
$router->post('/admin/productos/editar/{id}', [AdminController::class, 'productoEdit']);
$router->post('/admin/productos/eliminar/{id}', [AdminController::class, 'productoDelete']);
$router->post('/admin/productos/eliminar-galeria/{id}', [AdminController::class, 'productoDeleteGaleria']);

// Admin - Banners
$router->get('/admin/banners', [AdminController::class, 'banners']);
$router->get('/admin/banners/crear', [AdminController::class, 'bannerCreate']);
$router->post('/admin/banners/crear', [AdminController::class, 'bannerCreate']);
$router->get('/admin/banners/editar/{id}', [AdminController::class, 'bannerEdit']);
$router->post('/admin/banners/editar/{id}', [AdminController::class, 'bannerEdit']);
$router->post('/admin/banners/eliminar/{id}', [AdminController::class, 'bannerDelete']);

// Admin - Usuarios
$router->get('/admin/usuarios', [AdminController::class, 'usuarios']);
$router->get('/admin/usuarios/crear', [AdminController::class, 'usuarioCreate']);
$router->post('/admin/usuarios/crear', [AdminController::class, 'usuarioCreate']);
$router->get('/admin/usuarios/editar/{id}', [AdminController::class, 'usuarioEdit']);
$router->post('/admin/usuarios/editar/{id}', [AdminController::class, 'usuarioEdit']);
$router->post('/admin/usuarios/eliminar/{id}', [AdminController::class, 'usuarioDelete']);

// Admin - Buenas Prácticas
$router->get('/admin/buenas-practicas', [AdminController::class, 'buenasPracticas']);
$router->post('/admin/buenas-practicas/guardar', [AdminController::class, 'buenaPracticaGuardar']);
$router->get('/admin/buenas-practicas/data/{id}', [AdminController::class, 'buenaPracticaData']);
$router->post('/admin/buenas-practicas/eliminar/{id}', [AdminController::class, 'buenaPracticaDelete']);

$router->dispatch();
