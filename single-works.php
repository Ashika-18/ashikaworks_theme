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
                <?php
                $site_url = get_post_meta(get_the_ID(), 'site_url', true);
                $content = apply_filters('the_content', get_the_content());
                if (is_string($site_url) && $site_url !== '') {
                    $site_row = '<tr><td>' . esc_html('URL') . '</td><td><a href="' . esc_url($site_url) . '" target="_blank" rel="noopener noreferrer">' . esc_html($site_url) . '</a></td></tr>';
                    $tbody_end = strrpos($content, '</tbody>');
                    if ($tbody_end !== false) {
                        $content = substr_replace($content, $site_row . '</tbody>', $tbody_end, strlen('</tbody>'));
                    } else {
                        $content .= '<h2 class="wp-block-heading">' . esc_html('制作概要') . '</h2>';
                        $content .= '<figure class="wp-block-table"><table><thead><tr><th>' . esc_html('項目') . '</th><th>' . esc_html('内容') . '</th></tr></thead><tbody>' . $site_row . '</tbody></table></figure>';
                    }
                }
                echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                ?>
            </div>
            <?php
            $figma_url = get_post_meta(get_the_ID(), 'figma_url', true);
            $is_official_work = get_post_field('post_name', get_the_ID()) === 'ashika-works-official'
                || mb_strpos(get_the_title(), 'Ashika Works 公式Webサイト') !== false;
            if ((!is_string($figma_url) || $figma_url === '') && $is_official_work) {
                $figma_url = 'https://www.figma.com/design/3InRP1ZGQuCuAq9FpKzqOH/ashika_hp?node-id=0-1&t=uF4rJP3SmR9grl44-1';
            }
            $has_site = is_string($site_url) && $site_url !== '';
            $has_figma = is_string($figma_url) && $figma_url !== '';
            if ($has_site || $has_figma) :
                ?>
                <div class="works-figma">
                    <?php if ($has_figma) : ?>
                        <p class="works-figma-note">設計段階のデザインカンプも公開しています（ブラウザでの見やすさに合わせて調整・WordPress化しました）</p>
                    <?php endif; ?>
                    <div class="works-figma-actions">
                        <?php if ($has_site) : ?>
                            <a class="works-figma-button" href="<?php echo esc_url($site_url); ?>" target="_blank" rel="noopener noreferrer">実際のサイトを見る</a>
                        <?php endif; ?>
                        <?php if ($has_figma) : ?>
                            <a class="works-figma-button" href="<?php echo esc_url($figma_url); ?>" target="_blank" rel="noopener noreferrer">実際のFigma設計データを見る（閲覧専用・PC推奨） ↗</a>
                        <?php endif; ?>
                    </div>
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
