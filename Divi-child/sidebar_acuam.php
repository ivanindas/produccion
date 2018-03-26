<?php
if ( ( is_single() || is_page() ) && 'et_full_width_page' === get_post_meta( get_queried_object_id(), '_et_pb_page_layout', true ) )
	return;
?>
<div class="et_pb_widget_area et_pb_widget_area_left clearfix et_pb_module et_pb_bg_layout_light  et_pb_sidebar_0">
	<div id="search-2" class="et_pb_widget widget_search" style="margin-top:0px;">
		<h4 class="widgettitle">–&nbsp;&nbsp;&nbsp;Buscador&nbsp;&nbsp;&nbsp;–</h4>
		<form role="search" method="get" id="searchform" class="searchform" action="http://indasec.acuam.com/">
			<div>
				<label class="screen-reader-text" for="s">Buscar:</label>
				<input type="text" value="" name="s" id="s">
				<input type="submit" id="searchsubmit" value="Buscar">
			</div>
		</form>
	</div> <!-- end .et_pb_widget -->
</div> <!-- .et_pb_widget_area -->
<?php dynamic_sidebar( 'sidebar-1' ); ?>
<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_3">
	<div class="et_pb_text_inner">
		<h4 class="widgettitle">–&nbsp;&nbsp;&nbsp;Facebook&nbsp;&nbsp;&nbsp;–</h4>
		<p><iframe style="border: none; overflow: hidden;" src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FIndasec%2F&amp;tabs=timeline&amp;width=370&amp;height=500&amp;small_header=true&amp;adapt_container_width=true&amp;hide_cover=true&amp;show_facepile=false&amp;appId=347095740424" width="370" height="500" frameborder="0" scrolling="no"></iframe></p>
	</div>
</div> <!-- .et_pb_text -->
<div class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_4">
	<div class="et_pb_text_inner">
		<h4 class="widgettitle">–&nbsp;&nbsp;&nbsp;Twitter&nbsp;&nbsp;&nbsp;–</h4>
		<a class="twitter-timeline" href="https://twitter.com/Indasec_Oficial?ref_src=twsrc%5Etfw" data-height="500" data-chrome="noheader nofooter noborders transparent">Tweets by Indasec_Oficial</a> <script async="" src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>		
	</div>
</div> <!-- .et_pb_text -->
