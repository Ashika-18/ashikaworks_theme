<?php
/**
 * Static page.
 *
 * @package Ashika_Works
 */

get_header();
?>
<main id="main" class="page-main">
    <?php while (have_posts()) : the_post(); ?>
        <article class="entry">
            <header class="page-hero">
                <span class="accent-line" aria-hidden="true"></span>
                <h1><?php the_title(); ?></h1>
            </header>
            <?php if (is_page('contact')) : ?>
                <aside class="line-consult">
                    <span class="accent-line" aria-hidden="true"></span>
                    <h2>公式LINEでのご相談はこちら</h2>
                    <p>このページに表示したQRコードを、スマホのカメラで読み取れます。ボタンからも、別のタブで公式LINEを開けます。</p>
                    <?php $line_qr = ashika_image_uri('line-qr.png'); ?>
                    <img class="line-qr" src="<?php echo esc_url($line_qr ? $line_qr : 'https://qr-official.line.me/gs/M_210yqygp_GW.png'); ?>" alt="Ashika Works 公式LINEのQRコード" width="220" height="220">
                    <a class="button button-gold" href="<?php echo esc_url(ashika_line_url()); ?>" target="_blank" rel="noopener noreferrer">LINEで無料相談する</a>
                    <p class="contact-line-note">※普段お使いのLINEから、一言メッセージを送るだけでお気軽にご相談いただけます。</p>
                </aside>
            <?php endif; ?>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</main>
<?php
get_footer();
