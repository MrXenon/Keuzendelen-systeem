<?php

//get_header();
?>

    <div class="content">

        <?php wp_logout_form( array('redirect' => home_url()) ); ?>

    </div><!-- .content -->

<?php get_footer(); ?>