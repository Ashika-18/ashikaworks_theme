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
            <?php
            $figma_url = get_post_meta(get_the_ID(), 'figma_url', true);
            $is_official_work = get_post_field('post_name', get_the_ID()) === 'ashika-works-official'
                || mb_strpos(get_the_title(), 'Ashika Works 公式Webサイト') !== false;
            if ((!is_string($figma_url) || $figma_url === '') && $is_official_work) {
                $figma_url = 'https://www.figma.com/design/3lnRP1ZGQuCuAq9FpKzqOH/ashika_hp?node-id=0-1&t=90GTW43Q8r49wpiE-1';
            }
            if (is_string($figma_url) && $figma_url !== '') :
                ?>
                <div class="works-figma">
                    <p class="works-figma-note">設計段階のデザインカンプも公開しています（ブラウザでの見やすさに合わせて調整・WordPress化しました）</p>
                    <a class="works-figma-button" href="<?php echo esc_url($figma_url); ?>" target="_blank" rel="noopener noreferrer">実際のFigma設計データを見る（閲覧専用・PC推奨） ↗</a>
                </div>
            <?php endif; ?>
            <p class="section-action">
                <a class="button button-navy" href="<?php echo esc_url(get_post_type_archive_link('works')); ?>">実績一覧へ戻る</a>
            </p>
        </article>
    <?php endwhile; ?>
</main>
<?php
get_footer();
