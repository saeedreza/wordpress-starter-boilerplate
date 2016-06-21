<?php get_header(); ?>

<!--[if lt IE 7]>
	<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div>
<?php the_content(); ?>
</div>

<?php endwhile; else: ?>
<p>Sorry, no posts matched your criteria.</p>
<?php endif; ?>

<?php get_footer(); ?>
