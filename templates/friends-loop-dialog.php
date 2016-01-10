<?php
/**
 * The Template for displaying list of mutual fiends and friends that are registered on your site in dialog.
 *
 * This template can be overridden by copying it to yourtheme/mutual-buddies/friend-loop.php.
 *
 * HOWEVER, on occasion Mutual-Buddies will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://pareshradadiya.github.io/Mutual-Buddies/
 * @author 		Paresh
 * @package 	MutualFriends/Templates
 * @version     1.7
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php

if ( 'bmf_mutual_friends_dialog' === $_REQUEST['action']  ) {
	$dialog_heading = __( 'Mutual Friends', 'mutual-buddies' );
} else if ( 'bmf_friends_dialog' === $_REQUEST['action'] ) {
	$dialog_heading = __( 'Friends', 'mutual-buddies' );
}

?>
<header><?php echo $dialog_heading ?></header>
<button title="Close (Esc)" type="button" class="mfp-close">×</button>
<div class="popup-scroll">
	<?php
	echo bp_buffer_template_part( 'members/members-loop' );
	global $members_template;
	$total = ceil( (int) $members_template->total_member_count / 20 );
	if ( $total > 1 ) {
		?>
		<ul class="activity-list item-list">
			<li class="load-more" data-next-page-no="2" data-total-page-count="<?php echo $total ?>">
				<a class="bmf-load-more" href="#"><?php _e( 'Load More', 'mutual-buddies' ) ?></a>
			</li>
		</ul>
	<?php } ?>
</div>
