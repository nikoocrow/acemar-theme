# Sistema de Blog - Acemar Theme

El blog usa el post type **nativo `post`** y la taxonomía **nativa `category`**.
Hasta la unificación existía un CPT propio (`acemar_blog` + `blog_category`); ya no.

> **Por qué se unificó** — el CPT se registraba con `'rewrite' => ['slug' => 'blog']`
> y `has_archive => true`. Eso generaba la regla `blog/?$` como **primera** del array
> de rewrites, por encima de la regla de la página "Blog". Resultado: `/blog/` lo servía
> siempre el archivo del CPT y borrar la página no cambiaba nada — parecía caché.

## Cómo se resuelve `/blog/` ahora

| Ajustes > Lectura | Qué se ve en `/blog/` |
|---|---|
| Página de entradas = **Blog** | El archivo del blog (`home.php`) |
| Página de entradas = **— Seleccionar —** | La página "Blog" tal cual (`page.php`) |
| Sin página de entradas y sin la página | 404 |

## Enlaces permanentes

- Estructura: `/blog/%postname%/` → `/blog/pisos-de-madera-premium/`
- Base de categoría: `blog/categoria` → `/blog/categoria/inspirate/`

Se eligieron para que las URLs de los posts migrados no cambiaran.

## Características

- Post type y taxonomía nativos de WordPress
- 3 layouts según el slug de la categoría (Inspirate, Productos, Destacadas)
- Hero configurable desde el Customizer
- Estilos de header configurables
- Efectos hover personalizados
- Responsive design

## Configuración

### Customizer (Apariencia > Personalizar > Opciones del Tema > Blog)

- Imagen Hero del Blog
- Título Hero
- Estilo de Header
- Posts por categoría
- Texto "Ver más"

### Categorías con layout propio

- `inspirate` — grid de 3 columnas (`card-product`)
- `productos` — grid de 3 columnas (`card-product`)
- `publicaciones-destacadas` — 2 grandes (`card-featured`)

Cualquier otra categoría cae en el layout por defecto (`card-default`).

## Archivos principales

- `home.php` — archivo del blog (página de entradas)
- `single.php` — detalle del post
- `archive.php` — categoría, etiqueta, autor y fechas
- `template-parts/blog/` — hero y tarjetas
- `inc/acf-fields.php` — campos ACF (grupo `group_blog_post_settings`, sobre `post`)
- `src/scss/pages/_blog.scss` — hero, grids y tarjetas
- `src/scss/pages/_single-post.scss` — detalle del post

## Desarrollo

```bash
npm run build   # compila y minifica
npm run dev     # watch + BrowserSync
```

## Campos ACF (por post)

- `blog_hero_image` — Imagen Hero (opcional; si está vacía se usa la destacada)
- `blog_featured` — Post Destacado
- `blog_cta_text` — Texto del botón CTA
- `blog_excerpt_custom` — Resumen personalizado
- `blog_display_order` — Orden de visualización
