# Renova

Aplicación web de compraventa de móviles reacondicionados, componentes y gestión de reparaciones.

## Tecnologías

- **Backend:** Laravel 12, PHP 8.2
- **Frontend:** React + Inertia.js + Vite
- **Base de datos:** PostgreSQL (principal) / SQLite (tests)
- **Pagos:** Stripe Checkout
- **PDF:** barryvdh/laravel-dompdf
- **Tiempo real:** Reverb (notificaciones)

## Funcionalidades principales

- Catálogo y búsqueda avanzada de **móviles** y **componentes**.
- Ficha de producto con variantes (color, grado, almacenamiento) y control de stock.
- Carrito, checkout con Stripe y gestión de pedidos.
- Descarga de facturas PDF.
- Flujo de devoluciones y reembolsos.
- Solicitudes de reparación con presupuesto y seguimiento.
- Centro de soporte por tickets.
- Panel admin: CRUD de marcas/modelos/móviles/categorías/componentes, usuarios, pedidos, contabilidad.
- Sistema de notificaciones internas y por correo.

## Requisitos

- PHP 8.2+
- Composer
- Node.js 20+
- npm
- PostgreSQL 14+

## Instalación rápida (local)

```bash
# 1) Clonar
 git clone https://github.com/halabas/Renova-proyecto.git
 cd Renova-proyecto

# 2) Dependencias
 composer install
 npm install

# 3) Entorno
 cp .env.example .env
 php artisan key:generate

# 4) Configurar base de datos en .env (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 5) Migraciones y seeders
 php artisan migrate:fresh --seed

# 6) Enlace de storage para imágenes
 php artisan storage:link

# 7) Levantar en desarrollo
 composer run dev
```

## Variables de entorno importantes

Configura en `.env`:

- `APP_URL`
- `DB_*`
- `STRIPE_KEY` y `STRIPE_SECRET`
- `MAIL_*` (SMTP)
- `REVERB_*` y `VITE_REVERB_*` (si usas tiempo real)

## Usuarios de prueba (seeder)

Se crean con `UsuariosBaseSeeder`:

- `admin@renova.com` (rol admin)
- `tecnico@renova.com` (rol técnico)
- `cliente@renova.com` (rol cliente)

Contraseña para los 3: `pablopablo`

## Comandos útiles

```bash
# Ejecutar tests
php artisan test

# Lint frontend
npm run lint

# Build producción frontend
npm run build

# Refrescar BD con datos de prueba
php artisan migrate:fresh --seed
```

## Estructura relevante

- `app/Http/Controllers/` → lógica de negocio y endpoints.
- `resources/js/pages/` → pantallas Inertia/React.
- `resources/js/components/` → componentes UI reutilizables.
- `database/migrations/` → esquema de base de datos.
- `database/seeders/` → datos iniciales.
- `resources/views/facturas/` → plantillas Blade para PDF.

## Notas

- Las imágenes de seeders se leen desde `public/imagenes/...`.
- Si no se ven imágenes locales, verifica `php artisan storage:link` y permisos de `storage/`.
- Si cambias estructura de BD, vuelve a correr `php artisan migrate:fresh --seed`.
