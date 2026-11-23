<?php
/**
 * Site header.
 *
 * @package Ashika_Works
 */

if (!defined('ABSPATH')) {
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">本文へ進む</a>
<header class="site-header">
    <button class="nav-backdrop" type="button" data-nav-close tabindex="-1" aria-label="メニューを閉じる"></button>
    <div class="site-header-inner">
        <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>">
            <span class="site-logo-mark" aria-hidden="true"></span>
            <span class="site-logo-text">Ashika Works</span>
        </a>

        <button class="nav-toggle" type="button" data-nav-toggle aria-expanded="false" aria-controls="site-nav">
            <span class="nav-toggle-lines" aria-hidden="true"></span>
            <span class="screen-reader-text">メニュー</span>
        </button>

        <nav class="site-nav" id="site-nav" data-site-nav aria-label="主要">
            <button class="nav-close" type="button" data-nav-close>閉じる</button>
            <?php if (has_nav_menu('primary')) : ?>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'nav-list',
                    'fallback_cb'    => false,
                    'depth'          => 1,
                ));
                ?>
            <?php else : ?>
                <ul class="nav-list">
                    <?php foreach (ashika_nav_items() as $item) : ?>
                        <li><a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <a class="button button-gold nav-cta" href="<?php echo esc_url(ashika_line_url()); ?>" target="_blank" rel="noopener noreferrer">LINEで無料相談</a>
        </nav>
    </div>
</header>
