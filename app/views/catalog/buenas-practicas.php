<?php $title = 'Buenas Prácticas'; ob_start(); ?>
<section class="page-header bg-gradient-green text-white">
    <div class="container text-center">
        <h1 class="fw-bold mb-1">Buenas Prácticas</h1>
        <p class="mb-0 opacity-75">Recomendaciones y mejores prácticas para el uso de insumos médicos</p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <form method="GET" class="row g-2 mb-4">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" class="form-control form-control-lg" placeholder="Buscar buenas prácticas..." value="<?=htmlspecialchars($search)?>">
                </div>
            </div>
            <div class="col-md-2">
                <select name="categoria" class="form-select form-select-lg">
                    <option value="">Todas las categorías</option>
                    <option value="general" <?=$selectedCategoria=='general'?'selected':''?>>General</option>
                    <option value="seguridad" <?=$selectedCategoria=='seguridad'?'selected':''?>>Seguridad</option>
                    <option value="calidad" <?=$selectedCategoria=='calidad'?'selected':''?>>Calidad</option>
                    <option value="almacenamiento" <?=$selectedCategoria=='almacenamiento'?'selected':''?>>Almacenamiento</option>
                    <option value="higiene" <?=$selectedCategoria=='higiene'?'selected':''?>>Higiene</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill"><i class="bi bi-search me-1"></i> Buscar</button>
            </div>
        </form>

        <?php if ($search || $selectedCategoria): ?>
            <p class="text-muted mb-3"><?=count($items)?> resultado(s)</p>
        <?php endif; ?>

        <?php if (empty($items)): ?>
            <div class="text-center py-5" data-aos="fade-up">
                <i class="bi bi-award display-1 text-muted"></i>
                <h4 class="mt-3">No se encontraron buenas prácticas</h4>
                <a href="<?=BASE_URL?>buenas-practicas" class="btn btn-primary mt-3 rounded-pill">Limpiar Filtros</a>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($items as $bp): ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                                    <i class="bi bi-lightbulb text-primary fs-5"></i>
                                </div>
                                <div>
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill"><?=htmlspecialchars($bp['categoria'])?></span>
                                </div>
                            </div>
                            <h5 class="fw-bold mb-2"><?=htmlspecialchars($bp['titulo'])?></h5>
                            <?php if ($bp['descripcion']): ?>
                            <p class="text-muted small mb-3"><?=htmlspecialchars($bp['descripcion'])?></p>
                            <?php endif; ?>
                            <?php if ($bp['archivo']): ?>
                            <a href="<?=BASE_URL.$bp['archivo']?>" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill">
                                <i class="bi bi-file-earmark-pdf me-1"></i> Ver Archivo
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $content = ob_get_clean(); require __DIR__.'/layout.php'; ?>
