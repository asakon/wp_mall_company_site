<?php
function my_enqueue_scripts() {
  wp_enqueue_script('jquery');
  wp_enqueue_script('bundle_js', get_template_directory_uri(). '/assets/js/bundle.js', array() );
  wp_enqueue_style('my_styles', get_template_directory_uri(). '/assets/css/styles.css', array() );
}
add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

// ヘッダー、フッターのカスタムメニュー化
register_nav_menus(
  array(
    'place_global' => 'グローバル',
    'place_footer' => 'フッターナビ'
  )
);

// メイン画像上に表示する文字列 
function get_main_title() {
  if( is_singular( 'post' ) ) {
    // 投稿のとき、カテゴリー名を表示する
    $o = get_the_category();
    return $o[0]->name;
  } elseif ( is_page() ) {
    return get_the_title();
  } elseif ( is_category() ) {
    // カテゴリーページのとき、カテゴリー名を表示する
    return single_cat_title();
  } elseif ( is_search() ) {
    return 'サイト内検索結果';
  }
}

// 子ページを取得する関数
function get_child_pages($number = -1, $specified_id = null) {
  if( isset($specified_id) ) {
    $parent_id = $specified_id;
  } else {
    $parent_id = get_the_ID();
  }

  $args = array(
    'posts_per_page' => $number,
    'post_type' => 'page',
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'post_parent' => $parent_id,
  );

  $child_pages = new WP_Query( $args );
  return $child_pages;
}

// アイキャッチ画像
add_theme_support( 'post-thumbnails' );

// トップページのメイン画像用のサイズ設定
add_image_size( 'top', 1077, 622, true );

// 地域貢献活動一覧画像用のサイズ設定
add_image_size( 'contribution', 557, 280, true );

// トップページの地域貢献活動で使用している画像用のサイズ設定
add_image_size( 'front-contribution', 255, 189, true );

// 企業情報・店舗情報一覧画像用のサイズ設定
add_image_size( 'common', 465, 252, true );

// 各ページのメインの画像用のサイズ設定
add_image_size( 'detail', 1100, 330, true );

// 検索一覧画像用のサイズ設定
add_image_size( 'search', 168, 168, true );

// 各テンプレートごとのメイン画像を表示
function get_main_image() {
  if( is_page() || is_singular( 'daily_contribution' ) ) {
    $attachment_id = get_field( 'main_image' );
    return wp_get_attachment_image( $attachment_id, 'detail' );
  } elseif ( is_category( 'news' ) || is_singular( 'post' ) ) {
    return '<img src="'. get_template_directory_uri(). '/assets/images/bg-page-news.jpg">';
  } elseif ( is_search() ) {
    return '<img src="'. get_template_directory_uri(). '/assets/images/bg-page-search.jpg">';
  } else {
    return '<img src="'. get_template_directory_uri(). '/assets/images/bg-page-dummy.png">';
  }
}

// 特定の記事を抽出する関数
function get_specific_posts( $post_type, $taxonomy = null, $term = null, $number = -1 ) {
  $args = array(
    'post_type' => $post_type,
    'tax_query' => array(
      array(
        'taxonomy' => $taxonomy,
        'field' => 'slug',
        'terms' => $term,
      ),
    ),
    'posts_per_page' => $number,
  );
  $specific_posts = new WP_Query( $args );
  return $specific_posts;
}
?>