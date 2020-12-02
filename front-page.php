<?php get_header();
 $defaultimage = get_option( 'theme_options' )['default_post_image'];
?>

<section class="box-padding-inner">
	<div class="innerpage-banner">
		<h1> <?php the_title(); ?></h1>	
<p> 
<?php
if ( have_posts() ) :
		while	( have_posts() ) :
			the_post();
		?>
		<?php
			remove_filter( 'the_content', 'wpautop' );
			the_content();
		?>

		<?php
endwhile;
				endif;
?>
			</p>
	</div>
</section>
<section class="box-padding-normal">
<div class="blog-slider-trigger"><span>All</span><i class="fs-icon-arrow-right"></i></div>
	<div class="blog-slider" id="cat">
			<?php

			$args = array(
				'orderby'            => 'name',
				'order'              => 'ASC',
				'style'              => 'none',
				'separator'          => '',
				'hide_empty'         => 1,
				'use_desc_for_title' => 1,
				'child_of'           => 0,
				'hierarchical'       => 0,
				'title_li'           => __( '' ),
				'show_option_none'   => __( '' ),
				'taxonomy'           => 'category',
			);
			?>
		<h6>Blog Categories</h6>
		<div class="close">X</div>
		<div class="blog-slider-item"> <a href="/#cat">All </a>
			<?php wp_list_categories( $args ); ?> 
		</div>
	</div>
</section>

				<?php

				if ( get_query_var( 'paged' ) ) {
					$paged = get_query_var( 'paged' ); } elseif ( get_query_var( 'page' ) ) {
					$paged = get_query_var( 'page' ); } else {
						$paged = 1; }
					$args = array(
						'post_type'      => 'post',
						'orderby'        => 'ID',
						'post_status'    => 'publish',
						'order'          => 'DESC',
						'posts_per_page' => 10, // this will retrive all the post that is published
						'paged'          => $paged,
					);

					query_posts( $args );
					$posts = get_posts( $args );
					if ( have_posts() ) {
						$i = 0;
						while ( have_posts() ) :
							the_post();

							setup_postdata( $post );
							if ( $i == 0 ) {

								?>
							<section class="bg-grey">
								<div class="blog-highlight">
										<div class="blog-highlight-left">
												<h3><?php the_title(); ?></h3>
												<div class="blogger-name">
													<div class="blogger-image">
													<?php $author_id = $post->post_author; ?>
													<?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
													</div>
													<span>By <?php echo get_the_author(); ?> on <?php echo get_the_date(); ?></span>
												</div>
											<?php the_excerpt(); ?>
													<a class="blog-read-more" href="<?php the_permalink(); ?>">Read more</a>
										</div>
											<div class="blog-highlight-right">
											<?php
											if ( has_post_thumbnail() ) {
												the_post_thumbnail( 'thumbnail' );
											} else {
												?>
													<img src="<?php echo $defaultimage; ?>" alt="" />
												<?php } ?>
											</div>
								</div>
							</section>
									<?php
							} else {
								if ( $i == 1 ) {
									?>
			<section class="box-padding-innermost">
				<div class="blog-list-wrap">
									<?php
								}
								?>
						<div class="blog-list-item">
							<div class="blog-image">
								<?php
								if ( has_post_thumbnail() ) {
									the_post_thumbnail( 'thumbnail' );
								} else {
									?>
									<img src="<?php echo $defaultimage; ?>" alt="" />
									<?php } ?>
						  
							</div>
							<div class="blog-text">
								<h3><?php the_title(); ?></h3>
								<div class="blogger-name">
									<div class="blogger-image">
											<?php $author_id = $post->post_author; ?>
											<?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
									</div>
										<p>By <?php echo get_the_author(); ?> on <?php echo get_the_date(); ?></p>
								</div>
									<p><?php the_excerpt(); ?></p>
									<a href="<?php the_permalink(); ?>"><i class="fs-icon-arrow-right"></i> </a>
							</div>
						</div>
								<?php

							}
							$i++;


					endwhile;
						?>
					  
				</div> 
						<?php



						if ( function_exists( 'wp_pagenavi' ) ) {
							?>
				<div class="pagination-wrap">
							<?php echo wp_pagenavi(); ?>
				</div>
							<?php
						}


						?>
			</section>
	<?php } ?>
<?php get_footer(); ?>
