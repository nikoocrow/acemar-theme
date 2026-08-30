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
├── src/
│   └── scss/
│       ├── base/
│       │   ├── _variables.scss
│       │   ├── _mixins.scss
│       │   ├── _reset.scss
│       │   └── _typography.scss
│       ├── components/
│       │   ├── _botones.scss
│       │   └── _top-bar.scss
│       ├── layout/
│       │   ├── _header.scss
│       │   ├── _footer.scss
│       │   └── _blocks.scss
│       ├── pages/
│       │   ├── _blog.scss
│       │   ├── _single-proyecto.scss
│       │   └── _404.scss
│       ├── utilities/
│       │   └── _helpers.scss
│       └── style.scss        ← entry point del build
├── assets/
│   ├── css/                  (generado por Gulp)
│   ├── js/
│   └── imagenes/
├── inc/
├── template-parts/
├── functions.php
├── header.php
├── footer.php
├── index.php
└── style.css
```

> El SCSS vive en `src/scss/`, no en `assets/`. Gulp compila `src/scss/style.scss`
> y escribe `assets/css/style.css` (+ `.min.css` y el sourcemap).

## Uso de componentes

### Botones

```html
<!-- Botón default: borde amarillo, fondo transparente -->
<a href="#" class="btn">Solicite su muestra</a>

<!-- Fondo amarillo sólido -->
<a href="#" class="btn btn-solid">Comprar ahora</a>

<!-- Borde negro, se rellena en hover -->
<a href="#" class="btn btn-secondary">Contactar</a>

<!-- Para fondos oscuros -->
<a href="#" class="btn btn-white">Ver más</a>

<!-- Ancho completo -->
<a href="#" class="btn btn-block">Enviar</a>

<!-- Tamaños -->
<a href="#" class="btn btn-large">Botón grande</a>
<a href="#" class="btn btn-small">Botón pequeño</a>
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

> **Nota:** `.btn-primary` y `.btn-outline` existen como alias pero no tienen
> reglas propias — no declaran nada que `.btn` no tenga ya. El botón con fondo
> amarillo de origen es `.btn-solid`.

## Personalización

### Colores

Edita las variables en `src/scss/base/_variables.scss`:

```scss
$color-primary: #F4C430;        // Amarillo dorado
$color-secondary: #000000;      // Negro
$color-white: #ffffff;
$color-text: #333333;           // Cuerpo de texto
$color-text-light: #666666;     // Texto secundario
$color-background: #f9f9f9;     // Fondo alterno
```

### Tipografía

Las fuentes se cargan desde Google Fonts. Puedes modificar los tamaños en `src/scss/base/_variables.scss`.

El inventario completo de color, tipografía y componentes está en [DESIGN-SYSTEM.md](DESIGN-SYSTEM.md).

## Créditos

Desarrollado por **GetReady**
Theme: Acemar
Versión: 1.0.0
