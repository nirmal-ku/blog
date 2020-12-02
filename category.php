<?php get_header();
 $defaultimage = get_option( 'theme_options' )['default_post_image'];
?>

<section class="box-padding-inner">
<div class="innerpage-banner">

</div>
</section>
<section class="box-padding-normal">
<div class="blog-slider-trigger"><span>All</span><i class="fs-icon-arrow-right" href="/"></i></div>
	<div class="blog-slider">	
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
			<?php
			$categories    = get_categories(
				array(
					'orderby' => 'name',
					'order'   => 'ASC',
				)
			);
			$class         = '';
			$catID         = the_category_ID( $echo = false );
			$category_link = '';
			foreach ( $categories as $subCategoryId ) {
				if ( $subCategoryId->cat_ID == $catID ) {
					$class = ' class="slick-slide active"';
				} else {
					$class = ' class="slick-slide"';
				}
				echo '<a  href="' . get_category_link( $subCategoryId->cat_ID ) . '" ' . $class . ' data-slick-index="1" aria-hidden="true">' . $subCategoryId->name . '</a>';
			}

			wp_list_categories( $args );
			?>														   
		</div>  
	</div>
</section>
<section class="box-padding-innermost">
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
				<div class="blog-list-wrap">
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
								<a href="<?php the_permalink(); ?>">

						<i class="fs-icon-arrow-right"></i>

					</a>
						</div>
					</div>
				</div>
					<?php
				endwhile;
			else :
				get_template_part( 'posts', 'none' );
				?>
								
				<?php
	endif;
			if ( function_exists( 'wp_pagenavi' ) ) {
				?>
				<div class="pagination-wrap">			   
				<?php echo wp_pagenavi(); ?> 
				</div>
				<?php
			}
			?>
			</section>
<?php get_footer(); ?>
