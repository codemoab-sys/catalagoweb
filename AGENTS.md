# AGENTS.md

## Quick start

- **Entry point**: `index.php` — custom autoloader (lowercases first dir segment: `App\Controllers\Foo` → `app/controllers/Foo.php`), all routes defined inline with `{slug}`/`{id}` patterns.
- **Server**: Apache with rewrite (`.htaccess` → all non-file requests to `index.php`). Run via Laragon or any PHP/Apache stack.
- **DB**: MySQL/MariaDB via PDO singleton (`app/core/Database.php`). Connection constants in `config/database.php`.
- **No Composer, no npm, no tests, no linter, no CI**.

## Directory layout

```
config/database.php     # DB creds, BASE_URL, site info, WhatsApp, social links
app/
  core/                 # Router, Controller, Model, Database (custom MVC)
  controllers/          # CatalogController, AdminController
  models/               # One per table (Producto, Familia, Marca, Banner, etc.)
  views/                # Plain PHP templates (catalog/, admin/)
public/
  uploads/              # File uploads destination
  css/, js/             # catalog.css / admin.css, catalog.js / admin.js
img-catalogo/           # Category images (NOT uploads)
sql/                    # Schema + seed SQL (DB name: micatalogo)
```

## Framework quirks

- **Views** use `extract($data)` in `Controller::render()` — data keys become local variables.
- **Model** base class (`app/core/Model.php`) auto-derives table from `$this->table`. Has `all`, `find`, `where`, `create`, `update`, `delete`, `query`, `queryFirst`.
- **Router** only supports `GET`/`POST`, exact URL matching via regex conversion of `{param}`.
- **Base URL** computed dynamically from server vars; `redirect()` uses `BASE_URL + path`.
- **Upload helper** (`Controller::uploadFile`) saves to `public/uploads/{folder}/` and returns relative path `public/uploads/{folder}/filename`.

## DB setup

- Schema: `sql/migracion.sql` (creates `micatalogo` database, all tables).
- Seed data: `sql/complete.sql` (familias, marcas, productos, producto_imagenes, banners).
- Tables: `familias`, `marcas`, `productos`, `producto_imagenes`, `banners`, `usuarios`, `buenas_practicas`.

## Credentials & env

- Database credentials are **hardcoded** in `config/database.php` — live production credentials.
- No `.gitignore` exists. **Do not commit `config/database.php` if deploying sensitive creds** — consider extracting to env vars.
- WhatsApp, email, phone, address, social links all in `config/database.php`.

## Admin access

- Login via `/admin/login` (POST) — `usuarios` table.
- CRUD for familias, marcas, productos (with gallery images), banners, usuarios, buenas_practicas.
