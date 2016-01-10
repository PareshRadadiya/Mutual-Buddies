<?php
/**
 * The Template for displaying list of mutual fiends and friends that are registered on your site.
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
<div id="members-dir-list" class="members dir-list">
	<?php bp_get_template_part( 'members/members-loop' ); ?>
</div><!-- #members-dir-list -->

