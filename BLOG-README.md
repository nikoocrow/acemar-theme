# Sistema de Blog - Acemar Theme

## Características

- ✅ Custom Post Type "Blog"
- ✅ Taxonomía "Categorías del Blog"
- ✅ 3 layouts diferentes (Inspirate, Productos, Destacadas)
- ✅ Hero configurable desde Customizer
- ✅ Estilos de header configurables
- ✅ Efectos hover personalizados
- ✅ Responsive design

## Configuración

### Customizer (Apariencia > Personalizar)

- **Blog Settings**
  - Imagen Hero del Blog
  - Título Hero
  - Estilo de Header

### Categorías principales

- `inspirate` - Layout 1 grande + 3 medianas
- `productos` - Layout 3 columnas
- `publicaciones-destacadas` - Layout 2 grandes

## Archivos principales

- `archive-acemar_blog.php` - Página principal del blog
- `single-acemar_blog.php` - Post individual
- `inc/custom-post-types.php` - Registro del CPT
- `inc/acf-fields.php` - Campos ACF
- `src/scss/pages/_blog.scss` - Estilos del blog

## Desarrollo

```bash
# Compilar SCSS
gulp

# Watch mode
gulp watch
```

## Campos ACF (por post)

- Imagen Hero (opcional)
- Post Destacado (checkbox)
- Texto del botón CTA (texto)
- Resumen personalizado (textarea)
