<?php
/***
 * You can hook in ajax functions in WordPress/BuddyPress by using the 'wp_ajax' action.
 *
 * When you post your ajax call from javascript using jQuery, you can define the action
 * which will determin which function to run in your PHP component code.
 */

/**
 * HTML markup for mutual friend dialog box
 */
function bmf_mutual_friends_dialog() { ?>

	<header><?php _e( 'Mutual Friends', 'bmf' ) ?></header>
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
					<a class="bmf-load-more" href="#"><?php _e( 'Load More', 'bmf' ) ?></a>
				</li>
			</ul>
		<?php } ?>
	</div>
	<?php
	exit;
}

add_action( 'wp_ajax_bmf_mutual_friends_dialog', 'bmf_mutual_friends_dialog' );

/**
 * HTML markup for friend dialog box
 */
function bmf_friends_dialog() { ?>

	<header><?php _e( 'Friends', 'bmf' ) ?></header>
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
					<a class="bmf-load-more" href="#"><?php _e( 'Load More', 'bmf' ) ?></a>
				</li>
			</ul>
		<?php } ?>
	</div>
	<?php
	exit;
}

add_action( 'wp_ajax_bmf_friends_dialog', 'bmf_friends_dialog' );