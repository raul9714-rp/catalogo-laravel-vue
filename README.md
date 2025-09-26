# Catálogo de Productos - Laravel + Vue.js

Este proyecto fue desarrollado como parte de una **evaluación técnica**.  
Se implementa un sistema de catálogo de productos con **Laravel 12, Vue 3, TailwindCSS y Docker (Sail)**.

---

## Características principales

- Listado dinámico de productos con paginación y ordenamiento.
- CRUD (crear, editar, eliminar productos).
- Validaciones en Vue.js:
  - Código único (letras y números, sin caracteres especiales).
  - Nombre con solo letras y espacios.
  - Imágenes permitidas: `jpeg, jpg, png, gif` (máx 1.5 MB).
  - Fechas en formato válido y coherentes.
- Modal para agregar y editar productos.
- Confirmación al eliminar productos.
- Overlay de carga para indicar operaciones en progreso.
- Seeder incluido con productos de ejemplo (laptops gamer, mouse gamer, etc).

---

## Requisitos

- [Docker Desktop](https://www.docker.com/products/docker-desktop) con **WSL2 habilitado**  
- Node.js y npm (dentro de Sail)  
- Composer (viene con Sail)  

---

## Instalación

-Clonar el repositorio:

git clone https://github.com/raul9714-rp/catalogo-laravel-vue.git

cd catalogo-laravel-vue

-Instalar dependencias de PHP y JS y levantar los servicios con Sail:
    ./vendor/bin/sail up -d
    ./vendor/bin/sail artisan migrate --seed
    ./vendor/bin/sail npm install
    ./vendor/bin/sail npm run dev

## Uso

-Backend disponible en: http://localhost:8080/api/productos

-Panel inicial: http://localhost:8080

## Tecnologías usadas

-Laravel 12 (Backend + API REST)

-Vue 3 con Vite (Frontend)

-TailwindCSS (Estilos)

-MySQL/MariaDB (Base de datos)

-Docker + Sail (Entorno de desarrollo)

## Capturas

**Panel de Inicio que muestra los productos inciales y que se actualiza cada que se elimina, crea o edita un producto. Tambien la paginacion que esta limitada a 3 productos.**

<img width="1265" height="456" alt="image" src="https://github.com/user-attachments/assets/a3b0aa57-c2a3-4a72-a742-1cf6f8ae54bf" />

**Modal de Agregar Producto**

<img width="452" height="800" alt="image" src="https://github.com/user-attachments/assets/08f8dad5-2b84-4c9c-a5aa-932fe740621d" />

**Modal de Editar Producto, es el mismo que agregar y trae la informacion de la base de datos**

<img width="410" height="783" alt="image" src="https://github.com/user-attachments/assets/b96956a4-869c-4439-b7b6-4b0ae9a695eb" />

**Modal de confirmacion de Eliminacion de producto**

<img width="1273" height="449" alt="image" src="https://github.com/user-attachments/assets/4cf844bc-2342-41cd-8ec6-20ed3e40aeb4" />


## Autor

**Desarrollado por Raúl Pérez**
