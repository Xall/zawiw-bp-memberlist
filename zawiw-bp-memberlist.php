<?php
/*
Plugin Name: ZAWiW BuddyPress Memberlist
Plugin URI:
Description: Liste aus Teilnehmern an einer BuddyPress Community, beschränkt auf die aktive Seite
Version: 1.0
Author: Simon Volpert, Sascha Winkelhofer
Author URI: http://svolpert.eu
License: MIT
*/

// Defines the zawiw-bp-memberlist shortcode
add_shortcode( 'zawiw-bp-memberlist', 'zawiw_bp_memberlist_shortcode' );

add_action( 'wp_enqueue_scripts', 'zawiw_bp_memberlist_stylesheet' );
add_action( 'wp_enqueue_scripts', 'zawiw_bp_memberlist_script' );

// Lists users in a grid with base64 encoded emails
function zawiw_bp_memberlist_shortcode( $atts ) {

    // start buffered output
    ob_start();

    // check for login
    if ( !is_user_logged_in() ) {
        echo '<p>Sie müssen angemeldet sein, um diese Funktion zu nutzen.</p>';
        // end buffered output
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    ?>
    <div id="zawiw-bp-memberlist">
    <?php
    if ( bp_has_members( 'include=' . zawiw_bp_memberlist_get_users() ) ):?>
        <?php while ( bp_members() ) : bp_the_member(); ?>

        <div class="user one-third">
            <a href="<?php bp_member_permalink() ?>">
                <div class="avatar"><?php bp_member_avatar(); ?></div>
                <div class="name"><?php bp_member_name(); ?></div>
            </a>
                <div class="email"><a href=""><?php echo base64_encode(bp_get_member_user_email()); ?></a></div>
        </div>


        <?php endwhile; ?>
    <?php endif;
    ?>
    </div>
    <?php

    // end buffered output
    $output = ob_get_contents();
    ob_end_clean();

    return $output;

}

function zawiw_bp_memberlist_get_users(){
    // Stores a list of comma seperated user id
    // Used later to filter
    $usersString = "";
    $users = get_users();
    foreach($users as $user){
        $usersString .= $user->ID.",";
    }
    // Trims trailing comma
    $usersString = rtrim($usersString, ",");

    return $usersString;

}

function zawiw_bp_memberlist_stylesheet() {
    wp_enqueue_style( 'zawiw_bp_memberlist_style', plugins_url( 'style.css', __FILE__ ) );
    wp_enqueue_style( 'font_awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css' );
}

function zawiw_bp_memberlist_script()
{
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'zawiw_bp_memberlist_script', plugins_url( 'helper.js', __FILE__ ) );
}


?>
