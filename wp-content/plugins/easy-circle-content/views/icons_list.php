<ul>
<?php

	foreach($icons_list as $icon_family => $icons)
	{
		foreach($icons as $icon)
			echo '<li rel="'.$icon.'"><i class="'.$icon_family.' fa-'.$icon.'"></i>'.$icon.'</li>';
	}

?>
</ul>