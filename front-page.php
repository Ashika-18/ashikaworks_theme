<?php
/**
 * Front page.
 *
 * @package Ashika_Works
 */

get_header();

$slides = array(
    array('file' => 'fv-01.jpg', 'alt' => '手元のメモと、これから形にするWebサイトの下書き'),
    array('file' => 'fv-02.jpg', 'alt' => '木の机と、落ち着いて話せるあたたかい明かり'),
    array('file' => 'fv-03.jpg', 'alt' => '木の机の上で、スマートフォンを両手で確かめている'),
    array('file' => 'fv-04.jpg', 'alt' => 'リネンのカーテン越しに入る、やわらかい自然光'),
);

$gallery = array(
    array('file' => 'gallery-01.jpg', 'alt' => '仕事場の机とノート'),
    array('file' => 'gallery-02.jpg', 'alt' => '打ち合わせで使った資料'),
    array('file' => 'gallery-03.jpg', 'alt' => '画面に並んだ制作中のページ'),
    array('file' => 'gallery-04.jpg', 'alt' => '自然光の入る作業机'),
    array('file' => 'gallery-05.jpg', 'alt' => '完成したサイトを確認している手元'),
);

$strengths = array(
    array(
        'title' => '専門用語を使わない丁寧な対話',
        'text'  => '聞き慣れない言葉は、その場で言い換えます。強みも伝えたいことも、いつもの言葉で整理してから形にします。',
    ),
    array(
        'title' => '既製品ではない完全オリジナル設計',
        'text'  => 'ひな形の色を変えるだけにはしません。お客さんの動きに合わせ、順番も見た目も一から組み立てます。',
    ),
    array(
        'title' => '公開後の運用・集客まで伴走',
        'text'  => '公開の日がゴールではありません。文章の直し方も、地域に知ってもらう動きも、続けられる形で支えます。',
    ),
);

$works = new WP_Query(array(
    'post_type'      => 'works',
    'posts_per_page' => 2,
    'no_found_rows'  => true,
));

$news = new WP_Query(array(
    'post_type'      => 'post',
    'posts_per_page' => 3,
    'no_found_rows'  => true,
));

$fallback_works = array(
    array(
        'file'  => 'works-01.jpg',
        'title' => '加古川市・地域密着型工務店 様',
        'text'  => '施工事例を、地域の人が探しやすい順番に並べ直しました。',
    ),
    array(
        'file'  => 'works-02.jpg',
        'title' => '播磨エリア・整体サロン 様',
        'text'  => '初めての人でも、予約までの流れが迷わない構成にしました。',
    ),
);
?>
<main id="main">
    <section class="fv" aria-label="はじめに">
        <div class="fv-layout">
            <div class="fv-dots" role="tablist" aria-label="メインビジュアルの切り替え">
                <?php foreach ($slides as $index => $slide) : ?>
                    <button
                        class="fv-dot<?php echo $index === 0 ? ' is-active' : ''; ?>"
                        type="button"
                        role="tab"
                        data-fv-dot
                        aria-label="スライド<?php echo esc_attr((string) ($index + 1)); ?>"
                        aria-current="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                    ></button>
                <?php endforeach; ?>
            </div>

            <div class="fv-main">
                <div class="fv-slider" data-fv-slider>
                    <?php foreach ($slides as $index => $slide) : ?>
                        <?php $uri = ashika_image_uri($slide['file']); ?>
                        <div class="fv-slide<?php echo $index === 0 ? ' is-active' : ''; ?>">
                            <?php if ($uri) : ?>
                                <img src="<?php echo esc_url($uri); ?>" alt="<?php echo esc_attr($slide['alt']); ?>" width="900" height="1200">
                            <?php else : ?>
                                <span class="media-fallback" role="img" aria-label="<?php echo esc_attr($slide['alt']); ?>"></span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <p class="fv-vertical">想いを伝える<span class="is-gold">、</span>WEB制作<span class="is-gold">。</span></p>

            <div class="fv-side">
                <div class="fv-lead">
                    <p>専門用語は使いません。<br>まずは、あなたの事業への想いを<br>じっくり聞かせてください。</p>
                    <p>「丸め込まれそう」という不安も、<br>「作って終わり」の心配も、<br>対話を重ねながら解消していきます。</p>
                    <p>あなたの事業の歩幅に合わせて、<br>聞くことから丁寧に設計し、<br>公開したあとの集客まで伴走します。</p>
                </div>
                <div class="fv-subs">
                    <?php
                    $subs = array(
                        array('file' => 'sub-01.jpg', 'alt' => '打ち合わせで広げた資料', 'class' => 'fv-sub fv-sub-tall'),
                        array('file' => 'sub-02.jpg', 'alt' => '制作したWebサイトの画面', 'class' => 'fv-sub fv-sub-wide'),
                    );
                    foreach ($subs as $sub) :
                        $uri = ashika_image_uri($sub['file']);
                        ?>
                        <figure class="<?php echo esc_attr($sub['class']); ?>">
                            <?php if ($uri) : ?>
                                <img src="<?php echo esc_url($uri); ?>" alt="<?php echo esc_attr($sub['alt']); ?>">
                            <?php else : ?>
                                <span class="media-fallback" role="img" aria-label="<?php echo esc_attr($sub['alt']); ?>"></span>
                            <?php endif; ?>
                        </figure>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="marquee" aria-label="仕事の風景">
        <div class="marquee-track">
            <?php for ($set = 0; $set < 4; $set++) : ?>
                <div class="marquee-group" <?php echo $set >= 2 ? 'aria-hidden="true"' : ''; ?>>
                    <?php foreach ($gallery as $item) : ?>
                        <?php $uri = ashika_image_uri($item['file']); ?>
                        <figure class="marquee-item">
                            <?php if ($uri) : ?>
                                <img src="<?php echo esc_url($uri); ?>" alt="<?php echo $set === 0 ? esc_attr($item['alt']) : ''; ?>" width="280" height="280">
                            <?php else : ?>
                                <span class="media-fallback" <?php echo $set === 0 ? 'role="img" aria-label="' . esc_attr($item['alt']) . '"' : 'aria-hidden="true"'; ?>></span>
                            <?php endif; ?>
                        </figure>
                    <?php endforeach; ?>
                </div>
            <?php endfor; ?>
        </div>
    </section>

    <section class="strengths" id="strengths">
        <div class="section-head section-head-split">
            <div>
                <span class="accent-line" aria-hidden="true"></span>
                <h2 class="section-title">Ashika Worksの3つの約束</h2>
            </div>
            <p class="section-lead">事業の話を、日常の言葉のまま受け取ります。見た目を整えて渡して終わりにはせず、届けたい人に届くまで隣にいます。</p>
        </div>
        <div class="card-grid card-grid-3">
            <?php foreach ($strengths as $index => $item) : ?>
                <?php $photo = ashika_image_uri('strength-0' . ($index + 1) . '.jpg'); ?>
                <article class="info-card">
                    <figure class="ratio-3-2">
                        <?php if ($photo) : ?>
                            <img src="<?php echo esc_url($photo); ?>" alt="">
                        <?php else : ?>
                            <span class="media-fallback" aria-hidden="true"></span>
                        <?php endif; ?>
                    </figure>
                    <h3><?php echo esc_html($item['title']); ?></h3>
                    <p><?php echo esc_html($item['text']); ?></p>
                    <a class="button button-navy" href="<?php echo esc_url(ashika_contact_url()); ?>">詳しく見る</a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="works" id="works">
        <div class="section-head section-head-split">
            <div>
                <span class="accent-line" aria-hidden="true"></span>
                <h2 class="section-title">制作実績（Works）</h2>
            </div>
            <p class="section-lead">地域の事業者のサイトを、探しやすさと伝わりやすさから整えています。</p>
        </div>

        <div class="card-grid card-grid-2">
            <?php if ($works->have_posts()) : ?>
                <?php while ($works->have_posts()) : $works->the_post(); ?>
                    <article class="work-card">
                        <a class="work-card-link" href="<?php the_permalink(); ?>">
                            <figure class="ratio-3-2">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('ashika-works-card', array('alt' => esc_attr(get_the_title()))); ?>
                                <?php else : ?>
                                    <span class="media-fallback" aria-hidden="true"></span>
                                <?php endif; ?>
                            </figure>
                            <h3><?php the_title(); ?></h3>
                            <p><?php echo esc_html(ashika_post_summary(get_the_ID(), 42)); ?></p>
                        </a>
                    </article>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <?php foreach ($fallback_works as $item) : ?>
                    <article class="work-card is-fallback">
                        <?php $photo = ashika_image_uri($item['file']); ?>
                        <figure class="ratio-3-2">
                            <?php if ($photo) : ?>
                                <img src="<?php echo esc_url($photo); ?>" alt="<?php echo esc_attr($item['title']); ?>" width="1200" height="800">
                            <?php else : ?>
                                <span class="media-fallback" aria-hidden="true"></span>
                            <?php endif; ?>
                        </figure>
                        <h3><?php echo esc_html($item['title']); ?></h3>
                        <p><?php echo esc_html($item['text']); ?></p>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <p class="section-action">
            <a class="button button-gold" href="<?php echo esc_url(get_post_type_archive_link('works')); ?>">実績一覧を見る</a>
        </p>
    </section>

    <section class="news" id="news">
        <div class="news-panel">
            <div class="news-intro">
                <p class="news-kicker">News</p>
                <h2>お知らせ</h2>
                <a class="button button-gold" href="<?php echo esc_url(ashika_news_url()); ?>">一覧へ</a>
            </div>
            <div class="news-list">
                <?php if ($news->have_posts()) : ?>
                    <?php while ($news->have_posts()) : $news->the_post(); ?>
                        <?php $categories = get_the_category(); ?>
                        <a class="news-item" href="<?php the_permalink(); ?>">
                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('Y.m.d')); ?></time>
                            <?php if (!empty($categories)) : ?>
                                <span class="news-category"><?php echo esc_html($categories[0]->name); ?></span>
                            <?php endif; ?>
                            <span class="news-title"><?php the_title(); ?></span>
                        </a>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <p class="news-empty">お知らせは、準備できしだいこちらに掲載します。</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();
