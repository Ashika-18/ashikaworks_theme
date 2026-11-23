<?php
/**
 * Contact band and site footer.
 *
 * @package Ashika_Works
 */

if (!defined('ABSPATH')) {
    exit;
}

$footer_image = ashika_image_uri('footer.jpg');
?>
<section class="contact" id="contact">
    <div class="contact-card" id="flow">
        <h2 class="section-title">ご相談から公開までの流れ</h2>
        <ol class="steps">
            <li>
                <p class="step-label">STEP 01</p>
                <p class="step-title">無料ヒアリング</p>
            </li>
            <li>
                <p class="step-label">STEP 02</p>
                <p class="step-title">ご提案・お見積り</p>
            </li>
            <li>
                <p class="step-label">STEP 03</p>
                <p class="step-title">デザイン・構築</p>
            </li>
            <li>
                <p class="step-label">STEP 04</p>
                <p class="step-title">公開・運用サポート</p>
            </li>
        </ol>
        <p class="contact-reassure">丸投げでも安心です。言葉をそろえながら、隣で進めます。</p>
        <hr class="contact-rule">
        <h3 class="contact-message">まずはお話を聞かせてください</h3>
        <p class="contact-meta">対応：地域や業種を問わず、オンラインでご相談いただけます。</p>
        <p class="contact-meta">LINE受付：24時間・年中無休で送信いただけます（※返信は2営業日以内にお送りいたします）</p>
        <a class="button button-gold button-large" href="<?php echo esc_url(ashika_line_url()); ?>" target="_blank" rel="noopener noreferrer">LINEで無料相談する</a>
        <p class="contact-line-note">※普段お使いのLINEから、一言メッセージを送るだけでお気軽にご相談いただけます。</p>
    </div>
</section>

<footer class="site-footer">
    <div class="site-footer-media" <?php echo $footer_image ? 'style="background-image:url(' . esc_url($footer_image) . ')"' : ''; ?>></div>
    <div class="site-footer-overlay"></div>
    <div class="site-footer-inner">
        <div class="footer-columns">
            <nav aria-label="コンテンツ">
                <p class="footer-label">Contents</p>
                <ul>
                    <?php foreach (ashika_nav_items() as $item) : ?>
                        <li><a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
            <nav aria-label="サポート">
                <p class="footer-label">Support</p>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/#flow')); ?>">制作の流れ</a></li>
                    <li><a href="<?php echo esc_url(ashika_page_url('faq', home_url('/#contact'))); ?>">よくある質問</a></li>
                    <li><a href="<?php echo esc_url(ashika_contact_url()); ?>">無料相談</a></li>
                </ul>
            </nav>
        </div>
        <p class="footer-tagline">Ashika Works（アシカワークス）｜地域や業種を問わず、公開したあとも伴走するWeb制作パートナー</p>
        <p class="footer-copy">&copy; <?php echo esc_html(gmdate('Y')); ?> Ashika Works All Rights Reserved.</p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
