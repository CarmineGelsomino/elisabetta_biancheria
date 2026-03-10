<?php
/**
 * Setup tema iTemaGold2026.
 *
 * @package iTemaGold2026
 */

if (! defined('ABSPATH')) {
    exit;
}

define('ITG_THEME_VERSION', '1.1.0');

/**
 * Default opzioni tema.
 *
 * @return array<string, string>
 */
function itemagold2026_default_options(): array
{
    return [
        'color_bg'                => '#ffffff',
        'color_text'              => '#111827',
        'color_primary'           => '#b8860b',
        'color_primary_contrast'  => '#0f172a',
        'color_focus'             => '#1d4ed8',
        'font_family'             => '"Inter", "Segoe UI", Roboto, Helvetica, Arial, sans-serif',
        'container_width'         => '80',
        'content_width'           => '75',
        'button_radius'           => '0.375',
    ];
}

/**
 * Configurazione base del tema.
 */
function itemagold2026_setup(): void
{
    load_theme_textdomain('itemagold2026', get_template_directory() . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
        'navigation-widgets',
    ]);

    add_theme_support('woocommerce', [
        'gallery_thumbnail_image_width' => 180,
        'thumbnail_image_width' => 420,
        'single_image_width' => 720,
        'product_grid' => [
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 5,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 4,
        ],
    ]);

    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-style.css');

    register_nav_menus([
        'primary' => __('Menu Principale', 'itemagold2026'),
        'footer'  => __('Menu Footer', 'itemagold2026'),
    ]);
}
add_action('after_setup_theme', 'itemagold2026_setup');

/**
 * Enqueue degli asset frontend.
 */
function itemagold2026_scripts(): void
{
    wp_enqueue_style(
        'itemagold2026-style',
        get_stylesheet_uri(),
        [],
        ITG_THEME_VERSION
    );

    wp_enqueue_style(
        'itemagold2026-app',
        get_template_directory_uri() . '/assets/css/app.css',
        ['itemagold2026-style'],
        ITG_THEME_VERSION
    );

    wp_enqueue_script(
        'itemagold2026-navigation',
        get_template_directory_uri() . '/assets/js/navigation.js',
        [],
        ITG_THEME_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'itemagold2026_scripts');

/**
 * Sanitizza valori numerici con decimali.
 */
function itemagold2026_sanitize_decimal($value): string
{
    $number = filter_var((string) $value, FILTER_VALIDATE_FLOAT);

    if ($number === false || $number < 0) {
        return '0';
    }

    return (string) $number;
}

/**
 * Registra impostazioni Customizer (Aspetto > Personalizza).
 */
function itemagold2026_customize_register(WP_Customize_Manager $wp_customize): void
{
    $defaults = itemagold2026_default_options();

    $wp_customize->add_section('itemagold2026_style_section', [
        'title'       => __('iTemaGold2026: Stile globale', 'itemagold2026'),
        'priority'    => 30,
        'description' => __('Personalizza colori, font e dettagli visivi del tema.', 'itemagold2026'),
    ]);

    $color_settings = [
        'color_bg'               => __('Colore sfondo', 'itemagold2026'),
        'color_text'             => __('Colore testo', 'itemagold2026'),
        'color_primary'          => __('Colore primario (azioni)', 'itemagold2026'),
        'color_primary_contrast' => __('Colore link/contrasto', 'itemagold2026'),
        'color_focus'            => __('Colore focus accessibilità', 'itemagold2026'),
    ];

    foreach ($color_settings as $setting_id => $label) {
        $wp_customize->add_setting($setting_id, [
            'default'           => $defaults[$setting_id],
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh',
        ]);

        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, $setting_id, [
            'label'   => $label,
            'section' => 'itemagold2026_style_section',
        ]));
    }

    $wp_customize->add_setting('font_family', [
        'default'           => $defaults['font_family'],
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('font_family', [
        'label'       => __('Font family principale', 'itemagold2026'),
        'section'     => 'itemagold2026_style_section',
        'type'        => 'text',
        'description' => __('Esempio: "Inter", "Segoe UI", sans-serif', 'itemagold2026'),
    ]);

    $wp_customize->add_setting('container_width', [
        'default'           => $defaults['container_width'],
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('container_width', [
        'label'       => __('Larghezza contenitore max (rem)', 'itemagold2026'),
        'section'     => 'itemagold2026_style_section',
        'type'        => 'number',
        'input_attrs' => ['min' => 50, 'max' => 140, 'step' => 1],
    ]);

    $wp_customize->add_setting('content_width', [
        'default'           => $defaults['content_width'],
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('content_width', [
        'label'       => __('Larghezza testo max (ch)', 'itemagold2026'),
        'section'     => 'itemagold2026_style_section',
        'type'        => 'number',
        'input_attrs' => ['min' => 45, 'max' => 95, 'step' => 1],
    ]);

    $wp_customize->add_setting('button_radius', [
        'default'           => $defaults['button_radius'],
        'sanitize_callback' => 'itemagold2026_sanitize_decimal',
        'transport'         => 'refresh',
    ]);

    $wp_customize->add_control('button_radius', [
        'label'       => __('Raggio bordi pulsanti (rem)', 'itemagold2026'),
        'section'     => 'itemagold2026_style_section',
        'type'        => 'number',
        'input_attrs' => ['min' => 0, 'max' => 3, 'step' => 0.125],
    ]);
}
add_action('customize_register', 'itemagold2026_customize_register');

/**
 * Applica CSS dinamico dal Customizer.
 */
function itemagold2026_customizer_css(): void
{
    $defaults = itemagold2026_default_options();

    $bg = sanitize_hex_color(get_theme_mod('color_bg', $defaults['color_bg'])) ?: $defaults['color_bg'];
    $text = sanitize_hex_color(get_theme_mod('color_text', $defaults['color_text'])) ?: $defaults['color_text'];
    $primary = sanitize_hex_color(get_theme_mod('color_primary', $defaults['color_primary'])) ?: $defaults['color_primary'];
    $primary_contrast = sanitize_hex_color(get_theme_mod('color_primary_contrast', $defaults['color_primary_contrast'])) ?: $defaults['color_primary_contrast'];
    $focus = sanitize_hex_color(get_theme_mod('color_focus', $defaults['color_focus'])) ?: $defaults['color_focus'];
    $font = sanitize_text_field(get_theme_mod('font_family', $defaults['font_family'])) ?: $defaults['font_family'];
    $container_width = absint(get_theme_mod('container_width', $defaults['container_width']));
    $content_width = absint(get_theme_mod('content_width', $defaults['content_width']));
    $button_radius = itemagold2026_sanitize_decimal(get_theme_mod('button_radius', $defaults['button_radius']));

    if ($container_width < 50 || $container_width > 140) {
        $container_width = (int) $defaults['container_width'];
    }

    if ($content_width < 45 || $content_width > 95) {
        $content_width = (int) $defaults['content_width'];
    }

    $css = sprintf(
        ':root{--itg-color-bg:%1$s;--itg-color-text:%2$s;--itg-color-primary:%3$s;--itg-color-primary-contrast:%4$s;--itg-focus-ring:%5$s;--itg-font-family:%6$s;--itg-max-width:%7$srem;--itg-content-width:%8$sch;--itg-button-radius:%9$srem;}',
        esc_html($bg),
        esc_html($text),
        esc_html($primary),
        esc_html($primary_contrast),
        esc_html($focus),
        esc_html($font),
        esc_html((string) $container_width),
        esc_html((string) $content_width),
        esc_html($button_radius)
    );

    wp_add_inline_style('itemagold2026-style', $css);
}
add_action('wp_enqueue_scripts', 'itemagold2026_customizer_css', 20);

/**
 * Miglioramenti SEO + GEO (semantica + geolocalizzazione aziendale).
 */
function itemagold2026_head_meta(): void
{
    $defaults = itemagold2026_default_options();
    $primary = sanitize_hex_color(get_theme_mod('color_primary', $defaults['color_primary'])) ?: $defaults['color_primary'];
    ?>
    <meta name="theme-color" content="<?php echo esc_attr($primary); ?>" />
    <meta name="geo.region" content="IT" />
    <meta name="geo.placename" content="Italia" />
    <meta name="geo.position" content="41.87194;12.56738" />
    <meta name="ICBM" content="41.87194, 12.56738" />
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "OC Corporation",
            "url": "<?php echo esc_url(home_url('/')); ?>",
            "logo": "<?php echo esc_url(get_template_directory_uri() . '/screenshot.png'); ?>",
            "address": {
                "@type": "PostalAddress",
                "addressCountry": "IT"
            }
        }
    </script>
    <?php
}
add_action('wp_head', 'itemagold2026_head_meta', 5);

/**
 * Security hardening base lato tema.
 */
function itemagold2026_security_headers(): void
{
    if (! headers_sent()) {
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
        header('Referrer-Policy: strict-origin-when-cross-origin');
    }
}
add_action('send_headers', 'itemagold2026_security_headers');

/**
 * Rimuove versione WP da output per ridurre fingerprinting.
 */
add_filter('the_generator', '__return_empty_string');

/**
 * Classe body per riconoscimento stato WooCommerce.
 */
function itemagold2026_body_classes(array $classes): array
{
    if (class_exists('WooCommerce')) {
        $classes[] = 'has-woocommerce';
    }

    return $classes;
}
add_filter('body_class', 'itemagold2026_body_classes');
