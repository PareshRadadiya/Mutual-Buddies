<div id="bmf-members-dir-list" class="members dir-list">

	<?php bp_get_template_part( 'members/members-loop' ); ?>
	<?php global $members_template;
	$total = ceil( (int) $members_template->total_member_count / 20 );
	?>

	<ul class="activity-list item-list">
		<li class="load-more" data-next-page-no="2" data-total-page-count="<?php echo $total ?>">
			<a class="bmf-load-more" href="#">Load More</a>
		</li>
	</ul>

</div><!-- #members-dir-list -->

