# AGENTS.md - Motorcycle Shop Theme

## Project Overview
Custom WordPress theme for a motorcycle shop (Мотолавка) built on the `_s` (Underscores) starter theme. Features a modern dark UI with Tailwind CSS CDN, WooCommerce integration for product catalog, and Russian language content.

## Critical Gotchas
- **No `sass/` directory** – `npm run compile:css`, `npm run watch`, `npm run lint:scss` will fail; don't run them.
- This is a customized `_s` starter: all `_s` prefixes replaced with `motorcycle_shop` (functions, text-domain, handles). 
- All PHP functions use the `motorcycle_shop_` prefix; global namespace is otherwise clean.
- **Tailwind CSS is loaded via CDN** in `header.php`; no local Tailwind build scripts exist.
- `.kilo/agent-manager.json` determines the active worktrack/branch; verify the branch before assuming `main`.
- **WooCommerce integration**: Theme uses `product_cat` taxonomy and WooCommerce product categories extensively.
- **Custom page template**: `catalog.php` is a custom page template (Template Name: Catalog) for product catalog display.
- **Mobile menu**: Custom mobile menu overlay implemented in `header.php` with JavaScript (not using default `_s` navigation).
- **Russian content**: Template files contain Russian text; text domain `motorcycle-shop` for internationalization.

## Commands
```bash
composer install      # Install PHP dependencies (PHPCS, lint)
npm install           # Install JavaScript tools
composer lint:wpcs    # Run WordPress PHP coding standards
composer lint:php     # Run PHP syntax check
npm run lint:js       # Lint JavaScript (SCSS lint not available)
npm run bundle        # Package theme into ../_s.zip (excludes dev files)
composer make-pot     # Generate languages/_s.pot (text domain still references _s)
```

*Note:* `npm run compile:css`, `npm run watch`, and `npm run lint:scss` are unusable without adding a `sass/` folder.

## Architecture

### Entry Templates
- `index.php` - Main blog/posts index (minimal)
- `page.php` - Static pages (includes homepage sections)
- `single.php` - Single post view
- `archive.php` - Post archives
- `search.php` - Search results
- `404.php` - 404 error page
- `catalog.php` - **Custom template**: Catalog page with WooCommerce product categories
- `header.php` - Site header with Tailwind CDN, mobile menu, navigation
- `footer.php` - Site footer with contacts and navigation
- `sidebar.php` - Widget sidebar
- `comments.php` - Comments template

### Template Parts
**Content templates:**
- `template-parts/content.php` - Default content
- `template-parts/content-page.php` - Page content
- `template-parts/content-search.php` - Search results
- `template-parts/content-none.php` - No content found

**Homepage sections** (loaded in `page.php`):
- `template-parts/home/full-services.php` - Full services showcase
- `template-parts/home/popular-cat.php` - Popular categories
- `template-parts/home/popular-models.php` - Popular motorcycle models
- `template-parts/home/credit.php` - Credit/financing options
- `template-parts/home/brands.php` - Brand logos showcase
- `template-parts/home/help.php` - Help/support section
- `template-parts/home/form.php` - Contact/consultation form

### Core Files
**Includes (`inc/`):**
- `custom-header.php` - Custom header feature
- `customizer.php` - WordPress Customizer additions
- `template-tags.php` - Custom template tag functions
- `template-functions.php` - Theme enhancement functions
- `jetpack.php` - Jetpack compatibility (infinite scroll)

**JavaScript (`js/`):**
- `navigation.js` - Mobile menu toggle and focus management
- `customizer.js` - Customizer live preview

**Assets:**
- `img/` - Images, logos, icons (SVG and PNG)
- `languages/` - Translation files (.pot)

### Key Features
- **WooCommerce Product Categories**: Loaded via `get_terms('product_cat')` in homepage and catalog
- **Responsive Design**: Mobile-first with Tailwind utility classes
- **Custom Fonts**: Google Fonts (Nata Sans for headings, IBM Plex Sans for body)
- **Dark Theme**: Background color `#171A1F` with orange accent `#FF6B00`
- **Mobile Menu**: Custom overlay menu with search, navigation, and contacts

## Conventions

### Naming
- **Text domain:** `motorcycle-shop` (defined in `style.css`)
- **Function prefix:** `motorcycle_shop_` for all custom functions
- **Version constant:** `_S_VERSION` in `functions.php` (currently `1.0.0`); increment on releases
- **CSS classes:** Tailwind utility classes; custom styles in `style.css`
- **Script handles:** `motorcycle-shop-style`, `motorcycle-shop-navigation`

### Code Standards
- **Minimum requirements:** PHP 5.6, WordPress 4.5+
- **PHP:** WordPress Coding Standards (PHPCS)
- **JavaScript:** WordPress JS coding standards
- **HTML5:** Semantic markup with WordPress template hierarchy
- **License:** GPL v2 or later

### Development Workflow
1. Edit template files or `functions.php`
2. Run `composer lint:php` to check syntax
3. Run `composer lint:wpcs` for WordPress standards
4. Run `npm run lint:js` for JavaScript
5. Package with `npm run bundle` for deployment
6. Test in WordPress installation

## Theme Customization Points

### Tailwind Configuration
Located in `header.php`:
```javascript
tailwind.config = {
  theme: {
    extend: {
      fontFamily: {
        'nata': ['"Nata Sans"', 'sans-serif'],
        'plex': ['"IBM Plex Sans"', 'sans-serif']
      }
    }
  }
}
```

### Color Palette
- Background: `#171A1F` (dark)
- Primary/Accent: `#FF6B00`, `#F97316`, `#FB8A3C` (orange)
- Text: `#FFFFFF` (white), `#B8C0CC` (gray)
- Cards/Sections: `#2A3038`, `#1A1A1A`

### WooCommerce Integration
- Uses `product_cat` taxonomy for product categories
- Category thumbnails via `get_term_meta($term_id, 'thumbnail_id', true)`
- No custom WooCommerce templates (uses default)

### Menu Locations
- `menu-1` - Primary navigation (registered in `functions.php`)

### Widget Areas
- `sidebar-1` - Main sidebar

## Testing
- **No automated test suite** exists
- Manual testing requires WordPress installation with WooCommerce
- Test responsive design: mobile (< 768px), tablet (768-1024px), desktop (> 1024px)
- Verify WooCommerce product category display
- Test mobile menu toggle functionality
- Check all homepage sections render correctly

## Common Tasks

### Add New Homepage Section
1. Create file in `template-parts/home/your-section.php`
2. Add section in `page.php` after existing sections:
   ```php
   <?php get_template_part( 'template-parts/home/your-section', 'your-section' ); ?>
   ```

### Modify Catalog Template
- Edit `catalog.php` for catalog page layout
- Uses WooCommerce `product_cat` taxonomy
- Category images from term meta

### Update Navigation
- Desktop: Edit `header.php` lines 72-77
- Mobile: Edit `header.php` lines 160-166
- Footer: Edit `footer.php` navigation sections

### Add WooCommerce Support
- Theme displays product categories but doesn't have full WooCommerce integration
- To add: Create `woocommerce/` directory with custom templates
- Reference: `inc/jetpack.php` for hook patterns
