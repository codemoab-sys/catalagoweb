<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin' ?> - <?= SITE_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/admin.css?v=<?= filemtime(__DIR__.'/../../../public/css/admin.css') ?>">
</head>
<body>
<div class="d-flex" style="min-height:100vh">
    <nav class="sidebar bg-dark text-white">
        <div class="sidebar-header p-3 text-center">
            <img src="<?= BASE_URL ?>DROFARSAC-LOGO.png" alt="DROFAR" height="40" style="filter:brightness(0)invert(1)">
            <small class="text-muted d-block mt-1">Panel Admin</small>
            <button id="darkModeToggle" class="btn btn-sm btn-outline-light mt-2 w-100" title="Modo oscuro/claro">
                <i class="bi bi-moon-stars"></i> <span>Oscuro</span>
            </button>
        </div>
        <ul class="nav flex-column p-2">
            <?php $u = $_SERVER['REQUEST_URI']; ?>
            <li class="nav-item"><a href="<?= BASE_URL ?>admin" class="nav-link text-white <?= $u == BASE_URL.'admin' || preg_match('#^'.preg_quote(BASE_URL,'#').'admin$#', $u) ? 'active' : '' ?>"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
            <li class="nav-item"><a href="<?= BASE_URL ?>admin/productos" class="nav-link text-white <?= strpos($u,'/admin/productos') !== false ? 'active' : '' ?>"><i class="bi bi-box me-2"></i>Productos</a></li>
            <li class="nav-item"><a href="<?= BASE_URL ?>admin/familias" class="nav-link text-white <?= strpos($u,'/admin/familias') !== false ? 'active' : '' ?>"><i class="bi bi-folder me-2"></i>Familias</a></li>
            <li class="nav-item"><a href="<?= BASE_URL ?>admin/marcas" class="nav-link text-white <?= strpos($u,'/admin/marcas') !== false ? 'active' : '' ?>"><i class="bi bi-tag me-2"></i>Marcas</a></li>
            <li class="nav-item"><a href="<?= BASE_URL ?>admin/banners" class="nav-link text-white <?= strpos($u,'/admin/banners') !== false ? 'active' : '' ?>"><i class="bi bi-images me-2"></i>Banners</a></li>
            <li class="nav-item"><a href="<?= BASE_URL ?>admin/usuarios" class="nav-link text-white <?= strpos($u,'/admin/usuarios') !== false ? 'active' : '' ?>"><i class="bi bi-people me-2"></i>Usuarios</a></li>
            <li class="nav-item"><a href="<?= BASE_URL ?>admin/buenas-practicas" class="nav-link text-white <?= strpos($u,'/admin/buenas-practicas') !== false ? 'active' : '' ?>"><i class="bi bi-award me-2"></i>Buenas Prácticas</a></li>
            <li class="nav-item mt-3"><a href="<?= BASE_URL ?>" target="_blank" class="nav-link text-white"><i class="bi bi-eye me-2"></i>Ver Catálogo</a></li>
            <li class="nav-item"><a href="<?= BASE_URL ?>admin/logout" class="nav-link text-danger"><i class="bi bi-box-arrow-right me-2"></i>Salir</a></li>
        </ul>
    </nav>
    <main class="main-content flex-grow-1 p-4">
        <?= $content ?? '' ?>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>const BASE_URL = '<?= BASE_URL ?>';</script>
<script>
(function() {
    const html = document.documentElement;
    const toggle = document.getElementById('darkModeToggle');
    if (localStorage.getItem('adminDarkMode') === 'true') {
        html.setAttribute('data-bs-theme', 'dark');
        toggle.innerHTML = '<i class="bi bi-sun"></i> <span>Claro</span>';
    }
    toggle.addEventListener('click', function() {
        const isDark = html.getAttribute('data-bs-theme') === 'dark';
        html.setAttribute('data-bs-theme', isDark ? 'light' : 'dark');
        localStorage.setItem('adminDarkMode', !isDark);
        toggle.innerHTML = isDark ? '<i class="bi bi-moon-stars"></i> <span>Oscuro</span>' : '<i class="bi bi-sun"></i> <span>Claro</span>';
    });
})();
</script>
<script src="<?= BASE_URL ?>public/js/admin.js?v=<?= filemtime(__DIR__.'/../../../public/js/admin.js') ?>"></script>
</body>
</html>
