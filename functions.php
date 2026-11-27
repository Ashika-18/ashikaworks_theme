<?php
/**
 * Ashika Works theme setup.
 *
 * @package Ashika_Works
 */

if (!defined('ABSPATH')) {
    exit;
}

define('ASHIKA_VERSION', '1.0.0');

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('responsive-embeds');

    register_nav_menus(array(
        'primary' => 'グローバルナビ',
        'footer'  => 'フッター',
    ));

    add_image_size('ashika-works-card', 1200, 800, true);
    add_image_size('ashika-fv', 900, 1200, true);
});

add_action('after_switch_theme', function () {
    ashika_register_works();
    flush_rewrite_rules();
});

add_action('init', 'ashika_register_works');

function ashika_register_works_url_meta() {
    $auth = function () {
        return current_user_can('edit_posts');
    };
    $args = array(
        'type'              => 'string',
        'single'            => true,
        'show_in_rest'      => true,
        'sanitize_callback' => 'esc_url_raw',
        'auth_callback'     => $auth,
    );

    register_post_meta('works', 'figma_url', $args);
    register_post_meta('works', 'site_url', $args);
}

add_action('init', 'ashika_register_works_url_meta');

function ashika_figma_url_meta_box() {
    add_meta_box(
        'ashika-figma-url',
        'カスタムフィールド',
        'ashika_figma_url_meta_box_html',
        'works',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes_works', 'ashika_figma_url_meta_box');

function ashika_figma_url_meta_box_html($post) {
    wp_nonce_field('ashika_figma_url', 'ashika_figma_url_nonce');
    $figma_url = get_post_meta($post->ID, 'figma_url', true);
    $site_url = get_post_meta($post->ID, 'site_url', true);
    ?>
    <p>
        <label for="site_url"><strong>公開サイトURL（site_url）</strong></label>
    </p>
    <input type="text" class="widefat" id="site_url" name="site_url" value="<?php echo esc_attr($site_url); ?>" placeholder="https://example.com/">
    <p class="description">入力した実績だけ、詳細ページに「実際のサイトを見る」ボタンを表示します。空にすると出ません。</p>
    <p>
        <label for="figma_url"><strong>Figma設計データURL（figma_url）</strong></label>
    </p>
    <input type="text" class="widefat" id="figma_url" name="figma_url" value="<?php echo esc_attr($figma_url); ?>" placeholder="https://www.figma.com/design/...">
    <p class="description">入力した実績だけ、詳細ページに閲覧用ボタンを表示します。空にするとボタンは出ません。</p>
    <?php
}

function ashika_save_figma_url($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!isset($_POST['ashika_figma_url_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['ashika_figma_url_nonce'])), 'ashika_figma_url')) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array('figma_url', 'site_url');
    foreach ($fields as $field) {
        $url = isset($_POST[$field]) ? esc_url_raw(wp_unslash($_POST[$field])) : '';
        if ($url === '') {
            delete_post_meta($post_id, $field);
            continue;
        }
        update_post_meta($post_id, $field, $url);
    }
}

add_action('save_post_works', 'ashika_save_figma_url');

function ashika_register_works() {
    register_post_type('works', array(
        'labels' => array(
            'name'               => '制作実績',
            'singular_name'      => '制作実績',
            'add_new'            => '新規追加',
            'add_new_item'       => '制作実績を追加',
            'edit_item'          => '制作実績を編集',
            'new_item'           => '新しい制作実績',
            'view_item'          => '制作実績を表示',
            'search_items'       => '制作実績を検索',
            'not_found'          => '制作実績はありません',
            'not_found_in_trash' => 'ゴミ箱に制作実績はありません',
            'all_items'          => '制作実績一覧',
            'menu_name'          => '制作実績',
        ),
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => array('slug' => 'works'),
        'menu_icon'    => 'dashicons-portfolio',
        'menu_position'=> 5,
        'show_in_rest' => true,
        'supports'     => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
    ));
}

add_filter('excerpt_length', function () {
    return 48;
}, 20);

add_filter('excerpt_more', function () {
    return '…';
});

add_action('wp_enqueue_scripts', function () {
    $dir = get_template_directory();
    $uri = get_template_directory_uri();

    wp_enqueue_style(
        'ashika-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'ashika-reset',
        $uri . '/assets/css/reset.css',
        array('ashika-fonts'),
        filemtime($dir . '/assets/css/reset.css')
    );

    wp_enqueue_style(
        'ashika-main',
        $uri . '/assets/css/main.css',
        array('ashika-reset'),
        filemtime($dir . '/assets/css/main.css')
    );

    wp_enqueue_script(
        'ashika-main',
        $uri . '/assets/js/main.js',
        array(),
        filemtime($dir . '/assets/js/main.js'),
        true
    );
});

function ashika_image_uri($file) {
    $relative = 'assets/images/' . ltrim($file, '/');
    $path = get_theme_file_path($relative);
    if (!file_exists($path)) {
        return '';
    }
    return get_theme_file_uri($relative);
}

function ashika_page_url($slug, $fallback = '') {
    $page = get_page_by_path($slug);
    if ($page instanceof WP_Post) {
        return get_permalink($page);
    }
    return $fallback;
}

function ashika_news_url() {
    $posts_page = (int) get_option('page_for_posts');
    if ($posts_page) {
        return get_permalink($posts_page);
    }
    return home_url('/');
}

function ashika_contact_url() {
    return ashika_page_url('contact', home_url('/#contact'));
}

function ashika_line_url() {
    return 'https://line.me/R/ti/p/@210yqygp?ts=08060606&oat_content=url';
}

function ashika_trim_text($text, $length = 72) {
    $text = trim(wp_strip_all_tags($text));
    if ($text === '') {
        return '';
    }
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    return mb_substr($text, 0, $length) . '…';
}

function ashika_post_summary($post_id = 0, $length = 72) {
    $post_id = $post_id ? $post_id : get_the_ID();
    $excerpt = get_the_excerpt($post_id);
    if ($excerpt === '') {
        $excerpt = get_post_field('post_content', $post_id);
    }
    return ashika_trim_text($excerpt, $length);
}

function ashika_works_paragraph($text) {
    return "<!-- wp:paragraph -->\n<p>" . esc_html($text) . "</p>\n<!-- /wp:paragraph -->";
}

function ashika_works_heading($text) {
    return "<!-- wp:heading {\"level\":2} -->\n<h2 class=\"wp-block-heading\">" . esc_html($text) . "</h2>\n<!-- /wp:heading -->";
}

function ashika_works_overview_table($scope, $date, $url) {
    $cells = array(
        array('担当範囲', $scope),
        array('公開年月', $date),
        array('公開URL', $url),
    );
    $rows = '';
    foreach ($cells as $cell) {
        $rows .= '<tr><td>' . esc_html($cell[0]) . '</td><td>' . esc_html($cell[1]) . '</td></tr>';
    }

    return "<!-- wp:table -->\n"
        . "<figure class=\"wp-block-table\"><table><thead><tr><th>項目</th><th>内容</th></tr></thead><tbody>"
        . $rows
        . "</tbody></table></figure>\n<!-- /wp:table -->";
}

function ashika_works_blocks($lead, $problem, $proposal, $result, $scope, $date, $url) {
    $blocks = array(
        ashika_works_paragraph($lead),
        ashika_works_heading('ご相談前の課題・背景'),
        ashika_works_paragraph($problem),
        ashika_works_heading('Ashika Worksからのご提案・設計のポイント'),
        ashika_works_paragraph($proposal),
        ashika_works_heading('公開後の変化・お客様の声'),
        ashika_works_paragraph($result),
        ashika_works_heading('制作概要'),
        ashika_works_overview_table($scope, $date, $url),
    );

    return implode("\n\n", $blocks);
}

function ashika_works_preset_content() {
    return ashika_works_blocks(
        '（ここに、この実績を一言で伝える文章を記入）',
        '（ここにクライアントが抱えていた悩みや背景を記入）',
        '（ここに専門用語を使わず整理した構成・デザイン・言葉の工夫を記入）',
        '（ここに公開後の反響や運用サポート内容を記入）',
        '企画構成 / デザイン / WordPress実装 / ライティング',
        '（公開した年月を記入）',
        '（公開したサイトのURLを記入）'
    );
}

function ashika_default_works_content($content, $post) {
    if (!$post instanceof WP_Post || $post->post_type !== 'works' || $content !== '') {
        return $content;
    }

    return ashika_works_preset_content();
}

add_filter('default_content', 'ashika_default_works_content', 10, 2);

function ashika_attach_theme_image($post_id, $file) {
    $path = get_theme_file_path('assets/images/' . ltrim($file, '/'));
    if (!is_readable($path)) {
        return 0;
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $contents = file_get_contents($path);
    if ($contents === false) {
        return 0;
    }

    $upload = wp_upload_bits(basename($path), null, $contents);
    if (!empty($upload['error']) || empty($upload['file'])) {
        return 0;
    }

    $filetype = wp_check_filetype($upload['file'], null);
    $attachment_id = wp_insert_attachment(array(
        'post_mime_type' => !empty($filetype['type']) ? $filetype['type'] : 'image/jpeg',
        'post_title'     => sanitize_text_field(pathinfo($file, PATHINFO_FILENAME)),
        'post_status'    => 'inherit',
    ), $upload['file'], $post_id);

    if (is_wp_error($attachment_id) || !$attachment_id) {
        return 0;
    }

    wp_update_attachment_metadata($attachment_id, wp_generate_attachment_metadata($attachment_id, $upload['file']));
    set_post_thumbnail($post_id, $attachment_id);

    return (int) $attachment_id;
}

function ashika_seed_works_samples() {
    if (get_option('ashika_works_samples_seeded')) {
        return;
    }

    $existing = get_posts(array(
        'post_type'      => 'works',
        'post_status'    => array('publish', 'draft', 'pending', 'private', 'future'),
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ));

    if ($existing) {
        update_option('ashika_works_samples_seeded', 1);
        return;
    }

    $samples = array(
        array(
            'title'    => '播磨エリア・整体サロン 様',
            'slug'     => 'harima-seitai',
            'date'     => '2026-03-01 10:00:00',
            'file'     => 'works-02.jpg',
            'excerpt'  => '初めての人でも、予約までの流れが迷わない構成にしました。',
            'problem'  => '初めて来る方が、予約の前に「ここに頼んでよいか」をページの中で確かめきれず、行きつ戻りつしていました。',
            'proposal' => '不安が出る順にページを並べ、料金も通い方も、専門用語を使わず日常の言葉で書き直しました。',
            'result'   => '公開後も、予約までの文章と写真の差し替えを一緒に見ながら整えています。',
            'scope'    => '企画構成 / デザイン / WordPress実装 / ライティング',
            'released' => '2026年3月',
            'url'      => '（サンプルのため未設定）',
        ),
        array(
            'title'    => '加古川市・地域密着型工務店 様',
            'slug'     => 'kakogawa-komuten',
            'date'     => '2026-06-01 10:00:00',
            'file'     => 'works-01.jpg',
            'excerpt'  => '施工事例を、地域の人が探しやすい順番に並べ直しました。',
            'problem'  => '施工の写真は豊富なのに、加古川で家を考えている人が、自分の暮らしに近い事例へたどり着きにくい状態でした。',
            'proposal' => '地域と建物の種類が先に見える並びへ組み直し、専門用語は現場で使う言葉に置き換えました。',
            'result'   => '公開後も、新しい事例の載せ方と、問い合わせまでの流れを一緒に確認しています。',
            'scope'    => '企画構成 / デザイン / WordPress実装 / ライティング',
            'released' => '2026年6月',
            'url'      => '（サンプルのため未設定）',
        ),
    );

    foreach ($samples as $sample) {
        $post_id = wp_insert_post(array(
            'post_type'     => 'works',
            'post_status'   => 'publish',
            'post_title'    => $sample['title'],
            'post_name'     => $sample['slug'],
            'post_excerpt'  => $sample['excerpt'],
            'post_date'     => $sample['date'],
            'post_date_gmt' => get_gmt_from_date($sample['date']),
            'post_content'  => ashika_works_blocks(
                $sample['excerpt'],
                $sample['problem'],
                $sample['proposal'],
                $sample['result'],
                $sample['scope'],
                $sample['released'],
                $sample['url']
            ),
        ), true);

        if (is_wp_error($post_id) || !$post_id) {
            return;
        }

        ashika_attach_theme_image($post_id, $sample['file']);
    }

    update_option('ashika_works_samples_seeded', 1);
}

add_action('init', 'ashika_seed_works_samples', 20);

function ashika_upload_dir_scheme($uploads) {
    if (is_ssl() || empty($uploads['baseurl'])) {
        return $uploads;
    }

    $uploads['baseurl'] = set_url_scheme($uploads['baseurl'], 'http');
    $uploads['url'] = set_url_scheme($uploads['url'], 'http');

    return $uploads;
}

add_filter('upload_dir', 'ashika_upload_dir_scheme');

function ashika_home_url_scheme($url) {
    if (is_ssl() || $url === '') {
        return $url;
    }

    return set_url_scheme($url, 'http');
}

add_filter('home_url', 'ashika_home_url_scheme');

function ashika_nav_items() {
    return array(
        array(
            'label' => 'お知らせ',
            'url'   => ashika_news_url(),
        ),
        array(
            'label' => '私たちの想い',
            'url'   => ashika_page_url('about', home_url('/#strengths')),
        ),
        array(
            'label' => '制作サービス',
            'url'   => ashika_page_url('service', home_url('/#strengths')),
        ),
        array(
            'label' => '制作実績',
            'url'   => get_post_type_archive_link('works'),
        ),
    );
}
