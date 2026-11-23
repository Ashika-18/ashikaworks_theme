<?php
/**
 * Fallback template.
 *
 * @package Ashika_Works
 */

get_header();
?>
<main id="main" class="page-main">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
            <article class="entry">
                <header class="page-hero">
                    <h1><?php the_title(); ?></h1>
                </header>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p class="empty-note">ページはまだありません。</p>
    <?php endif; ?>
</main>
<?php
get_footer();
