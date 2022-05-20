<?php
$currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if (!is_user_logged_in() && $currentURL != 'https://test.stichtingivs.nl/') {
    ob_start(); // ensures anything dumped out will be caught

    // do stuff here
    $url = 'https://test.stichtingivs.nl/'; // this can be set based on whatever

    // clear out the output buffer
    while (ob_get_status()) {
        ob_end_clean();
    }

    // no redirect
    header("Location: $url");
}
include_once KEUZEDELEN_SYSTEEM_PLUGIN_MODEL_DIR . "/Branch.php";

$branch = new Branch;

?>
<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

<head>
    <link href="https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <meta http-equiv="Content-type" content="text/html;charset=<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="<?php echo get_template_directory_uri() ?>/fontawesome/css/fontawesome.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri() ?>/fontawesome/css/brands.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri() ?>/fontawesome/css/solid.css" rel="stylesheet">

    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
    <?php
    global $post;
    $post_id = $post->ID;
    $link = $_SERVER['REQUEST_URI'];



    if (strpos(substr($link, 0, 10), 'Keuzedeel') !== false || strpos(substr($link, 0, 11), 'keuzedelen') !== false || strpos(substr($link, 0, 12), 'opleidingen') !== false || strpos(substr($link, 0, 9), 'branches')) {
        $aanbod = 'active';
    } else if ($post_id == 45 || $post_id == 47 || $post_id == 55 || $post_id == 59 || $post_id == 57) {
        $info = 'active';
    } else if ($post_id == 103 || $post_id == 106 || $post_id == 194 || $post_id == 91 || $post_id == 239) {
        $admin = 'active';
    }
    ?>
    <script>
        function toggleMenus(id) {
            if (id == "info-toggle") {
                document.getElementById('info-menu').classList.remove("sub-menu")
                document.getElementById('info-menu').removeAttribute("style");
                document.getElementById('aanbod-menu').style.display = "none";
                document.getElementById('admin-menu').style.display = "none";
            } else if (id == "aanbod-toggle") {
                document.getElementById('aanbod-menu').removeAttribute("style");
                document.getElementById('aanbod-menu').classList.remove("sub-menu")
                document.getElementById('info-menu').style.display = "none";
                document.getElementById('admin-menu').style.display = "none";
            } else if (id == "admin-toggle") {
                document.getElementById('admin-menu').removeAttribute("style");
                document.getElementById('admin-menu').classList.remove("sub-menu")
                document.getElementById('aanbod-menu').style.display = "none";
                document.getElementById('info-menu').style.display = "none";
            }
        }
    </script>


    <?php


    if (function_exists('wp_body_open')) {
        wp_body_open();
    }
    ?>
    <div class="sidebar">

        <div class="sidebar-inner">
            <a class="blog-logo" href='<?php echo esc_url(site_url('/wat-zijn-keuzedelen/')); ?>' title='<?php echo esc_attr(get_bloginfo('title')); ?> &mdash; <?php echo esc_attr(get_bloginfo('description')); ?>' rel='home'>
                <div class="header-img">
                    <img class="header-img" src="https://test.stichtingivs.nl/wp-content/uploads/2019/06/Scalda-druppel.png">
            </a>
        </div>
        <?php if (get_theme_mod('rams_logo')) : ?>

            <a class="blog-logo" href='<?php echo esc_url(site_url('/wat-zijn-keuzedelen/')); ?>' title='<?php echo esc_attr(get_bloginfo('title')); ?> &mdash; <?php echo esc_attr(get_bloginfo('description')); ?>' rel='home'>
                <img src='<?php echo esc_url(get_theme_mod('rams_logo')); ?>' alt='<?php echo esc_attr(get_bloginfo('title')); ?>'>
            </a>

        <?php elseif (get_bloginfo('description') || get_bloginfo('title')) : ?>

            <div class="header-img2">
                <img class="header-img2" src="https://test.stichtingivs.nl/wp-content/uploads/2019/06/Scalda-druppel.png">

            </div>

        <?php endif; ?>
        <div style="font-size:24px; margin-bottom: 40px; border-radius:10px 10px 10px 10px; background:white; padding:10%;" class="TextRun">
            <?php
            global $current_user;
            wp_get_current_user();
            if (is_user_logged_in()) {

            ?>
                <!--<img style="margin: 5px 0px 5px 5px; filter: brightness(0) invert(1); width: 40px; height: 40px" src="<?php //echo get_bloginfo('template_url');
                                                                                                                            ?>/f.png">-->
            <?php
                if (get_current_user_role() == "Student") {
                    echo '<b>Ingelogd als:</b><br>' . $current_user->display_name . '<br> <b>Opleiding:</b><br>' . $current_user->crebo . '<br><b>Rol(len):</b><br>' .  get_current_user_role();
                } else {
                    echo '<b>Ingelogd als:</b><br>' . $current_user->display_name . '<br><b>Rol(len):</b><br>' .  get_current_user_role();
                }
            }

            ?>
        </div>

        <a class="nav-toggle hidden9" title="<?php _e('Click to view the navigation', 'rams'); ?>" href="#">

            <div class="bars">

                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>


                <div class="clear"></div>

            </div>

            <p>
                <span class="menu"><?php _e('Menu', 'rams'); ?></span>
                <span class="close9"><?php _e('Close', 'rams'); ?></span>
            </p>

        </a>
        <div class="navbar">
            <ul class="main-menu menu">

                <li>
                    <a style="cursor:pointer;" class="linkMainMenu" onclick="toggleMenus('info-toggle')" id="info-toggle">Info></a>
                    <ul class="<?php if ($info != 'active') {
                                    echo 'sub-menu';
                                } ?>" id="info-menu">
                        <?php wp_nav_menu(array(
                            'theme_location' => 'my-custom-menu',
                            'container_class' => 'custom-menu-class'
                        ));
                        ?>

                    </ul>
                </li>
                <li>

                    <a style="cursor:pointer;" class="linkMainMenu" onclick="toggleMenus('aanbod-toggle')" id="aanbod-toggle">Aanbod></a>
                    <ul class="<?php if ($aanbod != 'active') {
                                    echo 'sub-menu';
                                } ?>" id="aanbod-menu">
                        <a href="/zoek-keuzedelen/">
                        <li>
                            Zoek Keuzedelen
                        </li>
                        </a>
                        <a href="<?php echo get_page_link(15); ?>">
                            <li>
                                Alle Branches
                            </li>
                        </a>
                        <?php
                        $url = get_site_url();
                        $url .= "/opleidingen";
                        $branches = $branch->getAlleBranches();

                        foreach ($branches as $branch_) {
                            $url .= "?id=" . $branch_->getBranchID();

                        ?>
                            <a href="<?= $url ?>">
                                <li><?= $branch_->getBranchName(); ?></li>
                            </a>
                        <?php
                            $newurl = str_replace("?id=" . $branch_->getBranchID(), "", $url);
                            $url = $newurl;
                        }
                        ?>
                    </ul>
                </li>
                <?php
                $wp_user = wp_get_current_user();
                if (in_array('contributor', (array) $wp_user->roles)) { ?>
                    <li>
                        <a style="cursor:pointer;" class="linkMainMenu" onclick="toggleMenus('admin-toggle')" id="admin-toggle">Admin></a>
                        <ul class="<?php if ($admin != 'active') {
                                        echo 'sub-menu';
                                    } ?>" id="admin-menu">
                            <?php wp_nav_menu(array(
                                'theme_location' => 'my-admin-menu',
                                'container_class' => 'custom-menu-class'
                            ));
                            ?>

                        </ul>
                    </li>
                <?php };
                if (current_user_can('administrator') || current_user_can('docent')) { ?>
                    <li>
                        <a style="cursor:pointer;" class="linkMainMenu" onclick="toggleMenus('admin-toggle')" id="admin-toggle">Admin></a>
                        <ul class="<?php if ($admin != 'active') {
                                        echo 'sub-menu';
                                    } ?>" id="admin-menu">
                            <?php wp_nav_menu(array(
                                'theme_location' => 'my-admin-menu',
                                'container_class' => 'custom-menu-class'
                            ));
                            ?>

                        </ul>
                    </li>
                <?php };
                if (is_user_logged_in()) { ?>

                    <li>
                        <a style="cursor:pointer;" href="<?php echo wp_logout_url("logout"); ?>">Logout</a>
                    </li>
                <?php } else { ?>
                    <li>
                        <a style="cursor:pointer;" href="<?php echo home_url() ?>">Login</a>
                    </li>
                <?php } ?>

            </ul>
        </div>
        <div class="clear"></div>

    </div><!-- .sidebar-inner -->

    </div><!-- .sidebar -->


    <ul style="border-bottom: black solid 2px" class="menu bg-black mobile-menu hidden9">
        <li>
            Info>
            <ul class="sub-menu mobileinfo">
                <?php wp_nav_menu(array(
                    'theme_location' => 'my-custom-menu',
                    'container_class' => 'custom-menu-class'
                ));
                ?>

            </ul>
        </li>

        <li>
            Aanbod>
            <ul class="sub-menu">
                <?php
                $url = get_site_url();
                $url .= "/opleidingen";
                $branches = $branch->getAlleBranches();

                foreach ($branches as $branch_) {
                    $url .= "?id=" . $branch_->getBranchID();

                ?>
                    <a href="<?= $url ?>">
                        <li><?= $branch_->getBranchName(); ?></li>
                    </a>
                <?php
                    $newurl = str_replace("?id=" . $branch_->getBranchID(), "", $url);
                    $url = $newurl;
                }
                ?>
            </ul>
        </li>

        <?php
        if (is_user_logged_in()) { ?>
            <li>
                <p style="cursor:pointer"><a href="<?php echo wp_logout_url("logout"); ?>">Logout</a></p>
            </li>
        <?php } else { ?>
            <li>
                <p style="cursor:pointer"><a href="<?php echo home_url() ?>">Login</a></p>
            </li>
        <?php } ?>

    </ul>

    <div class="wrapper" id="wrapper">

        <div class="section-inner wrapper-inner">
            <script>
                // $("ul.menu").find('> li').click(
                //     function(e) {

                //         $(this).find('> ul').slideToggle();


                //         //  $(this).find('> ul').toggle();
                //     }
                // );

                $("ul.sub-menu").find('> li').click(
                    function(e) {
                        e.stopPropagation()

                        $(this).find('> ul').slideToggle();

                        // $(this).find('> ul').toggle();
                    }

                );
            </script>
