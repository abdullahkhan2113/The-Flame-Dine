<?php

	$css_selector = '#circles_content_'.$circle_content->id;
	$width_circle = $height_circle = $circle_content->icon_size+round($circle_content->icon_size/5);
	$padding_circle = round($circle_content->icon_size/5);
	
?> 
	<style>

		<?= $css_selector ?> .title {
			font-size: <?= $circle_content->title_size ?>px;
		}

		<?= $css_selector ?> .title span {
			width: <?= $circle_content->width-2*$width_circle-4*$padding_circle ?>px;
		}

		<?= $css_selector ?> .circle  {
			font-size: <?= $circle_content->icon_size ?>px;
			padding: <?= $padding_circle ?>px;
			width: <?= $width_circle ?>px;
			height: <?= $height_circle ?>px;
			line-height: <?= $height_circle ?>px;
		}

	</style>
	
		<div id="circles_content_<?= $circle_content->id ?>" class="circles_content" style="width: <?= $circle_content->width ?>px; height:<?= $circle_content->height ?>px">
			<?php

				global $fas_icons, $far_icons, $fab_icons;

				foreach($circle_content->icons as $icon)
				{
					$class = 'fa';
					if(array_search($icon->icon, $fas_icons) !== false)
						$class = 'fas';
					else if(array_search($icon->icon, $far_icons) !== false)
						$class = 'far';
					else if(array_search($icon->icon, $fab_icons) !== false)
						$class = 'fab';
					echo '<a href="'.$icon->link.'" '.($icon->blank == 1 ? 'target="_blank"' : '').' class="circle" rel="'.nl2br($icon->name).'" style="color: '.$icon->color_icon.'; background: '.$icon->color_bg.'"><i class="'.$class.' fa-'.$icon->icon.'"></i></a>';
				}
			?>
			<div class="title" style="line-height: <?= $circle_content->height ?>px; color: <?= $circle_content->title_color ?>"><span></span></div>
		</div>