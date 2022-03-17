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
  }
}
?>