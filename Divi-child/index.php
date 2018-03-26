<?php get_header(); ?>
<?php
	$search_term='';
	if (get_search_query()!="")
	{
		$search_term=get_search_query();
	}
	$categories = get_the_category();
	$category_id = $categories[0]->cat_ID;
?>
<div id="main-content">
	<div class="entry-content">
		<div class="et_pb_section  et_pb_section_0 et_section_regular">
			<?php get_template_part( 'acuam_header', 'acuam_header' ); ?>		
		</div>
		<div class="et_pb_row et_pb_row_3">
			<div class="et_pb_column et_pb_column_2_3  et_pb_column_3">
				<?php
				if ($search_term!="")
				{
					echo '<h1 style="text-align: center; width: 100%; color: #e61396; padding: 5px;">–&nbsp;&nbsp;&nbsp;Resultados: '.$search_term.'&nbsp;&nbsp;&nbsp;–</h1>';
				}
				else if ($category_id>0)
				{
					echo '<h1 style="text-align: center; width: 100%; color: #e61396; padding: 5px;">–&nbsp;&nbsp;&nbsp;'.get_cat_name($cat).'&nbsp;&nbsp;&nbsp;–</h1>';
				}
				?>
				
				<?php
					if ( have_posts() ) :
						echo '<div class="et_pb_salvattore_content" data-columns style="margin-top:30px;">';
						while ( have_posts() ) : the_post();
							$post_format = et_pb_post_format(); ?>
		
							<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
						<?php
							$thumb = '';
		
							$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );
		
							$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
							$classtext = 'et_pb_post_main_image';
							$titletext = get_the_title();
							$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
							$thumb = $thumbnail["thumb"];
		
							et_divi_post_format_content();
		
							if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
								if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
									printf(
										'<div class="et_main_video_container">
											%1$s
										</div>',
										$first_video
									);
								elseif ( ! in_array( $post_format, array( 'gallery' ) ) && 'on' === et_get_option( 'divi_thumbnails_index', 'on' ) && '' !== $thumb ) : ?>
									<a href="<?php the_permalink(); ?>">
										<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
									</a>
							<?php
								elseif ( 'gallery' === $post_format ) :
									et_pb_gallery_images();
								endif;
							} ?>
		
						<?php if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) : ?>
							<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) : ?>
								<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<?php endif; ?>
		
							<?php
								et_divi_post_meta();
		
								if ( 'on' !== et_get_option( 'divi_blog_style', 'false' ) || ( is_search() && ( 'on' === get_post_meta( get_the_ID(), '_et_pb_use_builder', true ) ) ) ) {
									truncate_post( 270 );
								} else {
									the_content();
								}
							?>
						<?php endif; ?>
		
							</article> <!-- .et_pb_post -->
					<?php
							endwhile;
		
							echo '</div>';
							
							if ( function_exists( 'wp_pagenavi' ) )
								wp_pagenavi();
							else
								get_template_part( 'includes/navigation', 'index' );
						else :
							get_template_part( 'includes/no-results', 'index' );
						endif;
					?>
			</div> <!-- #left-area -->
			
			<div class="et_pb_column et_pb_column_1_3  et_pb_column_4 et-last-child" style="padding-top:30px;">
				<?php get_sidebar(); ?>
			</div>
			
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php get_footer(); ?>