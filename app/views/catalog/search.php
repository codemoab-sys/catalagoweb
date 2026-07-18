<?php $title = 'Buscar Productos'; ob_start(); ?>
<section class="page-header bg-gradient-green text-white">
    <div class="container text-center">
        <h1 class="fw-bold mb-1">Productos</h1>
        <p class="mb-0 opacity-75">Explora todos nuestros productos</p>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <form method="GET" class="row g-2 mb-4" id="searchForm">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" class="form-control form-control-lg" placeholder="Buscar por nombre, código..." value="<?=htmlspecialchars($search)?>">
                </div>
            </div>
            <div class="col-md-3">
                <select name="familia" class="form-select form-select-lg">
                    <option value="">Todas las familias</option>
                    <?php foreach ($familias as $f): ?>
                        <option value="<?=$f['id']?>" <?=$selectedFamilia==$f['id']?'selected':''?>><?=htmlspecialchars($f['nombre'])?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="marca" class="form-select form-select-lg">
                    <option value="">Todas las marcas</option>
                    <?php foreach ($marcas as $m): ?>
                        <option value="<?=$m['id']?>" <?=$selectedMarca==$m['id']?'selected':''?>><?=htmlspecialchars($m['nombre'])?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill"><i class="bi bi-search me-1"></i> Buscar</button>
            </div>
        </form>

        <?php if ($search||$selectedFamilia||$selectedMarca): ?>
            <p class="text-muted mb-3"><?=count($productos)?> resultado(s)</p>
        <?php endif; ?>

        <?php if (empty($productos)): ?>
            <div class="text-center py-5" data-aos="fade-up">
                <i class="bi bi-search display-1 text-muted"></i>
                <h4 class="mt-3">No se encontraron productos</h4>
                <a href="<?=BASE_URL?>buscar" class="btn btn-primary mt-3 rounded-pill">Limpiar Filtros</a>
            </div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($productos as $p): ?>
                    <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="<?=($p['id']%4)*60?>">
                        <div class="card product-card border-0 shadow-sm h-100">
                            <div class="position-relative overflow-hidden">
                                <?php if($p['nuevo']):?><span class="badge bg-danger position-absolute top-0 end-0 m-2 z-1">Nuevo</span><?php endif;?>
                                <a href="<?=BASE_URL?>producto/<?=$p['id']?>">
                                    <?php if($p['imagen_principal']):?><img src="<?=BASE_URL.$p['imagen_principal']?>" class="card-img-top" alt="<?=htmlspecialchars($p['nombre_comercial'])?>" loading="lazy">
                                    <?php else:?><div class="bg-light d-flex align-items-center justify-content-center" style="height:200px"><i class="bi bi-image text-muted display-4"></i></div><?php endif;?>
                                </a>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <small class="text-primary fw-bold"><?=htmlspecialchars($p['codigo']??'')?></small>
                                <h6 class="fw-bold mt-1"><?=htmlspecialchars($p['nombre_comercial'])?></h6>
                                <small class="text-muted mb-2"><?=htmlspecialchars($p['familia_nombre']??'')?><?=$p['marca_nombre']?' | '.htmlspecialchars($p['marca_nombre']):''?></small>
                                <p class="text-muted small flex-grow-1"><?=htmlspecialchars(substr($p['descripcion']??'',0,80))?></p>
                                <a href="<?=BASE_URL?>producto/<?=$p['id']?>" class="btn btn-outline-primary btn-sm w-100 rounded-pill">Ver Detalle</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $content = ob_get_clean(); require __DIR__.'/layout.php'; ?>
