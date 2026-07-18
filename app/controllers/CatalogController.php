<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Familia;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Banner;

class CatalogController extends Controller
{
    public function index()
    {
        $familia = new Familia();
        $producto = new Producto();
        $banner = new Banner();
        $this->render('catalog/index', [
            'familias' => $familia->activas(),
            'destacados' => $producto->destacados(8),
            'banners' => $banner->activos(),
        ]);
    }

    public function categoria($slug)
    {
        $familia = new Familia();
        $producto = new Producto();
        $marca = new Marca();

        $cat = $familia->findBySlug($slug);
        if (!$cat) {
            $cat = $familia->find($slug);
            if (!$cat) { http_response_code(404); echo 'Categoría no encontrada'; return; }
        }

        $search = $_GET['s'] ?? '';
        $marcaId = $_GET['marca'] ?? '';
        $productos = $producto->byFamilia($cat['id'], $search, $marcaId);

        $this->render('catalog/categoria', [
            'categoria' => $cat,
            'productos' => $productos,
            'familias' => $familia->activas(),
            'marcas' => $marca->activas(),
        ]);
    }

    public function detalle($id)
    {
        $producto = new Producto();
        $prod = $producto->withRelations($id);
        if (!$prod) {
            http_response_code(404);
            echo 'Producto no encontrado';
            return;
        }

        $galeria = $producto->imagenes($id);
        $relacionados = $producto->relacionados($prod['familia_id'], $id);
        $familia = new Familia();

        $this->render('catalog/detalle', [
            'producto' => $prod,
            'galeria' => $galeria,
            'relacionados' => $relacionados,
            'familias' => $familia->activas(),
        ]);
    }

    public function search()
    {
        $producto = new Producto();
        $search = $_GET['q'] ?? '';
        $familia = new Familia();
        $marca = new Marca();
        $familiaId = $_GET['familia'] ?? '';
        $marcaId = $_GET['marca'] ?? '';

        if ($familiaId || $marcaId || $search) {
            $productos = $producto->filterAll($search, $familiaId, $marcaId);
        } else {
            $productos = $producto->allWithRelations('p.orden ASC');
        }

        $this->render('catalog/search', [
            'productos' => $productos,
            'familias' => $familia->activas(),
            'marcas' => $marca->activas(),
            'search' => $search,
            'selectedFamilia' => $familiaId,
            'selectedMarca' => $marcaId,
        ]);
    }

    public function apiSearch()
    {
        $producto = new Producto();
        $search = $_GET['q'] ?? '';
        $results = $producto->search($search);
        $this->json($results);
    }
}
