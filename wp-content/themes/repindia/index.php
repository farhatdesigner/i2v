<?php 
repindia_get_header();
global $repindia_option, $sidebar_position;
?>
	<div class="row blog">
	     
		<div class="">
			<?php
				$posts_class = '';
				$paginate_links_data = paginate_links( array('type' => 'array') );
				if(empty( $paginate_links_data )) 
				{
					$posts_class .= ' no-paginate';
				}
			?>
			<div id="post-<?php the_ID(); ?>" <?php post_class();?>>
				<?php
				if ( have_posts() )
				{
					while ( have_posts() ) : the_post();	
					$categories = get_the_terms( $id, 'category' );
					$projecttitle = get_post_meta(get_the_ID(), 'meta_box_post_flag', true );
					?>
					<div class="blog-list__single">
						<?php 
						if( has_post_thumbnail( ) ) 
						{ ?>
							<div class="blog-list__image">
								<a href="<?php echo esc_url( get_permalink() ); ?>" class="imgWrapper">
									<?php the_post_thumbnail(); ?>
								</a>
								<?php
                                	if($projecttitle!='')
									{ ?>
                                			<div class="news2_adbox">
			                            	    <p><?php echo esc_attr($projecttitle);?></p>
			                            	</div>	
				                    	<?php
				                    } ?>
							</div>
						<?php 
					    } ?>
					    <div class="blog-list__content">
							<div class="blog-img-hov">
						    	<?php
						    	if($repindia_option)
						    	{
							    	if((isset($repindia_option['blog_metadata']) && $repindia_option['blog_metadata'] == '1'))
									{ ?>
									    <ul class="blog-list__meta list-unstyled">	  
										    <?php 
			                                if(isset($repindia_option['blog_multi_checkbox_post']) && ($repindia_option['blog_multi_checkbox_post'][2] == '1') )
			                                {
											?>
											    <li><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>"><?php echo esc_html__( 'By', 'repindia' ); ?> <?php echo esc_html( get_the_author() );?></a></li>
			                                <?php 
			                                }
			                                if(isset($repindia_option['blog_multi_checkbox_post']) && ($repindia_option['blog_multi_checkbox_post'][2] == '1') && (isset($repindia_option['blog_multi_checkbox_post']) && $repindia_option['blog_multi_checkbox_post'][1] == '1')){ ?>
			                                	 <li class="admin_slash">|</li> 
			                                <?php 
			                                }
											if((isset($repindia_option['blog_multi_checkbox_post']) && $repindia_option['blog_multi_checkbox_post'][1] == '1'))
			                                { ?>
											    <li><?php echo get_the_date(); ?></li>  
											<?php
											} 
											?>	
									    </ul>
								    <?php 
								    }
								}
							    else
							    { ?> 
							    	<ul class="blog-list__meta list-unstyled">	
							    	    <li><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>"><?php echo esc_html__( 'By', 'repindia' ); ?> <?php echo esc_html( get_the_author() );?></a></li> <li class="admin_slash">|</li>  
									    <li><?php echo get_the_date(); ?></li> 
								    </ul>
							    <?php 
							    }
							    if ( is_sticky( ) ) 
								{
									echo '<span class="genericon genericon-pinned"></span> ';
								}
							     ?>
								<h3><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html(the_title()); ?></a></h3>
							</div>
						    <?php 
				            if ( 'post' == get_post_type() ) 
				            {
						        the_excerpt(); 
						        ?>
						        <div class="blog_button">
			                        <a href="<?php echo esc_url( get_permalink() ); ?>" class="blog-list__btn"><?php echo esc_html__('Read More','repindia'); ?></a>
						        </div>
						    <?php 
						    }
						    
						    if((isset($repindia_option['blog_pagination']) && $repindia_option['blog_pagination'] == '1'))
						    {
						    ?>
						    <div class="paginationWrapper">
								<div class="nubmerPagination">
									<?php
									wp_link_pages( array(
										'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'repindia' ),
										'after'  => '</div>',
									) ); 
									?>
								</div>
							</div>
						    <?php 
					        } ?>
					    </div>
					</div>									
					<?php
					endwhile;
					if(function_exists('repindia_data_option') && class_exists('Redux'))
					{
						if((isset($repindia_option['blog_pagination']) && $repindia_option['blog_pagination'] == '1'))
					    {
						?>
						<div class="paginationWrapper outerpaging">
							<div class="nubmerPagination">
								<?php
								if(isset($repindia_option['blog_pagination']) && $repindia_option['blog_pagination'] == '1')
								{
									if (class_exists( 'Redux' )) 
									{
										echo paginate_links( array(
											'type'      => 'a',
											'prev_text' => '<i class="fa fa-angle-left"></i>',
											'next_text' => '<i class="fa fa-angle-right"></i>',
										) ); 
									}
								} 
								else 
								{
									 echo paginate_links( array(
										'type'      => 'a',
										'prev_text' => '<i class="fa fa-angle-left"></i>',
										'next_text' => '<i class="fa fa-angle-right"></i>',
									) );
								}
								
							    ?>
						    </div>
					    </div>	
					<?php
				        }
			        }
			        else
			        { ?>
			        	<div class="paginationWrapper outerpaging">
							<div class="nubmerPagination">
					        	<?php
					        	echo paginate_links( array(
										'type'      => 'a',
										'prev_text' => '<i class="fa fa-angle-left"></i>',
										'next_text' => '<i class="fa fa-angle-right"></i>',
									) ); ?>
							</div>
					    </div>	
			        <?php
			        }
				}
				elseif ( is_search() )
				{ ?>
					<p><?php esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'repindia' ); ?></p>
			    <?php 
		        }
		        else
		        { ?>
					<p><?php esc_html__( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'repindia' ); ?></p> 
			    <?php	
		        } ?>
		    </div>
	    </div>
	
<?php get_footer(); ?>