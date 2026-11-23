<?php
/**
 * Single work.
 *
 * @package Ashika_Works
 */

get_header();
?>
<main id="main" class="page-main">
    <?php while (have_posts()) : the_post(); ?>
        <article class="entry works-entry">
            <header class="page-hero">
                <span class="accent-line" aria-hidden="true"></span>
                <p class="entry-kicker">Works</p>
                <h1><?php the_title(); ?></h1>
            </header>
            <?php if (has_post_thumbnail()) : ?>
                <figure class="entry-visual ratio-3-2">
                    <?php the_post_thumbnail('ashika-works-card', array('alt' => esc_attr(get_the_title()))); ?>
                </figure>
            <?php endif; ?>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
            <p class="section-action">
                <a class="button button-navy" href="<?php echo esc_url(get_post_type_archive_link('works')); ?>">実績一覧へ戻る</a>
            </p>
        </article>
    <?php endwhile; ?>
</main>
<?php
get_footer();
