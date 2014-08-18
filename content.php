<?php
/**
 * @package WordPress
 * @subpackage Downbeat
 */
 ?>  
<section id="content">
<div class="container">
    <div class="two-thirds column alpha" id="main">
        <?php get_template_part( 'loop', 'index' ); //the Loop ?>
    </div>
    <div class="one-third column omega" id="side">
        <?php get_template_part( 'sidebar', 'index' ); //the Sidebar ?>
    </div>
    <!--clearing break-->
    <br class="clear" />
</div>
</section>