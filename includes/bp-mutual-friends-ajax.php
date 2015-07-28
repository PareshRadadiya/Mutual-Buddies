<?php

function bp_mutual_friends_dialog() {

	echo bp_buffer_template_part( 'members/members-loop' );
	exit;
}

add_action( 'wp_ajax_mutual_friends_dialog', 'bp_mutual_friends_dialog' );