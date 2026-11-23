<?php
/**
 * Single post.
 *
 * @package Ashika_Works
 */

get_header();
?>
<main id="main" class="page-main">
    <?php while (have_posts()) : the_post(); ?>
        <?php $categories = get_the_category(); ?>
        <article class="entry">
            <header class="page-hero">
                <p class="entry-kicker">
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('Y.m.d')); ?></time>
                    <?php if (!empty($categories)) : ?>
                        <span class="news-category"><?php echo esc_html($categories[0]->name); ?></span>
                    <?php endif; ?>
                </p>
                <h1><?php the_title(); ?></h1>
            </header>
            <?php if (has_post_thumbnail()) : ?>
                <figure class="entry-visual ratio-3-2">
                    <?php the_post_thumbnail('large', array('alt' => esc_attr(get_the_title()))); ?>
                </figure>
            <?php endif; ?>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
            <p class="section-action">
                <a class="button button-navy" href="<?php echo esc_url(ashika_news_url()); ?>">お知らせ一覧へ戻る</a>
            </p>
        </article>
    <?php endwhile; ?>
</main>
<?php
get_footer();
