<?php 
$logo = get_option('theme_options')['footer_logo'];
$copyrights = get_option('theme_options')['copyright'];
$facebooks = get_option('theme_options')['facebook'];
$instagram = get_option('theme_options')['instagram'];
$twitter = get_option('theme_options')['twitter'];
$linkedin = get_option('theme_options')['linkedin'];
?>

            <footer class="footer box-padding-normal">
                <div class="row">
                    <div class="col-md-4"> 
                        <a href="./" class="footer-logo"><img src="<?php echo $logo;?>" alt=""></a>
                    </div>
                    <div class="col-md-8">
                         <h2>We'd love to hear from you.</h2>
                         <h2 class="bordered-title"><span>Contact us</span></h2>
                        <div class="row">
                            <div class="col-9">
                                <div class="ftr-ofc-lctn-wrap">
                                    <div class="row">
                                        <?php $args = array( 'post_type' => 'Address', 'posts_per_page' => 4,'orderby' => 'ID','order' => 'ASC' );
                                        $loop = new WP_Query( $args );
                                        while ( $loop->have_posts() ) : $loop->the_post();?>
                                        <div class="col-md-6">
                                            <div class="ftr-ofc-lctn">
                                                <p>
                                                 <span class="title"><?php echo get_post_meta( get_the_ID(), 'location', true );?></span>
                                                    <br><?php echo get_post_meta( get_the_ID(), 'email', true );?>
                                                    <br><?php echo get_post_meta( get_the_ID(), 'phone', true );?>
                                                    <br>
                                                </p>                                            
                                            </div>
                                        </div>
                                        <?php endwhile;
                                        ?>
                                    </div>
                                </div>
                                <p class="copy-right"><?php echo $copyrights;?></p>
                            </div>
                        </div>
                        <div class="social-media vertical">
                            <a href="<?php echo $facebooks; ?>"><span class="fs-icon-facebook"></span></a>
                            <a href="<?php echo $twitter;?>"><span class="fs-icon-twitter"></span></a>
                            <a href="<?php echo $instagram;?>"><span class="fs-icon-instagram"></span></a>
                            <a href="<?php echo $linkedin;?>"><span class="fs-icon-linkedin"></span></a>
                        </div>
                    </div>
                </div>
            </footer>  
            <div class="scroll-top">SCROLL TO TOP</div>
        </div>
        <?php wp_footer(); ?>
    </body>
</html>