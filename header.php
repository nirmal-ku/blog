<!DOCTYPE html>
<html <?php language_attributes();?>>  
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
<title><?php wp_title();?></title>

    <?php wp_head(); ?>
</head>
    
    <body>
        <div id="app">
            <header class="header box-padding-normal">
                <div class="logo">
                    <?php if ( function_exists( 'the_custom_logo' ) ) 
                    {
                        the_custom_logo();
                    }?>
                </div>
                <div class="nav-container">
 		<div class="search-btn"> <i class="fs-icon-search"></i>							
		</div>
                    <nav class="navigation">	
                        <ul class="navbar main-menu">
                            <?php wp_nav_menu(
                                array(
                                   
                                    'menu'=>'Pits Blog left Menu',
                                    'menu_class'=>'navigation',
                                    'container'  => '',
                                    'items_wrap' => '%3$s'
                                )
                                ); ?>
                                                      
                            
                        </ul>
                        <ul class="navbar">
                        <?php wp_nav_menu(

                            array(
                              
                                'menu'=>'Pits Blog Right Menu',
                                'menu_class'=>'navigation',
                                'container'  => '',
                                'items_wrap' => '%3$s'
                            )
                            ); ?>
      
                        </ul>
                            
                       <div class="close-trigger nav-close">�</div>   
                    </nav>
		<div class="nav-trigger"> <span></span> <span></span> <span></span>
</div>
                </div>		
<div class="page-search">
            <div class="search-close">
                <span></span>
            </div>
            <form role="search" method="get" class="search-form" action="http://pitsblog.dev.displayme.net/">
                <div class="form-group">
                    <label class="screen-reader-text">Search here</label>
                    <input type="search" class="search-field form-control" placeholder="Type here..." value="" name="s">
                    <button type="submit" class="search-submit">
                        <span class="fs-icon-search"></span>
                    </button>
                </div>
			</form>
        </div>
            </header>