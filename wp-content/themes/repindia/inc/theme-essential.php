<?php
/**
 * Changing the Title Of comment form
 */
 function repindia_form_before() {
    ob_start();
}
add_action( 'comment_form_before', 'repindia_form_before' );
 /**
 * Changing the view for user viewing comment form
 */ 
function repindia_comments_defaults( $defaults ) {
 global $post;
    $defaults = array(
		'fields' => apply_filters('comment_form_default_fields', array(
		'author' => '<div class="col-md-6 col-xs-12">
	                       <div class="form-group">
					              <input type="text" class="form-control" id="author" name="author" required/>
						    </div>
					 </div>',
		'email' => '<div class="col-md-6 col-xs-12">
						<div class="form-group">
							<input type="text" class="form-control" name="email" required/>
						</div>
					</div>',
		)
	    ),
		'comment_field' => '<div class="col-lg-12 form-field">
									<textarea class="form-control sing_space" id="comment" name="comment" placeholder="'.esc_html__('Write Comment','repindia').'" required></textarea>
							</div>' ,
		'comment_notes_after' => '',											
		);
    return $defaults;
}
add_filter( 'comment_form_defaults', 'repindia_comments_defaults' );
// Comment Section
function repindia_wp_move_comment_field_to_bottom( $fields )
{
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'repindia_wp_move_comment_field_to_bottom' );
// To Add Place holders
add_filter( 'comment_form_default_fields', 'repindia_wp_comment_placeholders' );
function repindia_wp_comment_placeholders( $fields )
{
    $fields['author'] = str_replace('<input','<input placeholder="'.esc_html__('Name','repindia'). '"', $fields['author'] );	
	$fields['email'] = str_replace('<input','<input placeholder="'. esc_html__('Email','repindia'). '"',$fields['email']);
    return $fields;
}
add_filter( 'comment_form_defaults', 'repindia_wp_textarea_insert' );
function repindia_wp_textarea_insert( $fields )
{
	$fields['comment_field'] = str_replace('<textarea','<textarea',$fields['comment_field']);	
    return $fields;
}

if ( ! function_exists( 'repindia_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own repindia_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @return void
 */
function repindia_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
        // Display trackbacks differently than normal comments.
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <?php esc_html__( 'Pingback:','repindia' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)','repindia' ), '<span class="edit-link">', '</span>' ); ?>
    <?php
         break;
        default :
        global $post;
    ?>
    <li
    <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">			
		<div class="row">
			<div class="col-md-12 col-sm-12">
				<div class="commantblock">
                     <div class="comment_img">
						<?php 
							echo get_avatar( $comment, 60 ); 
						?>
                     </div>
                     <div class="comment_text">
                        <h6>
						<?php 
						 printf( 
									get_comment_author_link(),
									( $comment->user_id === $post->post_author ) ? : ''
								);
							if ( '0' == $comment->comment_approved ) : 
						?>
								<div class="simple-text">
									<?php esc_html__( 'Your comment is awaiting moderation.','repindia' ); ?>
								</div>
						<?php 
							endif; 
						?>
						</h6>
							<?php 
								printf( ' <time datetime="%2$s">
												%3$s	
											</time> ',
										esc_url( get_comment_link( $comment->comment_ID ) ),
										get_comment_time( 'c' ),
										sprintf( __( '%1$s','repindia' ), get_comment_date("M d, Y H:i A") ));
								edit_comment_link( __( 'Edit','repindia' ), '<span class="edit-link">', '</span>' );
								    comment_text();
								comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply','repindia' ), 'after' => '', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); 
						?>
                    </div>
                </div>
            </div> 	  	
		</div>	  
    <?php
        break;
    endswitch; // end comment_type check
}
endif;
if ( ! function_exists( 'repindia_get_header' ) ) 
{
	function repindia_get_header() 
	{
		$header = '';
		return get_header( $header );
	}
}
if ( ! function_exists( 'repindia_get_socials' ) ) 
{
	function repindia_get_socials( $type = 'header_socials' ) 
	{
		global $repindia_option;
		$socials_array  = array();
		$socials_enable = $repindia_option['enable_social'];
		if($socials_enable)
		{
			if(isset($repindia_option['facebook-value']) && $repindia_option['facebook-value'] != '')
			{
				$socials_array['facebook'] = $repindia_option['facebook-value'];
			}
			if(isset($repindia_option['twitter-value']) && $repindia_option['twitter-value'] != '')
			{
				$socials_array['twitter'] = $repindia_option['twitter-value'];				
			}	
			if(isset($repindia_option['linkedin-value']) && $repindia_option['linkedin-value'] != '')
			{
				$socials_array['linkedin'] = $repindia_option['linkedin-value'];
			}				
			if(isset($repindia_option['pinterest-value']) && $repindia_option['pinterest-value'] != '')
			{
				$socials_array['pinterest'] = $repindia_option['pinterest-value'];
			}
			if(isset($repindia_option['instagram-value']) && $repindia_option['instagram-value'] != '')
			{
				$socials_array['instagram'] = $repindia_option['instagram-value'];
			}								
			if(isset($repindia_option['yelp-value']) && $repindia_option['yelp-value'] != '')
			{
				$socials_array['yelp'] = $repindia_option['yelp-value'];
			}				
			if(isset($repindia_option['foursquare-value']) && $repindia_option['foursquare-value'] != '')
			{
				$socials_array['foursquare'] = $repindia_option['foursquare-value'];
			}									
			if(isset($repindia_option['flickr-value']) && $repindia_option['flickr-value'] != '')
			{
				$socials_array['flickr'] = $repindia_option['flickr-value'];
			}	
			if(isset($repindia_option['youtube-value']) && $repindia_option['youtube-value'] != '')
			{
				$socials_array['youtube'] = $repindia_option['youtube-value'];
			}				
			if(isset($repindia_option['email-value']) && $repindia_option['email-value'] != '')
			{
				$socials_array['envelope'] = $repindia_option['email-value'];
			}			
			if(isset($repindia_option['rss-value']) && $repindia_option['rss-value'] != '')
			{
				$socials_array['rss'] = $repindia_option['rss-value'];
			}	
				return $socials_array;
		}
	}
}
// if ( ! function_exists( 'repindia_breadcrumbs' ) )
// {
// 	function repindia_breadcrumbs()
// 	{
// 		if(function_exists('bcn_display')) 
// 			bcn_display(); 
// 	}
// }

?>