<?php
/**
 * @package WordPress
 * @subpackage Downbeat
 */
if (is_archive()) { ?>

	<h2 class="page-title">
		<?php if ( is_day() ) : ?>
			<?php printf( __( 'Daily Archives: %s', 'index' ), '<span>' . get_the_date() . '</span>' ); ?>
		<?php elseif ( is_month() ) : ?>
			<?php printf( __( 'Monthly Archives: %s', 'index' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'index' ) ) . '</span>' ); ?>
		<?php elseif ( is_year() ) : ?>
			<?php printf( __( 'Yearly Archives: %s', 'index' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'index' ) ) . '</span>' ); ?>
		<?php elseif (is_category() ) : ?>
			<?php printf( __( 'Category Archive', 'index' ) ); ?>: <?php single_cat_title(); ?>
		<?php else : ?>
			<?php _e( 'Blog Archives', 'index' ); ?>
		<?php endif; ?>
	</h2>
				
<?php } ?>
	
<?php while ( have_posts() ) : the_post(); ?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <a class="title-link" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title('<h3 class="post-title">', '</h3>'); ?></a>
    <?php if (!is_page()) { ?>
		<section class="pre-meta">
			<p>Posted by <?php the_author_posts_link(); ?> on <?php echo get_the_date(); ?></p>
		</section>
    <?php } ?>
    <section class="entry">
	<?php if (!is_singular()) {
             the_excerpt(); 
			 } else { 
             the_content("Continue reading " . the_title('', '', false)); 
	} ?>
	<?php wp_link_pages( $args ); ?>
    </section>
    <?php if (!is_page()) { ?>
		<section class="post-meta">
		    <?php if ( get_theme_mod( 'downbeat_tags' ) == "yes") : ?>
				<p class="remove-bottom">Categories: <?php the_category(' '); ?> | <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>		    	
		    	<p><?php the_tags(); ?></p>
		    <?php else : ?>
				<p>Categories: <?php the_category(' '); ?> | <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p>
		    <?php endif; ?>
		</section>
    <?php } ?>
</article>
<?php endwhile; ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
	<nav id="nav-below">
		<div class="nav-previous"><?php next_posts_link(); ?></div>
		<div class="nav-next"><?php previous_posts_link(); ?></div>
	</nav><!-- #nav-below -->
<?php endif; ?>

<?php /* Only load comments on single post */ ?>
<?php if(is_single()) : comments_template( '', true ); endif; ?>