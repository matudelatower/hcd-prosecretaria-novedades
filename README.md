# Novedades Internas HCD

Sistema de gestión de novedades internas para el Honorable Concejo Deliberante. Permite administrar áreas, designaciones y novedades del personal.

## Instalación

### Sin Docker

1. Clonar el repositorio
2. Instalar dependencias:
   ```bash
   composer install
   npm install
   ```
3. Configurar archivo de entorno:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Configurar base de datos en `.env`
5. Ejecutar migraciones y seeders:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
6. Iniciar servidor de desarrollo:
   ```bash
   php artisan serve
   npm run dev
   ```

### Con Docker

1. Clonar el repositorio
2. Construir y levantar contenedores:
   ```bash
   docker compose up --build
   ```
3. Ejecutar migraciones y seeders:
   ```bash
   docker compose exec app php artisan migrate
   docker compose exec app php artisan db:seed
   ```

### Producción con Docker

1. Clonar el repositorio
2. Levantar contenedores de producción:
   ```bash
   docker compose -f docker-compose.prod.yml up --build
   ```

## Tecnologías

- Laravel 11
- PHP 8.2+
- MySQL
- Vue.js
- Tailwind CSS
