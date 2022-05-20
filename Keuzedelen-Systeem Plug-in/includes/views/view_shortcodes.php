<?php
/*
  Description of view_shortcodes.php
  @author Arran Crowley
 */
add_shortcode('branches_main_view', 'load_branches_view');
add_shortcode('opleidingen_main_view', 'load_opleidingen_view');
add_shortcode('keuzedelen_main_view', 'load_keuzedelen_view');
add_shortcode('keuzedeel_main_view', 'load_keuzedeel_view');

function load_branches_view($atts, $content = NULL){
    include KEUZEDELEN_SYSTEEM_PLUGIN_INCLUDES_VIEWS_DIR.'/branches_main_view.php';
}
function load_opleidingen_view($atts, $content = NULL){
    include KEUZEDELEN_SYSTEEM_PLUGIN_INCLUDES_VIEWS_DIR.'/opleidingen_main_view.php';
}
function load_keuzedelen_view($atts, $content = NULL){
    include KEUZEDELEN_SYSTEEM_PLUGIN_INCLUDES_VIEWS_DIR.'/keuzedelen_main_view.php';
}
function load_keuzedeel_view($atts, $content = NULL){
    include KEUZEDELEN_SYSTEEM_PLUGIN_INCLUDES_VIEWS_DIR.'/keuzedeel_main_view.php';
}