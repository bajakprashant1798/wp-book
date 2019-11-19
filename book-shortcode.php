<?php
/*
    ===============================
    create shortcode
    ===============================
*/    
add_shortcode('book', 'wpbook1_shortcode');
function wpbook1_shortcode($attributes){
    print_r($attributes);
    return "this is dlfaldflasdd";   
}
