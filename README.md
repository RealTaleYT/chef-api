# 📘 Proyecto API de Recetas (Symfony)

Este proyecto es una API REST desarrollada en Symfony que permite gestionar recetas, incluyendo sus ingredientes, pasos, nutrientes y valoraciones.

## 🚀 Requisitos
- PHP >= 8.1
- Composer
- Symfony CLI (opcional pero recomendado)
- Base de datos (SQLite, MySQL, PostgreSQL, etc.)
## 🔧 Instalación
1. Clona el repositorio:
```bash
git clone https://github.com/tu-usuario/tu-repo.git
cd tu-repo
```
Instala las dependencias:
```bash
composer install
```
Configura la base de datos en .env.local:
```bash
DATABASE_URL="mysql://usuario:contraseña@127.0.0.1:3306/tu_base_de_datos"
```
Crea la base de datos y ejecuta las migraciones:
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
##  ⚠️ Las migraciones están ignoradas en Git, deberás generarlas localmente si es necesario.
Inicia el servidor de desarrollo:
```bash
symfony server:start
```
## 📡 Endpoints disponibles
GET /recipes — Listar recetas (con filtros opcionales).
POST /recipes — Crear nueva receta.
GET /recipes/{id} — Mostrar receta específica.
Ejemplo con filtro por calorías:
GET /recipes?minCalories=100&maxCalories=500
## 📁 Estructura de Carpetas
src/Entity/ → Entidades Doctrine.
src/Controller/ → Controladores Symfony.
config/ → Archivos de configuración.
public/ → Carpeta pública.
.env / .env.local → Variables de entorno.
## 🛡️ Notas
/vendor/ y /migrations/ están ignorados en el repositorio.
Se usa Symfony Serializer para respuestas JSON limpias.
Control de errores básico implementado en los controladores.
