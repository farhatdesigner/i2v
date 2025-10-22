<?php
		global $repindia_option; 
		$backStyle = '';
		$backStyle = repindia_backgroundstyle('footer_bg');
		$backStyle = implode('', $backStyle);
		?>
		<div class="footer">
		    <div class="container">
		        <div class="row">
				    <!-- <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 footer_menu_logo_box">
						<?php
						if(isset($repindia_option['footer_logo']['url'] ) && !empty($repindia_option['footer_logo']['url']))
						{   ?>  
							<a class="footer_logo_anc" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img class="footer_logo_img" src="<?php echo esc_url( $repindia_option['footer_logo']['url'] ); ?>" title="Logo of Phoenix repindia - Ultra luxury apartments in Bangalore" alt="<?php bloginfo( 'name' ); ?>"></a>
						<?php 
						}else{ ?>
							<a class="footer_logo_anc" href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo_name"><?php bloginfo( 'name' ); ?></a>
						<?php 
						}   ?>
						
					</div> -->
					
					
		            
		        </div>
				<?php
				if( isset($repindia_option['footer_copyright_switch']) && $repindia_option['footer_copyright_switch'] == 1){ 
				?>
				<div class="footer_copyright">
					<div class="row">
						<div class="col-md-4 col-xs-12">
							<p>ABC</p>
						</div>
						<div class="col-md-4 col-xs-12">
						<?php
                            if (has_nav_menu('footer-product-menu')) {
                                wp_nav_menu(
                                    array(
                                        'menu_id' => '',
                                        'theme_location' => 'footer-product-menu',
                                        'container'      => false,
                                        'depth'          => 2,
                                        'link_after'          => '<span class="caret"><i class="fa fa-arrow-down"></i></span>',
                                        'menu_class'     => ''
                                    )
                                );
                            }
                            ?>


						</div>
						<div class="col-md-4 col-xs-12">
							<?php
							if( !empty( $repindia_option['enable_social'] ) && isset($repindia_option['footer_social']) && $repindia_option['footer_social'] == 1)
							{ 
								$footer_socials = repindia_get_socials( 'enable_social' ); 
								if ( $footer_socials)
								{ ?>
								<div class="footer_social_section">
								    <p class="footer_text"><?php echo esc_attr($repindia_option['footer_social_title']); ?></p>
									<ul class="social-icons">
										<?php   
										foreach( $footer_socials as $class => $val )
										{ ?>
											<li>
												<a href="<?php echo esc_url( $val ); ?>" target="_blank" class="social-<?php echo esc_attr( $class ); ?>">
													<i class="fa fa-<?php echo esc_attr( $class ); ?> icon" ></i>
												</a>
											</li>
										<?php   
										}   ?>
									</ul>
								</div>
								<?php   
								}
							} ?>
						</div>
					</div>
				</div>
			<?php } ?>
		        <!-- </div> -->

		    </div>
		</div> 
		</div>
		</div>
		<!-- </div> -->
		
		


	
		<?php	
		wp_footer();
		?>
    </body>
</html>


