<?php
if ( post_password_required() ) 
{
	return;
}
?>
<div id="comments" class="commentsWrapper">
	<?php if ( have_comments() ): ?>
		<h3>
			<?php comments_number(); ?>
		</h3>
			<ol class="commentlist">
			<?php
				wp_list_comments( array(
					'style'       => 'ul',
					'short_ping'  => true,
					'avatar_size' => 87,
				) );
			?> 
			</ol>
		<div class="emptySpace-xs40"></div>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ): ?>
			<nav class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html__( 'Comment navigation','repindia' ); ?></h2>
				<div class="nav-links">
					<?php
					if ( $prev_link = get_previous_comments_link( esc_html__( 'Older Comments','repindia' ) ) ) {
						printf( '<div class="nav-previous">%s</div>', $prev_link );
					}
					if ( $next_link = get_next_comments_link( esc_html__( 'Newer Comments','repindia' ) ) ) {
						printf( '<div class="nav-next">%s</div>', $next_link );
					}
					?>
				</div>
			</nav>
		<?php endif; 
			endif; 
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ): ?>
		<p class="no-comments"><?php esc_html__( 'Comments are closed.','repindia' ); ?></p>
	<?php endif; 
	comment_form( array(
		'comment_notes_before' => '',
		'comment_notes_after' => ''
	) ); ?>
	</div>