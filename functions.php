<?php

/**
 *
 * @João Henrique
 * 26/03/2018
 * Definindo variaveis da agencia
 *
 * */
define('AG_NAME', 'Jobspace');

// E-mail da Agência
define('AG_EMAIL', 'dev@jobspace.com.br');

// REMOVE WP EMOJI
// remove_action('wp_head', 'print_emoji_detection_script', 7);
// remove_action('wp_print_styles', 'print_emoji_styles');

remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
/**
 *
 * @João Henrique
 * 26/03/2018
 * Customizando footer
 *
 * */
function remove_footer_admin()
{
    echo '<a  target="_blank">' . AG_NAME . '</a>';
}
add_filter('admin_footer_text', 'remove_footer_admin');

//Remover versao do wordpress e feeds links
function vc_remove_wp_ver_css_js($src)
{
    if (strpos($src, 'ver=' . get_bloginfo('version')))
        $src = remove_query_arg('ver', $src);
    return $src;
}
add_filter('style_loader_src', 'vc_remove_wp_ver_css_js', 9999);
add_filter('script_loader_src', 'vc_remove_wp_ver_css_js', 9999);

// remover versoes do wp
remove_action('wp_head', 'wp_generator');
function wpbeginner_remove_version()
{
    return '';
}
add_filter('the_generator', 'wpbeginner_remove_version');

function itsme_disable_feed()
{
    wp_die($message = 'Feed Desativado', $title = 'Feed Desativado',  $args = array());
}

add_action('do_feed', 'itsme_disable_feed', 1);
add_action('do_feed_rdf', 'itsme_disable_feed', 1);
add_action('do_feed_rss', 'itsme_disable_feed', 1);
add_action('do_feed_rss2', 'itsme_disable_feed', 1);
add_action('do_feed_atom', 'itsme_disable_feed', 1);
add_action('do_feed_rss2_comments', 'itsme_disable_feed', 1);
add_action('do_feed_atom_comments', 'itsme_disable_feed', 1);

remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);


// fim para remover versao e feeds


/**
 *
 * @João Henrique
 * 21/09/2017
 * Carregando Scripts
 *
 * */
function theme_scripts()
{
    // Load right jquery library.
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), '3.6.0', false);
    wp_enqueue_script('axios', get_template_directory_uri() . '/assets/js/axios.min.js', array(), '1.1.2', true);
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array(), '1.1.0', true);
    wp_enqueue_script('mask-jquery', get_template_directory_uri() . '/assets/js/jquery.mask.min.js', array(), '1.1.0', true);
    wp_enqueue_script('lity-js', get_template_directory_uri() . '/assets/js/lity.min.js', array(), '1.1.0', true);
    wp_enqueue_script('slick-js', get_template_directory_uri() .  '/assets/includes/slick/slick.min.js', array(), '1.1.0', true);
    // custom js
    wp_enqueue_script('custom-js', get_template_directory_uri() . '/assets/js/custom.js', array(), '1.1.0', true);
}
add_action('wp_enqueue_scripts', 'theme_scripts');
/**
 *
 * @João Henrique
 * 21/09/2017
 * Carregando styles
 *
 * */
function theme_styles()
{
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('slick-css', get_template_directory_uri() . '/assets/includes/slick/slick.css');
    wp_enqueue_style('lity-css', get_template_directory_uri() . '/assets/css/lity.min.css');
    // customs css project
    wp_enqueue_style('custom-components', get_template_directory_uri() . '/assets/css/custom.css');
}
add_action('wp_enqueue_scripts', 'theme_styles');
/**
 *
 * @João Henrique
 * 26/03/2018
 * Customizando box personalizado
 *
 * */

/**
 *
 * @João Henrique
 * 28/10/2015
 * Thumbs Imagens
 *
 * */
// desabilitar tumbs para gerar varias imagens
add_filter('big_image_size_threshold', '__return_false');
add_filter('intermediate_image_sizes', '__return_empty_array');
add_theme_support('post-thumbnails');
/**
 *
 * @João Henrique
 * 28/10/2015
 * Removendo metabox
 *
 * */
add_action('wp_dashboard_setup', 'wpmidia_remove_dashboard_widgets');
function wpmidia_remove_dashboard_widgets()
{
    global $wp_meta_boxes;
    // Remove o widget "Links de entrada" (Incomming links)
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    // remove o widget "Plugins"
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    unset($wp_meta_boxes['dashboard']['side']['core']['wpdm_dashboard_widget']);
    // remove o widget "Rascunhos recentes" (Recent drafts)
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    // remove o widget "QuickPress"
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    // remove o widget "Agora" (Right now)
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    // remove o widget "Blog do WordPress" (Primary)
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    // remove o widget "Outras notícias do WordPress" (Secondary)
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}
/**
 *
 * @João Henrique
 * 28/10/2015
 * Adicionando Metabox
 *
 * */
add_action('wp_dashboard_setup', 'wpmidia_custom_dashboard_widgets');
function wpmidia_custom_dashboard_widgets()
{
    global $wp_meta_boxes;
    wp_add_dashboard_widget('custom_help_widget', 'Suporte', 'wpmidia_custom_dashboard_help');
}
function wpmidia_custom_dashboard_help()
{
    echo 'Se você tiver qualquer dúvida ou precisar de ajuda, por favor, entre em contato.';
}

/**
 *
 * @João Henrique
 * 28/10/2015
 * Removendo itens do menu
 *
 * */
function remove_menus()
{

    // remove_menu_page('edit.php'); //Posts
    // remove_menu_page('edit-comments.php'); //Comments
    //remove_menu_page('themepunch-google-fonts');
    //remove_menu_page('edit.php?post_type=acf-field-group');
    //remove_menu_page('themes.php'); //Appearance
    // remove_menu_page('plugins.php'); //Plugins
    // remove_menu_page('users.php'); //Users
    //remove_menu_page('tools.php'); //Tools
    //remove_menu_page('options-general.php'); //Settings
    // plugins
    // remove_menu_page('mo_firebase_authentication'); //firebase
}
add_action('admin_menu', 'remove_menus');

/**
 *
 * @João Henrique
 * 28/10/2015
 * Registrando menu bootstrap
 *
 * */
// require_once('wp_bootstrap_navwalker.php');
/**
 *
 * @João Henrique
 * 13/03/2016
 * Adicioando itens no menu
 *
 * */
if (function_exists('acf_add_options_page')) {
    $page = acf_add_options_page(array(
        'page_title'     => 'Geral',
        'menu_title'     => 'Configurações </br>Gerais do Tema',
        'menu_slug'     => 'geral',
        'capability'     => 'edit_posts',
        'redirect'     => false
    ));
}

// We load the array of items in the variable $items
// require_once get_template_directory() . '/config/class-wp-bootstrap-navwalker.php';
// register_nav_menus(
//     array(
//         'menu-padrao' => __('Menu Pdrao', 'meu-text-domain'),
//     )
// );


// Adicione o campo de honeypot ao formulário de comentário
add_action('comment_form_logged_in_after', 'add_comment_honeypot');
add_action('comment_form_after_fields', 'add_comment_honeypot');

function add_comment_honeypot()
{
    echo '<div style="display:none"><label for="honeypot">Deixe este campo em branco</label><input type="text" name="honeypot" id="honeypot" tabindex="-1" autocomplete="off"></div>';
}

// Verifique se o campo de honeypot está vazio
add_filter('preprocess_comment', 'check_comment_honeypot');

function check_comment_honeypot($commentdata)
{
    if (!empty($_POST['honeypot'])) {
        wp_die('hoyspot ativo');
    }
    return $commentdata;
}
// load more posts api_rest category
// load more posts api_rest category
function load_more_posts_rest()
{
    $category_slugs = $_POST['category_slugs']; // Array com os slugs das categorias
    $page = $_POST['page'];

    $tax_query = array('relation' => 'OR');

    foreach ($category_slugs as $category_slug) {
        $tax_query[] = array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $category_slug,
        );
    }

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 6,
        'orderby' => 'date',
        'order' => 'DESC',
        'tax_query' => $tax_query,
        'paged' => $page
    );

    $query = new WP_Query($args);

    $posts = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            // Obtenha os dados que deseja exibir para cada post, por exemplo:
            $post_data = array(
                'title' => get_the_title(),
                'permalink' => get_permalink(),
                'date' => get_the_date(),
                'thumbnail' => get_the_post_thumbnail_url(),
                'category' => get_the_category()[0]->name
                // Adicione outros campos que você deseja exibir
            );
            $posts[] = $post_data;
        }
    }

    wp_reset_postdata();

    wp_send_json($posts);
}
add_action('wp_ajax_load_more_posts', 'load_more_posts_rest');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts_rest');

add_action('rest_api_init', function () {
    register_rest_route('blogdeville/v1', '/load-more-posts', array(
        'methods' => 'POST',
        'callback' => 'load_more_posts_rest',
    ));
});

// function remove_category($string, $type)
// {
//     if ($type != 'single' && $type == 'category' && (strpos($string, 'category') !== false)) {
//         $url_without_category = str_replace("/category/", "/", $string);
//         return trailingslashit($url_without_category);
//     }
//     return $string;
// }
// add_filter('user_trailingslashit', 'remove_category', 100, 2);
