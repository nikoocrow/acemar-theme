# Acemar Theme - WordPress

Theme personalizado para Acemar desarrollado por **GetReady**.

## Características

- **Tipografías personalizadas:**
  - Títulos: Italiana
  - Cuerpo de texto: Tenor Sans
  - Botones: Playfair Display

- **Compilación SCSS con Gulp**
- **Diseño responsive**
- **Botones con efecto hover elegante**
- **Headings con línea decorativa amarilla**

## Instalación

1. Clonar o copiar el theme en `wp-content/themes/acemar-theme`

2. Instalar dependencias de Node.js:
```bash
cd wp-content/themes/acemar-theme
npm install
```

3. Activar el theme desde el panel de WordPress

## Desarrollo

### Compilar SCSS

Para desarrollo con watch automático:
```bash
npm run dev
```

Para compilar y minificar para producción:
```bash
npm run build
```

### Estructura de archivos

```
acemar-theme/
├── assets/
│   ├── scss/
│   │   ├── base/
│   │   │   ├── _variables.scss
│   │   │   ├── _mixins.scss
│   │   │   ├── _reset.scss
│   │   │   └── _typography.scss
│   │   ├── components/
│   │   │   └── _botones.scss
│   │   └── main.scss
│   ├── css/ (generado)
│   ├── js/
│   │   └── main.js
│   └── images/
├── inc/
├── template-parts/
├── functions.php
├── header.php
├── footer.php
├── index.php
└── style.css
```

## Uso de componentes

### Botones

```html
<!-- Botón default con borde amarillo -->
<a href="#" class="btn">Solicite su muestra</a>

<!-- Botón primario (fondo amarillo) -->
<a href="#" class="btn btn-primary">Comprar ahora</a>

<!-- Botón para fondos oscuros -->
<a href="#" class="btn btn-white">Ver más</a>

<!-- Tamaños -->
<a href="#" class="btn btn-lg">Botón grande</a>
<a href="#" class="btn btn-sm">Botón pequeño</a>
```

### Headings

Los h1, h2 y h3 automáticamente tienen la línea decorativa amarilla centrada.

```html
<h1>Productos Destacados</h1>
<h2>Nuestra Historia</h2>
<h3>Servicios</h3>

<!-- Para quitar la línea decorativa -->
<h2 class="heading-no-line">Título sin línea</h2>
```

## Personalización

### Colores

Edita las variables en `assets/scss/base/_variables.scss`:

```scss
$color-primary: #F4C430;        // Amarillo dorado
$color-secondary: #1a1a1a;      // Negro
$color-white: #ffffff;
```

### Tipografía

Las fuentes se cargan desde Google Fonts. Puedes modificar los tamaños en `_variables.scss`.

## Créditos

Desarrollado por **GetReady**
Theme: Acemar
Versión: 1.0.0
