<?php
/**
 * Works archive.
 *
 * @package Ashika_Works
 */

get_header();
?>
<main id="main" class="page-main">
    <header class="page-hero">
        <span class="accent-line" aria-hidden="true"></span>
        <h1>制作実績</h1>
    </header>

    <?php if (have_posts()) : ?>
        <div class="card-grid card-grid-2">
            <?php while (have_posts()) : the_post(); ?>
                <article class="work-card">
                    <a class="work-card-link" href="<?php the_permalink(); ?>">
                        <figure class="ratio-3-2">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('ashika-works-card', array('alt' => esc_attr(get_the_title()))); ?>
                            <?php else : ?>
                                <span class="media-fallback" aria-hidden="true"></span>
                            <?php endif; ?>
                        </figure>
                        <h2><?php the_title(); ?></h2>
                        <p><?php echo esc_html(ashika_post_summary(get_the_ID(), 64)); ?></p>
                    </a>
                </article>
            <?php endwhile; ?>
        </div>
        <nav class="pagination" aria-label="制作実績のページ">
            <?php the_posts_pagination(array(
                'mid_size'  => 1,
                'prev_text' => '前へ',
                'next_text' => '次へ',
            )); ?>
        </nav>
    <?php else : ?>
        <div class="card-grid card-grid-2">
            <?php
            $fallback_works = array(
                array('file' => 'works-01.jpg', 'title' => '加古川市・地域密着型工務店 様', 'text' => '施工事例を、地域の人が探しやすい順番に並べ直しました。'),
                array('file' => 'works-02.jpg', 'title' => '播磨エリア・整体サロン 様', 'text' => '初めての人でも、予約までの流れが迷わない構成にしました。'),
            );
            foreach ($fallback_works as $item) :
                $photo = ashika_image_uri($item['file']);
                ?>
                <article class="work-card is-fallback">
                    <figure class="ratio-3-2">
                        <?php if ($photo) : ?>
                            <img src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr($item['title']); ?>" width="1200" height="800">
                        <?php else : ?>
                            <span class="media-fallback" aria-hidden="true"></span>
                        <?php endif; ?>
                    </figure>
                    <h2><?php echo esc_html($item['title']); ?></h2>
                    <p><?php echo esc_html($item['text']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>
<?php
get_footer();
