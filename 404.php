<?php
/**
* The template for displaying 404 pages
*/

get_header();

?>



<div class="main-conatiner">
  <div class="blog-list-block">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          
                <h1 class="extra-head"><?php _e( 'Not Found', '' ); ?> 
                </h1> 
                <div class="page-content">
                  <h4><?php _e( 'It looks like nothing was found at this location. ', '' ); ?></h4>
                  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary btn-lg">Go Back</a>
                </div>
         
        </div>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();
?>