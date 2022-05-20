<?php


/* ---------------------------------------------------------------------------------------------
   THEME SETUP
   --------------------------------------------------------------------------------------------- */

function wps_change_role_name()
{
    global $wp_roles;
    if (!isset($wp_roles))
        $wp_roles = new WP_Roles();

    /* Rol Subscriber veranderen van naam naar Student */

    $wp_roles->roles['contributor']['name'] = 'Docent';
    $wp_roles->role_names['contributor'] = 'Docent';

    /* Rol Subscriber veranderen van naam naar Student */

    $wp_roles->roles['subscriber']['name'] = 'Student';
    $wp_roles->role_names['subscriber'] = 'Student';
}
add_action('init', 'wps_change_role_name');

if (!function_exists('rams_setup')) {

    function rams_setup()
    {

        // Automatic feed
        add_theme_support('automatic-feed-links');

        // Post thumbnails
        add_theme_support('post-thumbnails');
        add_image_size('post-image', 800, 9999);

        // Post formats
        add_theme_support('post-formats', array('gallery', 'quote'));

        add_theme_support('title-tag');

        // Jetpack infinite scroll
        add_theme_support('infinite-scroll', array(
            'container' => 'posts',
            'footer' => 'wrapper',
            'type' => 'click'
        ));

        // Add nav menu
        register_nav_menu('primary', __('Primary Menu', 'rams'));

        function wpb_custom_new_menu()
        {
            register_nav_menu('my-custom-menu', __('My Custom Menu'));
            register_nav_menu('my-admin-menu', __('My Admin Menu'));
        }

        add_action('init', 'wpb_custom_new_menu');


        // Make the theme translation ready
        load_theme_textdomain('rams', get_template_directory() . '/languages');

        $locale = get_locale();
        $locale_file = get_template_directory() . '/languages/$locale.php';

        if (is_readable($locale_file)) {
            require_once($locale_file);
        }
    }

    add_action('after_setup_theme', 'rams_setup');
}


/* ---------------------------------------------------------------------------------------------
   ENQUEUE SCRIPTS
   --------------------------------------------------------------------------------------------- */


if (!function_exists('rams_load_javascript_files')) {

    function rams_load_javascript_files()
    {

        if (!is_admin()) {
            wp_register_script('rams_global', get_template_directory_uri() . '/js/global.js', array('jquery'), '', true);
            wp_register_script('rams_flexslider', get_template_directory_uri() . '/js/flexslider.min.js', array('jquery'), '', true);

            wp_enqueue_script('rams_flexslider');
            wp_enqueue_script('rams_global');

            if (is_singular() && get_option('thread_comments')) {
                wp_enqueue_script('comment-reply');
            }
        }
    }

    add_action('wp_enqueue_scripts', 'rams_load_javascript_files');
}


/* ---------------------------------------------------------------------------------------------
   ENQUEUE STYLES
   --------------------------------------------------------------------------------------------- */


if (!function_exists('rams_load_style')) {

    function rams_load_style()
    {

        if (!is_admin()) {

            $dependencies = array();

            /**
             * Translators: If there are characters in your language that are not
             * supported by the theme fonts, translate this to 'off'. Do not translate
             * into your own language.
             */
            $google_fonts = _x('on', 'Google Fonts: on or off', 'rams');

            if ('off' !== $google_fonts) {

                // Register Google Fonts
                wp_register_style('rams_googleFonts', '//fonts.googleapis.com/css?family=Montserrat:400,500,600,700|Crimson+Text:400,700,400italic,700italic', false, 1.0, 'all');
                $dependencies[] = 'rams_googleFonts';
            }

            wp_enqueue_style('rams_style', get_stylesheet_uri(), $dependencies);
        }
    }

    add_action('wp_print_styles', 'rams_load_style');
}


/* ---------------------------------------------------------------------------------------------
   ADD EDITOR STYLES
   --------------------------------------------------------------------------------------------- */


if (!function_exists('rams_add_editor_styles')) {

    function rams_add_editor_styles()
    {

        add_editor_style('rams-editor-styles.css');

        /**
         * Translators: If there are characters in your language that are not
         * supported by the theme fonts, translate this to 'off'. Do not translate
         * into your own language.
         */
        $google_fonts = _x('on', 'Google Fonts: on or off', 'rams');

        if ('off' !== $google_fonts) {

            $font_url = '//fonts.googleapis.com/css?family=Montserrat:400,500,600,700|Crimson+Text:400,700,400italic,700italic';
            add_editor_style(str_replace(',', '%2C', $font_url));
        }
    }

    add_action('init', 'rams_add_editor_styles');
}


/* ---------------------------------------------------------------------------------------------
   SET CONTENT WIDTH
   --------------------------------------------------------------------------------------------- */


if (!isset($content_width)) $content_width = 672;


/* ---------------------------------------------------------------------------------------------
   CHECK FOR JAVASCRIPT SUPPORT
   --------------------------------------------------------------------------------------------- */


if (!function_exists('rams_html_js_class')) {

    function rams_html_js_class()
    {
        echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>' . "\n";
    }

    add_action('wp_head', 'rams_html_js_class', 1);
}


/* ---------------------------------------------------------------------------------------------
   ADD CLASSES TO PAGINATION
   --------------------------------------------------------------------------------------------- */


if (!function_exists('rams_pagination_class_next')) {

    function rams_pagination_class_next()
    {
        return 'class="archive-nav-older"';
    }

    add_filter('next_posts_link_attributes', 'rams_pagination_class_next');
}

if (!function_exists('rams_pagination_class_prev')) {

    function rams_pagination_class_prev()
    {
        return 'class="archive-nav-newer"';
    }

    add_filter('previous_posts_link_attributes', 'rams_pagination_class_prev');
}


/* ---------------------------------------------------------------------------------------------
   CUSTOM MORE LINK TEXT
   --------------------------------------------------------------------------------------------- */


if (!function_exists('rams_custom_more_link')) {

    function rams_custom_more_link($more_link, $more_link_text)
    {
        return str_replace($more_link_text, __('Read more', 'rams') . ' &rarr;', $more_link);
    }

    add_filter('the_content_more_link', 'rams_custom_more_link', 10, 2);
}


/* ---------------------------------------------------------------------------------------------
   BODY & POST CLASSES
   --------------------------------------------------------------------------------------------- */


if (!function_exists('rams_body_post_class')) {

    function rams_body_post_class($classes)
    {

        $classes[] = has_post_thumbnail() ? 'has-featured-image' : 'no-featured-image';

        return $classes;
    }

    add_filter('post_class', 'rams_body_post_class');
    add_filter('body_class', 'rams_body_post_class');
}


/* ---------------------------------------------------------------------------------------------
   STYLE ADMIN AREA
   --------------------------------------------------------------------------------------------- */


if (!function_exists('rams_admin_css')) {

    function rams_admin_css()
    {
        echo '<style type="text/css">

		#postimagediv #set-post-thumbnail img {
			max-width: 100%;
			height: auto;
		}

	</style>';
    }

    add_action('admin_head', 'rams_admin_css');
}


/* ---------------------------------------------------------------------------------------------
   FLEXSLIDER OUTPUT
   --------------------------------------------------------------------------------------------- */


if (!function_exists('rams_flexslider')) {

    function rams_flexslider($size)
    {

        $attachment_parent = is_page() ? $post->ID : get_the_ID();

        if ($images = get_posts(array(
            'post_parent' => $attachment_parent,
            'post_type' => 'attachment',
            'numberposts' => -1, // show all
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_status' => null,
            'post_mime_type' => 'image',
        ))) { ?>

            <div class="flexslider">

                <ul class="slides">

                    <?php foreach ($images as $image) :

                        global $attachment_id;

                        $default_attr = array(
                            'alt' => trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true))),
                        );

                        $attimg = wp_get_attachment_image($image->ID, $size, $default_attr); ?>

                        <li>
                            <?php echo $attimg; ?>
                        </li>

                    <?php endforeach; ?>

                </ul>

            </div><?php

                }
            }
        }


        /* ---------------------------------------------------------------------------------------------
   COMMENT FUNCTION
   --------------------------------------------------------------------------------------------- */


        if (!function_exists('rams_comment')) {

            function rams_comment($comment, $args, $depth)
            {
                switch ($comment->comment_type):
                    case 'pingback':
                    case 'trackback':
                    ?>

                <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

                    <?php __('Pingback:', 'rams'); ?><?php comment_author_link(); ?><?php edit_comment_link(__('(Edit)', 'rams'), '<span class="edit-link">', '</span>'); ?>

                </li>
            <?php
                        break;
                    default:
                        global $post;
            ?>
                <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

                    <div id="comment-<?php comment_ID(); ?>" class="comment">

                        <div class="avatar-container">
                            <?php echo get_avatar($comment, 160); ?>
                        </div>

                        <div class="comment-inner">

                            <div class="comment-header">

                                <h4><?php echo get_comment_author_link(); ?></h4>

                                <p class="comment-date"><a class="comment-date-link" href="<?php echo esc_url(get_comment_link($comment->comment_ID)) ?>" title="<?php echo get_comment_date() . ' at ' . get_comment_time(); ?>"><?php echo get_comment_date() . '<span> &mdash; ' . get_comment_time() . '</span>'; ?></a>
                                </p>

                            </div>

                            <div class="comment-content post-content">

                                <?php if ('0' == $comment->comment_approved) : ?>

                                    <p class="comment-awaiting-moderation"><?php __('Your comment is awaiting moderation.', 'rams'); ?></p>

                                <?php endif; ?>

                                <?php comment_text(); ?>

                            </div><!-- /comment-content -->

                            <div class="comment-actions">

                                <?php
                                comment_reply_link(array_merge(
                                    $args,
                                    array(
                                        'reply_text' => __('Reply', 'rams'),
                                        'depth' => $depth,
                                        'max_depth' => $args['max_depth'],
                                        'before' => '<p class="comment-reply">',
                                        'after' => '</p>'
                                    )
                                ));
                                ?>

                                <?php edit_comment_link(__('Edit', 'rams'), '<p class="comment-edit">', '</p>'); ?>

                            </div><!-- .comment-actions -->

                        </div><!-- .comment-inner -->

                    </div><!-- /comment-## -->

    <?php
                        break;
                endswitch;
            }
        }


        /* ---------------------------------------------------------------------------------------------
   CUSTOMIZER OPTIONS
   --------------------------------------------------------------------------------------------- */


        class Rams_Customize
        {

            public static function rams_register($wp_customize)
            {

                $wp_customize->add_section('rams_options', array(
                    'title' => __('Options for Rams', 'rams'),
                    'priority' => 35,
                    'capability' => 'edit_theme_options',
                    'description' => __('Allows you to customize theme settings for Rams.', 'rams'),
                ));

                $wp_customize->add_setting('accent_color', array(
                    'default' => '#6AA897',
                    'type' => 'theme_mod',
                    'transport' => 'postMessage',
                    'sanitize_callback' => 'sanitize_hex_color'
                ));

                $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'rams_accent_color', array(
                    'label' => __('Accent Color', 'rams'),
                    'section' => 'colors',
                    'settings' => 'accent_color',
                    'priority' => 10,
                )));

                //4. We can also change built-in settings by modifying properties. For instance, let's make some stuff use live preview JS...
                $wp_customize->get_setting('blogname')->transport = 'postMessage';
                $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
            }

            public static function rams_header_output()
            {

                echo '<!-- Customizer CSS -->';
                echo '<style type="text/css">';

                self::rams_generate_css('body a', 'color', 'accent_color');
                self::rams_generate_css('body a:hover', 'color', 'accent_color');
                self::rams_generate_css('.sidebar', 'background', 'accent_color');

                self::rams_generate_css('.flex-direction-nav a:hover', 'background-color', 'accent_color');
                self::rams_generate_css('a.post-quote:hover', 'background', 'accent_color');
                self::rams_generate_css('.post-title a:hover', 'color', 'accent_color');

                self::rams_generate_css('.post-content a', 'color', 'accent_color');
                self::rams_generate_css('.post-content a:hover', 'color', 'accent_color');
                self::rams_generate_css('.post-content a:hover', 'border-bottom-color', 'accent_color');
                self::rams_generate_css('.post-content a.more-link:hover', 'background', 'accent_color');
                self::rams_generate_css('.post-content input[type="submit"]:hover', 'background', 'accent_color');
                self::rams_generate_css('.post-content input[type="button"]:hover', 'background', 'accent_color');
                self::rams_generate_css('.post-content input[type="reset"]:hover', 'background', 'accent_color');

                self::rams_generate_css('.post-content .has-accent-color', 'color', 'accent_color');
                self::rams_generate_css('.post-content .has-accent-background-color', 'background-color', 'accent_color');

                self::rams_generate_css('#infinite-handle span:hover', 'background', 'accent_color');
                self::rams_generate_css('.page-links a:hover', 'background', 'accent_color');
                self::rams_generate_css('.post-meta-inner a:hover', 'color', 'accent_color');
                self::rams_generate_css('.add-comment-title a', 'color', 'accent_color');
                self::rams_generate_css('.add-comment-title a:hover', 'color', 'accent_color');
                self::rams_generate_css('.bypostauthor .avatar', 'border-color', 'accent_color');
                self::rams_generate_css('.comment-actions a:hover', 'color', 'accent_color');
                self::rams_generate_css('.comment-header h4 a:hover', 'color', 'accent_color');
                self::rams_generate_css('#cancel-comment-reply-link', 'color', 'accent_color');
                self::rams_generate_css('.comments-nav a:hover', 'color', 'accent_color');
                self::rams_generate_css('.comment-form input[type="submit"]:hover', 'background-color', 'accent_color');
                self::rams_generate_css('.logged-in-as a:hover', 'color', 'accent_color');
                self::rams_generate_css('.archive-nav a:hover', 'color', 'accent_color');

                echo '</style>';
                echo '<!--/Customizer CSS-->';
            }

            public static function rams_live_preview()
            {
                wp_enqueue_script('rams-themecustomizer', get_template_directory_uri() . '/js/theme-customizer.js', array('jquery', 'customize-preview'), '', true);
            }

            public static function rams_generate_css($selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true)
            {
                $return = '';
                $mod = get_theme_mod($mod_name);
                if (!empty($mod)) {
                    $return = sprintf('%s { %s: %s; }', $selector, $style, $prefix . $mod . $postfix);
                    if ($echo) {
                        echo $return;
                    }
                }
                return $return;
            }
        }

        // Setup the Theme Customizer settings and controls...
        add_action('customize_register', array('Rams_Customize', 'rams_register'));

        // Output custom CSS to live site
        add_action('wp_head', array('Rams_Customize', 'rams_header_output'));

        // Enqueue live preview javascript in Theme Customizer admin screen
        add_action('customize_preview_init', array('Rams_Customize', 'rams_live_preview'));


        /* ---------------------------------------------------------------------------------------------
   SPECIFY GUTENBERG SUPPORT
------------------------------------------------------------------------------------------------ */


        if (!function_exists('rams_add_gutenberg_features')) :

            function rams_add_gutenberg_features()
            {

                /* Gutenberg Palette --------------------------------------- */

                $accent_color = get_theme_mod('accent_color') ? get_theme_mod('accent_color') : '#6AA897';

                add_theme_support('editor-color-palette', array(
                    array(
                        'name' => _x('Accent', 'Name of the accent color in the Gutenberg palette', 'rams'),
                        'slug' => 'accent',
                        'color' => $accent_color,
                    ),
                    array(
                        'name' => _x('Black', 'Name of the black color in the Gutenberg palette', 'rams'),
                        'slug' => 'black',
                        'color' => '#222',
                    ),
                    array(
                        'name' => _x('Dark Gray', 'Name of the dark gray color in the Gutenberg palette', 'rams'),
                        'slug' => 'dark-gray',
                        'color' => '#444',
                    ),
                    array(
                        'name' => _x('Medium Gray', 'Name of the medium gray color in the Gutenberg palette', 'rams'),
                        'slug' => 'medium-gray',
                        'color' => '#666',
                    ),
                    array(
                        'name' => _x('Light Gray', 'Name of the light gray color in the Gutenberg palette', 'rams'),
                        'slug' => 'light-gray',
                        'color' => '#888',
                    ),
                    array(
                        'name' => _x('White', 'Name of the white color in the Gutenberg palette', 'rams'),
                        'slug' => 'white',
                        'color' => '#fff',
                    ),
                ));

                /* Gutenberg Font Sizes --------------------------------------- */

                add_theme_support('editor-font-sizes', array(
                    array(
                        'name' => _x('Small', 'Name of the small font size in Gutenberg', 'rams'),
                        'shortName' => _x('S', 'Short name of the small font size in the Gutenberg editor.', 'rams'),
                        'size' => 18,
                        'slug' => 'small',
                    ),
                    array(
                        'name' => _x('Regular', 'Name of the regular font size in Gutenberg', 'rams'),
                        'shortName' => _x('M', 'Short name of the regular font size in the Gutenberg editor.', 'rams'),
                        'size' => 22,
                        'slug' => 'regular',
                    ),
                    array(
                        'name' => _x('Large', 'Name of the large font size in Gutenberg', 'rams'),
                        'shortName' => _x('L', 'Short name of the large font size in the Gutenberg editor.', 'rams'),
                        'size' => 27,
                        'slug' => 'large',
                    ),
                    array(
                        'name' => _x('Larger', 'Name of the larger font size in Gutenberg', 'rams'),
                        'shortName' => _x('XL', 'Short name of the larger font size in the Gutenberg editor.', 'rams'),
                        'size' => 35,
                        'slug' => 'larger',
                    ),
                ));
            }

            add_action('after_setup_theme', 'rams_add_gutenberg_features');

        endif;


        /* ---------------------------------------------------------------------------------------------
   GUTENBERG EDITOR STYLES
   --------------------------------------------------------------------------------------------- */


        if (!function_exists('rams_block_editor_styles')) :

            function rams_block_editor_styles()
            {

                $dependencies = array();

                /**
                 * Translators: If there are characters in your language that are not
                 * supported by the theme fonts, translate this to 'off'. Do not translate
                 * into your own language.
                 */
                $google_fonts = _x('on', 'Google Fonts: on or off', 'rams');

                if ('off' !== $google_fonts) {

                    // Register Google Fonts
                    wp_register_style('rams-block-editor-styles-font', '//fonts.googleapis.com/css?family=Montserrat:400,500,600,700|Crimson+Text:400,700,400italic,700italic', false, 1.0, 'all');
                    $dependencies[] = 'rams-block-editor-styles-font';
                }

                // Enqueue the editor styles
                wp_enqueue_style('rams-block-editor-styles', get_theme_file_uri('/rams-gutenberg-editor-style.css'), $dependencies, '1.0', 'all');
            }

            add_action('enqueue_block_editor_assets', 'rams_block_editor_styles', 1);

        endif;



        ///* ---------------------------------------------------------------------------------------------
        //   REDIRECT LOGIN PAGE
        //   --------------------------------------------------------------------------------------------- */
        ///* ---------------------- Overwrite the original WP Login page, if the user logged in redirect to home page  ---------------------- */
        //function redirect_login_page() {
        //    $login_page  = site_url('/wat-zijn-keuzedelen/');
        //    $page_viewed = basename($_SERVER['REQUEST_URI']);
        //
        //    if($page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
        //        wp_redirect($login_page);
        ////        exit;
        //    }
        //}
        //add_action('init','redirect_login_page');
        //
        /* ---------------------- Where to go if a login failed  ---------------------- */
        //function custom_login_failed() {
        //    $login_page  = home_url();
        //    wp_redirect($login_page . '?login=failed');
        ////    exit;
        //}
        //add_action('wp_login_failed', 'custom_login_failed');

        ///* ---------------------- Where to go if any of the fields were empty  ---------------------- */
        //function verify_user_pass($username, $password) {       /* ---removed $user, --- */
        //    $login_page  = home_url('/login/');
        //    if($username == "" || $password == "") {
        //        wp_redirect($login_page . "?login=empty");
        ////        exit;
        //    }
        //}
        //add_filter('authenticate', 'verify_user_pass', 1, 3);





        /* ---------------------- What to do on logout  ---------------------- */

        add_action('wp_logout', 'ps_redirect_after_logout');
        function ps_redirect_after_logout()
        {
            wp_redirect(site_url('/wat-zijn-keuzedelen/'));
        }

        /* ---------------------------------------------------------------------------------------------
   REMOVE THE ADMIN BAR AND WP-ADMIN PERMISSION FOR ALL USERS EXCEPT ADMIN
   --------------------------------------------------------------------------------------------- */

        /* ---------------------- Remove admin bar  ---------------------- */
        add_action('after_setup_theme', 'remove_admin_bar');

        function remove_admin_bar()
        {
            if (!current_user_can('administrator') && !is_admin()) {
                show_admin_bar(false);
            }
        }

        /* ---------------------- Remove permission for wp-admin  ---------------------- */
        function ace_block_wp_admin()
        {
            if (is_admin() && !current_user_can('administrator') && !(defined('DOING_AJAX') && DOING_AJAX)) {
                wp_safe_redirect(home_url());
                //        exit;
            }
        }
        add_action('admin_init', 'ace_block_wp_admin');

        add_action('wp_login_failed', 'my_front_end_login_fail');  // hook failed login


        /*
Redirecting wp-login.php to our custom page
*/
        function redirect_login_page()
        {
            $login_page = home_url('/login/');
            $page_viewed = basename($_SERVER['REQUEST_URI']);
            if ($page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
                wp_redirect($login_page);
                exit;
            }
        }

        add_action('init', 'redirect_login_page');

        function logout_page()
        {
            $login_page = home_url('/login/');
            wp_redirect($login_page . "?login=false");
            exit;
        }
        add_action('wp_logout', 'logout_page');

        add_action('wp_login_failed', 'pu_login_failed'); // Failed Login Hook

        function pu_login_failed($user)
        {
            // checking where the login attempt came from
            $referrer = $_SERVER['HTTP_REFERER'];
            // checking if we are on the default login page
            if (!empty($referrer) && !strstr($referrer, 'wp-login') && !strstr($referrer, 'wp-admin') && $user != null) {
                // checking don't have a failed login attempt yet
                if (!strstr($referrer, '?login=failed')) {
                    // redirecting to the custom login page and appending a querystring of login failed
                    wp_redirect($referrer . '?login=failed');
                } else {
                    wp_redirect($referrer);
                }
                exit;
            }
        }
        /*
Checking if username and Password is Empty
*/

        add_action('authenticate', 'pu_blank_login');

        function pu_blank_login($user)
        {
            // check what page the login attempt is coming from
            $referrer = $_SERVER['HTTP_REFERER'];
            $error = false;
            if ($_POST['log'] == '' || $_POST['pwd'] == '') {
                $error = true;
            }
            // check that were not on the default login page
            if (!empty($referrer) && !strstr($referrer, 'wp-login') && !strstr($referrer, 'wp-admin') && $error) {
                // make sure we don't already have a failed login attempt
                if (!strstr($referrer, '?login=failed')) {
                    // Redirect to the login page and append a querystring of login failed
                    wp_redirect($referrer . '?login=failed');
                } else {
                    wp_redirect($referrer);
                }
                exit;
            }
        }

        function PWGen()
        {
            $charPile = 'a b c d e f g h i j k l m n o p q r s t u v w x y z A B C D E F G H I J K L M N O P Q R S T U V W X Y Z 1 2 3 4 5 6 7 8 9 0 ! @ # $ % ^ & *';
            $charRow = explode(" ", $charPile);
            $password = '';
            for ($x = 0; $x <= 7; $x++) {
                $randNum = rand(0, count($charRow));
                $password .= $charRow[$randNum];
            }
            return $password;
        }

        function get_current_user_role()
        {
            global $wp_roles;
            $current_user = wp_get_current_user();
            $roles = $current_user->roles;
            $role = array_shift($roles);
            return isset($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role]) : false;
        }

        function validateDate($date, $format = 'Y-m-d H:i:s')
        {
            $d = DateTime::createFromFormat($format, $date);
            return $d && $d->format($format) == $date;
        }


        add_shortcode('misha_uploader', 'misha_uploader_callback');

        function misha_uploader_callback()
        {
            return '<form action="' . get_stylesheet_directory_uri() . '/process_upload.php" method="post" enctype="multipart/form-data">
	Your Photo: <input type="file" name="profilepicture" size="25" />
	<input type="submit" name="submit" value="Submit" />
	</form>';
        }


        // function seclijst_csv_pull()
        // {

        //     global $wpdb;

        //     $table = 'Aanmelding_student_sec'; // table name
        //     $file = 'Keuzedelen_aanmeldingen'; // csv file name
        //     $results = $wpdb->get_results("SELECT * FROM $wpdb->prefix$table", ARRAY_A);
            
        //     if (count($results) > 0) {
        //         foreach ($results as $result) {
        //             $result = array_values($result);
        //             $result = implode(", ", $result);
        //             $csv_output .= $result . "\n";
        //         }
        //     }

        //     $filename = $file . "_" . date("Y-m-d_H-i", time());
        //     header("Content-type: application/vnd.ms-excel");
        //     header("Content-disposition: csv" . date("Y-m-d") . ".csv");
        //     header("Content-disposition: filename=" . $filename . ".csv");
        //     print $csv_output;
        //     exit;
        // }
        // add_action('wp_ajax_csv_pull', 'seclijst_csv_pull');
