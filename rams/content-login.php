<?php
/* ---------------------- This is the content of login, here u can add extra content  ---------------------- */

//get_header();
/*
* Template Name: Login Template
*/
if (!isset($_GET['login']) && $_GET['login'] == 'failed') {
    $url = site_url('');
    $_SESSION['got'] = $_GET;
    header("Location: $url");
}

if (is_user_logged_in()) {
    ob_start(); // ensures anything dumped out will be caught

    // do stuff here
    global $wpdb;
    $result = $wpdb->get_results("SELECT * FROM wp_users WHERE ID = ".get_current_user_id()."");
    foreach ($result as $print) {
        if($print->student_number == 0){
            $url = site_url('/wat-zijn-keuzedelen/');
        } else{
            $url = site_url('/mentor_check/');
        }
    }
     // this can be set based on whatever

    // clear out the output buffer
    while (ob_get_status()) {
        ob_end_clean();
    }

    // no redirect
    header("Location: $url");
}


?>
<link href="https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="style.css">
<section class="hero" style="
    background-image: url('http://test.stichtingivs.nl/wp-content/uploads/2019/12/Background-Ontwerp_Bryan_Initial_S5.1-scaled.jpg');
    background-size: cover;
    height: 100vh;
    position: relative;
    text-align: center;
    height: 100%;
    width: 100%;
    top: 0;">

    <div class="hero__wrap">
        <div class="content">
            <div style="position: relative; min-width: 30rem; " class="login-wrapper">
                <div class="header-img2">
                    <img style="margin-top: -14%; min-width: 33rem; width: 30%;" src="http://mit-keuzedelen.nl/wp-content/uploads/2019/06/Scalda-druppel.png" />
                </div>
                <div style='background-image: url("http://test.stichtingivs.nl/wp-content/uploads/2019/06/Stenen.png"); background-position: left; align-items: left; text-align: left; width: 18%; min-width: 20rem; min-height: 30rem; padding: 2%; margin-top: -22%; padding-top: 20%; -moz-appearance: -moz-window-titlebar; -webkit-appearance: continuous-capacity-level-indicator;  Height: auto; margin-left: auto; margin-right: auto; font-family: "Bebas Neue", cursive; align-items: flex-start; align-content: revert;' class="login-form ">
                    <?php
                    $args = array(
                        'echo' => true,
                        'redirect' => get_permalink(get_page($page_id_of_member_area)),
                        'form_id' => 'loginform',
                        'label_password' => __('Password'),
                        'label_remember' => __('Remember Me'),
                        'label_log_in' => __('Log In'),
                        'id_username' => 'user_login',
                        'id_password' => 'user_pass',
                        'id_remember' => 'rememberme',
                        'id_submit' => 'wp-submit',
                        'remember' => true,
                        'value_username' => NULL,
                        'value_remember' => false
                    );
                    $check_current_user_for_student = wp_get_current_user();
                    // if (in_array('Subscriber', (array) $check_current_user_for_student->roles)) {
                    //     $args = array('redirect' => site_url('/mentor_check/'));
                    // } else {
                    //     $args = array('redirect' => site_url('/wat-zijn-keuzedelen/'));
                    // }

                    $error = '';
                    if (isset($_GET['login']) && $_GET['login'] == 'failed') {
                        $error = "Inloggen mislukt, Verkeerde gebruikersnaam of wachtwoord";
                        echo $error;
                    }
                    if ($error == '' && isset($_GET['login'])) {
                        $url = site_url('');
                        $_SESSION['got'] = $_GET;
                        header("Location: $url");
                    }
                    wp_login_form($args); ?>
                    <div class="bottom-links">
                        <div class="reset-link"> <a style="color: black;" href="<?php echo wp_lostpassword_url(); ?> ">Wachtwoord vergeten</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .content -->
</section>
<?php get_footer(); ?>