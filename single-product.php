<?php get_header() ?>
<?php if( have_posts() ) {
	while (have_posts()) : the_post(); ?>

	<section class="description">
		
		<div class="description-top"></div>

		<div class="container-fluid">
				<div class="description-info">
							
					<div class="row">
						<?php

							// get_posts in same custom taxonomy
							$postlist_args = array(
							   'posts_per_page'  => -1,
							   'orderby'         => 'menu_order title',
							   'order'           => 'ASC',
							   'post_type'       => 'product'									   
							); 
							$postlist = get_posts( $postlist_args );

							// get ids of posts retrieved from get_posts
							$ids = array();
							foreach ($postlist as $thepost) {
							   $ids[] = $thepost->ID;
							}

							// get and echo previous and next post in the same taxonomy        
							$thisindex = array_search($post->ID, $ids);
							$previd = @$ids[$thisindex-1];
							$nextid = @$ids[$thisindex+1];
							if ( !empty($previd) ) {
							   echo '<a class="col-md-1 nav-prev text-uppercase" rel="prev" href="' . get_permalink($previd). '"><i class="icon-arrow-left"></i></a>';
							}else{
								echo '<div class="col-md-1">&nbsp;</div>';
							}								

						?>
						<div class="col-md-7">							
							<?php
							if( has_post_thumbnail( get_the_id() ) ){
								$large = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_id() ), 'original' ); 
								$attachment_title = get_the_title(get_post_thumbnail_id( get_the_id() ));								
								?>
									<a class="fancybox" rel="group" href="<?php echo @$large[0] ?>" title="<?php echo $attachment_title ?>">
										<?php if( has_post_thumbnail( get_the_id() ) ){
											echo the_post_thumbnail('full', array('class'=>'img-responsive') );
										} ?>
									</a>
							<?php }
							?>		
							
		                    <?php foreach( rwmb_meta( 'wsmoveisplanejados_product_gallery_images', 'type=file&size=large-wide' ) as $image ){ ?>
		                        
	                                <a rel="group" class="fancybox col-sm-4" href="<?php echo $image['url']; ?>" title="<?php echo $image['title']; ?>" style="">
	                                    <img src="<?php echo $image['url']; ?>" class="img-responsive" alt="<?php echo $image['alt']; ?>">
	                                </a>                                            
		                        
		                    <?php } ?>  					
						</div>
						<div class="col-md-3">
							<article class="product">
							<h2 class="product-title"><?php the_title() ?></h2>
							<?php 
								// $ref = ( rwmb_meta( 'wsmoveisplanejados_product_ref' ) ) ? "Ref:  ".rwmb_meta( 'wsmoveisplanejados_product_ref' ) : ''; 
								// $alt = ( rwmb_meta( 'wsmoveisplanejados_product_alt' ) ) ? " | ".rwmb_meta( 'wsmoveisplanejados_product_alt' ) : '';
								// $larg = ( rwmb_meta( 'wsmoveisplanejados_product_larg' ) ) ? "X".rwmb_meta( 'wsmoveisplanejados_product_larg' ) : '';
								// $prof = ( rwmb_meta( 'wsmoveisplanejados_product_prof' ) ) ? "X".rwmb_meta( 'wsmoveisplanejados_product_prof' ) : '';
								// echo $ref.$alt.$larg.$prof; 
							?>

								<?php
								$terms = get_the_terms( get_the_id(), 'category' );
					                         
								if ( $terms && ! is_wp_error( $terms ) ) : 
								 
								    $draught_links = array();
								 
								    foreach ( $terms as $term ) {
								        $draught_links[] = $term->name;
								    }
								                         
								    $on_draught = join( ", ", $draught_links );
								    ?>
								 
								    <p class="beers draught">
								        <?php printf( '<strong>%s</strong>', esc_html( $on_draught ) ); ?>
								    </p>
								<?php endif; ?>
							
							<div class="post-content product-content"><?php the_content() ?></div>

		                    </article>

						</div>
											
						
						<?php 
							if ( !empty($nextid) ) {
							   echo '<a class="col-md-1 nav-next text-uppercase" rel="next" href="' . get_permalink($nextid). '"><i class="icon-arrow-right"></i></a>';
							}
						 ?>
						</div>
			</div>
		</div>
	</section>
		
<?php endwhile;
}	
?>	
<?php get_footer(); ?>