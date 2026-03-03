# Linko - 🚀

**Linko** es una aplicación web de gestión de marcadores y herramientas digitales diseñada para centralizar tus accesos directos de forma visual, organizada y eficiente. Desarrollada como proyecto personal para mi portfolio, combina una interfaz moderna con una arquitectura robusta.

🌐 **URL en vivo:** [linko.anthoox.es](https://linko.anthoox.es)

## ✨ Características Principales

- **Gestión de Categorías:** Organización fluida de aplicaciones. Incluye una categoría inteligente llamada **"General"** que se ancla automáticamente al final de la lista para mantener el orden.
- **Panel de Aplicaciones:** Permite añadir enlaces con iconos personalizados y nombres.
- **Sistema de Favoritos:** Acceso rápido en la parte superior del Dashboard para tus herramientas más usadas.
- **Modo Oscuro/Claro:** Interfaz adaptativa que respeta las preferencias del sistema o del usuario.
- **SEO & UX:** URLs amigables (slugs), optimización para Rank Math y una navegación fluida sin recargas de página gracias a Livewire.
- **Gestión de Perfil:** Control total sobre las credenciales de acceso y datos de usuario.

## 🛠️ Stack Tecnológico

- **Framework:** [Laravel 11](https://laravel.com/)
- **Frontend Dinámico:** [Livewire 3](https://livewire.laravel.com/)
- **Estilos:** [Tailwind CSS](https://tailwindcss.com/)
- **Base de Datos:** MySQL
- **Despliegue:** PHP 8.2 (Optimizado para entornos de alto rendimiento)

## 🚀 Instalación y Configuración

1. **Clonar el repositorio:**
   ```bash
   git clone [https://github.com/anthoox/Linko.git]
   cd linko
2. **Instalar dependencias:**
   composer install
   npm install && npm run build
3. **Configurar el entorno:**
   cp .env.example .env
   php artisan key:generate
4. **Ejecutar migraciones:**
   php artisan migrate --seed