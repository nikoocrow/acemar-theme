# Sistema de diseño — Acemar Theme

Referencia de tokens y componentes extraída del SCSS real del tema.
Última revisión: 29 ago 2026 (sobre `3e127d1` + limpieza sin commitear).

Documento visual con swatches y muestras tipográficas:
https://claude.ai/code/artifact/46578c2e-c6ea-4b57-933e-64e6dd034c83

---

## Color

### Tokens — `src/scss/base/_variables.scss`

| Token | Hex | Uso | Nº usos |
|---|---|---|---|
| `$color-primary` | `#F4C430` | Amarillo de marca: bordes de botón, línea de heading, hovers | 39 |
| `$color-white` | `#ffffff` | Fondos de tarjeta, texto sobre oscuro | 43 |
| `$color-secondary` | `#000000` | Headings, texto sobre amarillo | 29 |
| `$color-text` | `#333333` | Cuerpo de texto | 13 |
| `$color-text-light` | `#666666` | Texto secundario, metadatos | 6 |
| `$color-background` | `#f9f9f9` | Fondo alterno de sección | 3 |

**133 usos de token frente a 19 literales de color.** (Antes de la limpieza: 120 vs 60.)

### Colores que siguen sin token

| Hex | Dónde | Por qué sigue ahí |
|---|---|---|
| `#FFCC00` | `_top-bar.scss` (6×) | **Segundo amarillo**, distinto de `$color-primary`. Unificarlo cambia el render |
| `#1F2020` | `_header.scss` (2×) | Header sticky + overlay móvil |
| `#2A2B2B` | `_header.scss` | Submenú del overlay |
| `#2F3131` | `_footer.scss` | Fondo del footer |
| `#222` `#ddd` `#e0e0e0` | `_blog.scss` | Grises propios del blog |
| `#ccc` `#8B6F47` `#D9D4CC` `#E8E4DE` | `_single-proyecto.scss` | Parte de su paleta paralela |

Los tres oscuros (`#1F2020`, `#2A2B2B`, `#2F3131`) son valores distintos: darles un token
común implica **elegir uno** y cambiar el aspecto de header o footer.

### Paleta paralela — `pages/_single-proyecto.scss`

Declara sus propias variables y no usa las del tema:

```scss
$accent: #C8A96E;   // dorado apagado, sustituye al amarillo de marca
$dark:   #1A1A1A;
$mid:    #4A4A4A;
$light:  #F5F2EE;
```

### Custom property rota

`_blog.scss` usa `var(--color-primary, #333)` en 7 sitios, pero **`--color-primary` no se
define en ningún archivo del tema**. Todas caen al gris de reserva. Corregirlo cambia el
render del blog (gris → amarillo), por eso sigue pendiente.

---

## Tipografía

| Token | Familia | Rol |
|---|---|---|
| `$font-heading` | Italiana | Todos los h1–h6, peso 400, centrados |
| `$font-body` | Tenor Sans | Cuerpo, navegación, footer, tarjetas |
| `$font-button` | Playfair Display | Exclusiva de `.btn`, peso 600, uppercase |

Base: `$font-size-base: 16px` · `$line-height-base: 1.6`

### Escala de headings

| Nivel | Token | Desktop | ≤768 | ≤576 |
|---|---|---|---|---|
| h1 | `$h1-size` | 3rem / 48px | × 0.8 | × 0.6 → 28.8px |
| h2 | `$h2-size` | 2.5rem / 40px | × 0.8 | × 0.7 → 28px |
| h3 | `$h3-size` | 2rem / 32px | × 0.85 | × 0.75 |
| h4 | `$h4-size` | 1.5rem / 24px | — | × 0.9 |
| h5 | `$h5-size` | 1.25rem / 20px | — | — |
| h6 | `$h6-size` | 1rem / 16px | — | — |

⚠️ En móvil h1 (28.8px) y h2 (28px) quedan casi iguales: la jerarquía se aplana.

`_single-proyecto.scss` repite `'Italiana'` y `'Tenor Sans'` como literales en 11 sitios.

---

## Escalas

**Espaciado** (progresión de 8px):
`$spacing-xs` 0.5rem · `sm` 1rem · `md` 1.5rem · `lg` 2rem · `xl` 3rem · `xxl` 4rem

**Breakpoints** (mixin `respond-to()`):

| Nombre | Valor | Tipo |
|---|---|---|
| `mobile` | 576px | max-width |
| `tablet` | 768px | max-width |
| `nav` | 1024px | max-width |
| `desktop` | 992px | min-width |
| `wide` | 1200px | min-width |

⚠️ Franja **769–991px sin regla propia** (mezcla max/min). Hay 32 media queries escritas sin el mixin.

**Otras**: `$border-radius: 4px` · `$border-width: 2px` · `$transition-speed: 0.3s ease-in-out` · `$container-max-width: 1200px`

---

## Ancho del contenido

Definido en `layout/_content-width.scss`. Tres comportamientos:

| Qué | Ancho | Cómo |
|---|---|---|
| Bloques por defecto de Gutenberg | **1440px** centrado, con 48px de padding interno | `max-width: $content-max-width` + `margin-inline: auto` |
| Bloques del plugin Acemar (`wp-block-acemar-*`) | Ancho completo | `max-width: none` |
| Bloque de testimonios (`acemar/testimonios`) | **1440px** centrado | Excepción explícita |
| `.alignfull` / `.alignwide` de core | Sin tocar | Excluidos del selector |

```scss
$content-max-width: 1440px;
$content-padding: $spacing-xl;          // 48px — desktop
$content-padding-tablet: $spacing-md;   // 24px
$content-padding-mobile: $spacing-sm;   // 16px
```

**Dónde se aplica** — los dos contenedores donde el tema vuelca `the_content()`:

| Selector | Plantillas |
|---|---|
| `.entry-content` | `page.php`, `single.php`, `index.php` |
| `.hero-page` | `template-hero-home.php` (imprime los bloques directamente en `<main>`, sin envoltorio) |

⚠️ **No cubre `single-acemar_blog.php`**: la entrada de blog tiene su propio sistema de
ancho en `pages/_blog.scss` (`.single-blog-content .content-wrapper`).

### Detalles de implementación

- El selector general usa `:where()` para quedarse en especificidad **(0,1,0)**. Así las
  reglas propias de cada bloque —la sangría de las listas, el padding del plugin— siguen
  ganando sin necesidad de `!important`.
- El bloque de testimonios **se guarda con `.alignfull` en su propio markup**
  (`className: "acemar-testimonios alignfull"` en su `save`), así que la excepción deshace
  los tres valores que esa clase fija: `width`, `max-width` y los márgenes negativos.
- No se toca el padding interno de testimonios (`60px 40px`): es del plugin.

## Componentes

### Botones — `components/_botones.scss`

Variantes con estilo propio: `.btn-secondary` `.btn-white` `.btn-solid` `.btn-small` `.btn-large` `.btn-block`

- Hover: fondo amarillo + `translateY(-2px)` + sombra
- `.btn-primary` y `.btn-outline` son **alias sin reglas propias**: no declaraban nada que `.btn` no tuviera ya, así que sus duplicados se eliminaron. Siguen funcionando en el HTML porque siempre acompañan a `.btn`
- El botón de fondo amarillo de origen es `.btn-solid`, no `.btn-primary`
- ⚠️ `page-test-hero.php` y `demo.html` usan `.btn-lg` / `.btn-sm`, que **no existen** (son `.btn-large` / `.btn-small`). Esos botones no reciben tamaño

### Línea de heading — mixin `heading-underline()`

Firma visual del tema: h1–h3 reciben una barra de 60×3px en `$color-primary`, centrada vía `::after`. Se desactiva con `.heading-no-line`.

---

## Estructura del build

```
src/scss/style.scss  ──gulp──>  assets/css/style.css (+ .min.css + .map)
```

`npm run dev` = watch + BrowserSync · `npm run build` = compila y minifica

**Parciales excluidos del build a propósito** (documentado en `style.scss`):

| Archivo | Por qué |
|---|---|
| `layout/_navigation.scss` | Versión antigua de la navegación. Define `.main-navigation` y `.menu-toggle`, que hoy vienen de `_header.scss`. Importarlo pisa el header |
| `layout/_hero.scss` | Estilos de `.hero-page`, usada por `template-hero-home.php`. Nunca se ha compilado: importarlo cambia esa plantilla |

---

## Correcciones aplicadas (29 ago 2026)

Todas verificadas contra el CSS compilado: **0 reglas modificadas, 0 colores alterados**.

| Corrección | Archivo |
|---|---|
| `margin-bottom` muerto en `p` (lo anulaba el shorthand siguiente) | `_typography.scss` |
| `.btn-primary` y `.btn-outline` duplicaban `.btn` declaración por declaración | `_botones.scss` |
| Dos `ul li a` idénticos al `li a` anterior | `_header.scss` |
| `darken()` deprecado → `color.adjust()` (valor idéntico verificado) | `_botones.scss` |
| 23 literales hex → su token equivalente | top-bar, blog, single-proyecto |
| `utilities/_helpers` no se compilaba (44 clases inexistentes) | `style.scss` |
| Exclusión de `_navigation` y `_hero` documentada en el entry point | `style.scss` |
| `demo.html` enlazaba `main.css`, un artefacto huérfano | `demo.html` |
| README: rutas `assets/scss/` → `src/scss/`, clases y valores corregidos | `README.md` |

### Cambio de layout (29 ago 2026)

| Cambio | Archivo |
|---|---|
| Sistema de ancho de contenido a 1440px | `layout/_content-width.scss` (nuevo) |
| `p` pierde los 80px laterales fijos; `p:last-child` con `20px 50px` eliminado | `_typography.scss` |
| Listas e imágenes de Gutenberg se centran en vez de llevar margen lateral fijo | `_typography.scss` |

---

## Pendiente — requiere decisión de diseño

Nada de esto se puede corregir sin cambiar cómo se ve el tema hoy:

| Asunto | Efecto de corregirlo |
|---|---|
| `--color-primary` sin definir (7 usos) | El blog pasa de gris a amarillo |
| `.btn-lg` / `.btn-sm` inexistentes | 3 botones cambian de tamaño |
| `_hero.scss` sin compilar | `template-hero-home.php` recibe estilos que hoy no tiene |
| Dos amarillos (`#F4C430` / `#FFCC00`) | La top-bar cambia de tono |
| Tres oscuros sin token | Header o footer cambian de tono al unificarlos |
| Hueco de breakpoints 769–991px | Cambia el layout en tablet horizontal |
| h1 ≈ h2 en móvil | Cambian los tamaños de titular en móvil |
| `@import` deprecado (Dart Sass 3.0) | Migrar a `@use`/`@forward`: 16 archivos, no cambia el CSS |
