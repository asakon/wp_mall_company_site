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
  }
}

// 子ページを取得する関数
function get_child_pages($number = -1) {
  $parent_id = get_the_ID();
  $args = array(
    'posts_per_page' => -1,
    'post_type' => 'page',
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'post_parent' => $parent_id,
  );
  $child_pages = new WP_Query( $args );
  return $child_pages;
}
?>