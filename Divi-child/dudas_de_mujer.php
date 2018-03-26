<?php 
function insertarddm () {
	ob_start();
	$data = json_decode(file_get_contents('http://www.dudasdemujer.com/es/api/get_questions_indasec'));
	if (!count($data)>0)
	{
		return true;
	}
	
	$output='
<div class="et_pb_column et_pb_column_4_4  et_pb_column_3 et-last-child">
		<div class="et_pb_blog_grid clearfix et_pb_module et_pb_bg_layout_light et_pb_blog_0 ">
				<div class="et_pb_salvattore_content" data-columns>
';
	
	for ($i=0;$i<6;$i++)
	{
		$output.='
					<article class="et_pb_post clearfix et_pb_has_overlay post-4385 post type-post status-publish format-standard has-post-thumbnail hentry category-nosotras category-salud ddm">
						<div class="et_pb_image_container">
							<a target="_blank" href="'.$data[$i]->url.'" class="entry-featured-image-url">
								<img src="'.$data[$i]->image_url_original.'" alt="'.$data[$i]->title.'" width="400" height="250" />
								<span class="et_overlay et_pb_inline_icon" data-icon="&#x50;"></span>
							</a>
						</div>
						<h2 class="entry-title">
							<a href="'.$data[$i]->url.'" target="_blank">'.$data[$i]->title.'</a>
						</h2>
						<div style="width:100%;float:left;text-align:left;padding: 10px;">
							<p style="float:left;width:33%;font-size:12px;overflow: hidden;"><img src="'.get_stylesheet_directory_uri().'/ico_user.png" style="float:left;height:18px;margin-right:5px;">'.$data[$i]->asker.'</p>
							<p style="float:left;width:33%;font-size:12px;overflow: hidden;"><img src="'.get_stylesheet_directory_uri().'/ico_geoloc.png" style="float:left;height:18px;margin-right:5px;">'.$data[$i]->asker_city.'</p>
							<p style="float:left;width:33%;font-size:12px;overflow: hidden;"><img src="'.get_stylesheet_directory_uri().'/ico_age.png" style="float:left;height:18px;margin-right:5px;">'.$data[$i]->asker_age.'</p>
						</div>
						<div class="post-content">
							<p>'.$data[$i]->text.'</p>
						</div>
					</article>
		';
	}
$output.='					
				</div>
			</div>
</div>
';
	
	return $output;
	 
}
