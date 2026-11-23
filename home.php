<?php
/**
 * Posts index.
 *
 * @package Ashika_Works
 */

get_header();
?>
<main id="main" class="page-main">
    <header class="page-hero">
        <span class="accent-line" aria-hidden="true"></span>
        <h1>お知らせ</h1>
        <p>公開後の運用や、制作の近況をお伝えします。</p>
    </header>

    <?php if (have_posts()) : ?>
        <div class="post-list">
            <?php while (have_posts()) : the_post(); ?>
                <?php $categories = get_the_category(); ?>
                <article class="post-row">
                    <a href="<?php the_permalink(); ?>">
                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('Y.m.d')); ?></time>
                        <?php if (!empty($categories)) : ?>
                            <span class="news-category"><?php echo esc_html($categories[0]->name); ?></span>
                        <?php endif; ?>
                        <span class="post-row-title"><?php the_title(); ?></span>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>
        <nav class="pagination" aria-label="お知らせのページ">
            <?php the_posts_pagination(array(
                'mid_size'  => 1,
                'prev_text' => '前へ',
                'next_text' => '次へ',
            )); ?>
        </nav>
    <?php else : ?>
        <p class="empty-note">お知らせは、準備できしだいこちらに掲載します。</p>
    <?php endif; ?>
</main>
<?php
get_footer();
