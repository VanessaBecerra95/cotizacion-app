<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Proyecto de Cotización con Laravel e Inertia.js

Este es un proyecto de cotización desarrollado con Laravel, Inertia.js, Vue.js y Tailwind CSS. El proyecto permite seleccionar productos, y realizar cotizaciones con una interfaz de usuario moderna. Me faltó integrar la posibilidad de crear un usuario (pendiente). 

## Requisitos

Antes de comenzar, asegúrate de tener instalados los siguientes requisitos:

- **PHP 8.1+**
- **Composer**
- **Node.js y npm** (o yarn)
- **MySQL** (o cualquier otro sistema de base de datos compatible con Laravel)
- **Laravel 10+**
- **Git** (opcional, pero recomendado para clonar el repositorio)

## Instalación

Sigue estos pasos para configurar y ejecutar el proyecto en tu entorno local:

### 1. Clonar el Repositorio

Clona el proyecto desde el repositorio:

```bash
git clone https://github.com/VanessaBecerra95/cotizacion-app

```
### 2. Configurar el Archivo .env

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 3. Ejecutar Migraciones y seeders
```bash
php artisan migrate
php artisan db:seed
```

### 4. Compilar los Assets
```bash
npm run dev
# o para una versión de producción:
npm run build
```
