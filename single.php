<?php 
/**
 * The Template for displaying all single posts
 */
?>
<?php get_header();
 $defaultimage = get_option('theme_options')['default_post_image'];
?>
            <section class="box-padding-normal bg-grey">
                <div class="blogger box-padding-normal">
                
                    <div class="blogger-name">
                        <div class="blogger-image">
                            <?php $author_id=$post->post_author; ?>  
                            <?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>               
                         </div>
                        <div class="blogger-title">
                             <h1><?php the_title();?></h1>
                                
                        </div>
                            <div class="blogger-sub-title">
                            <span>By <?php  echo the_author_meta( 'display_name', $recent["post_author"] ); ?> on <?php echo get_the_date( 'F, j Y', $recent["ID"] ) ;?></span>
                             </div>
                    </div>
                </div>
                <div class="blog-detail-image">
                                    <?php
                                            $feat_image = wp_get_attachment_url( get_post_thumbnail_id($recent["ID"]) );

                                        if ($feat_image ) {?>
                                            <img src="<?php echo $feat_image;?>" alt=""> 
                                        <?php    }else{?>
                                            <img src="<?php echo $defaultimage; ?>" alt="" />
                                        <?php    }
                                            ?> 
                </div>
                <div class="blog-detail-description">
                    <div class="row">
                    <?php $post_id = get_the_ID(); 
                             $seo_title= get_post_meta( $post_id, '_role_meta_value', true );
                             if(!empty($seo_title)){                            
                             ?>                            
                        <div class="col-4">
                            <div class="brdr-top-title"> <span></span>
                                 <h4><?php 
                                            echo  $seo_title;
                                        ?>
                                 </h4>
                            </div>
                        </div>
                             <?php } ?>
                        <?php $post_id = get_the_ID(); 
                             $seo_desc= get_post_meta( $post_id, '_description_meta_value', true );
                             if(!empty($seo_desc)){
                                 ?>
                        <div class="col-6">
                             <h5><?php echo  $seo_desc;?></h5>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
            <section class="box-padding-normal">
                <div class="blog-detail-content">
                    <div class="row">
                        <div class="col-4">
                            <div class="blog-list-wrap">
                                
                                <!-- <ul>  -->
                                <?php
                                        $post_id = get_the_ID();
                                            $args 	= array( 'numberposts' => '4' , 'post_status' => 'publish');
                                            $recent_posts = wp_get_recent_posts( $args );
                                            foreach( $recent_posts as $recent ){
                                                ?>
                                <div class="blog-list-item">
                                    <div class="blog-image">
                                        <?php
                                            $feat_image = wp_get_attachment_url( get_post_thumbnail_id($recent["ID"]) );

                                        if ($feat_image ) {?>
                                            <img src="<?php echo $feat_image;?>" alt=""> 
                                        <?php    }else{?>
                                            <img src="<?php echo $defaultimage; ?>" alt="" />
                                        <?php    }
                                            ?>                  
                                    
                                    </div>
                                    <div class="blog-text">
                                        <h6>
										<?php	echo '<a href="' . get_permalink($recent["ID"]) . '">' .   $recent["post_title"].'</a> ';?></h6>
                                       
                                        <div class="blogger-name">
                                            <div class="blogger-image">
                                                <img src="<?php echo esc_url( get_avatar_url( $recent["post_author"] ) ); ?>" alt=""/>
                                               
                                            </div>
                                            <p>By <?php  echo the_author_meta( 'display_name', $recent["post_author"] ); ?> </p>

                                        </div>
                                    </div>
                                       
                                       <!-- </ul>  -->               
                                   
                                </div>
                                <?php   } ?>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-wrap">
                            <?php
// Start the Loop.
							while ( have_posts() ) : the_post();?>
                               	
                                <p><?php remove_filter ('the_content', 'wpautop'); the_content();?></p>
                            </div>
                            <?php    
                            endwhile;
									?>
                            
                          
                        </div>
                    </div>
                </div>
            </section>
         
<?php get_footer();?>