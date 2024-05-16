<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package school_education
 */
$archive_layout = school_education_get_option( 'archive_layout' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php $archive_layout = school_education_get_option( 'archive_layout' );
		$show_post_image = school_education_get_option( 'school_education_show_post_featured_image_setting' );
		if ( true === $show_post_image ) { ?>
			<div class="blog-img">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php
					$archive_image           = school_education_get_option( 'school_education_archive_image' );
					$archive_image_alignment = school_education_get_option( 'school_education_archive_image_alignment' );
					?>
					<?php if ( 'disable' !== $archive_image ) : ?>
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( esc_attr( $archive_image ), array( 'class' => 'align'. esc_attr( $archive_image_alignment ) ) ); ?></a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		<?php }?>
		<div class="entry-content-wrapper">
			<?php school_education_entry_meta_date(); ?>
			<?php $show_post_heading = school_education_get_option( 'school_education_show_post_heading_setting' );
			if ( true === $show_post_heading ) { ?>
				<header class="entry-header">
					<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
				</header>
			<?php } ?>
			<footer class="entry-footer">
				<?php school_education_entry_footer(); ?>
			</footer>
		</div>
		<?php $show_post_content = school_education_get_option( 'school_education_show_post_content_setting' );
		if ( true === $show_post_content ) { ?>
			<div class="text-content">
				<?php if ( 'full' === $archive_layout ) : ?>
					<?php
					the_content( sprintf(
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'school-education' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );
					?>
					<?php
						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'school-education' ),
							'after'  => '</div>',
						) );
					?>
			    <?php else : ?>
					<?php the_excerpt(); ?>
			    <?php endif; ?>
			</div>
		<?php } ?>
</article>
