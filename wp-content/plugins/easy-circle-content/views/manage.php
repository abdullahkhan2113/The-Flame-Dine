<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<script>

	jQuery(document).ready(function(){

		jQuery('.form_ecc input[name="icon"]').keyup(function(){

			jQuery('.form_ecc .loading').show();

			//autocomplète ajax pour la choix de l'icone
			jQuery.post(ajaxurl, {action: 'fa_icons_list', q: jQuery(this).val(), _ajax_nonce: '<?= wp_create_nonce( "fa_icons_list" ); ?>' }, function(icons){

				jQuery('.form_ecc .icons_list_search').html(icons);

				jQuery('.form_ecc .icons_list_search li').click(function(){

					var icon = jQuery(this).attr('rel');

					jQuery('.form_ecc #new_icon').attr('class', 'fa fa-'+icon);

					jQuery('.form_ecc input[name=icon]').val(icon);

					jQuery('.form_ecc .icons_list_search').html('');

				});

				jQuery('.form_ecc .loading').hide();
			});

		});

		jQuery('.form_ecc').submit(function(){

			var icon = jQuery(this).find('input[type=icon]').val();
			var name = jQuery(this).find('input[type=name]').val();

			if(name == "" || icon == "")
				alert('Please fill in all fields !');
			else
				jQuery.post(ajaxurl, jQuery(this).serialize(), function(){

					window.location.href = "<?= admin_url('admin.php?page=easy_circle_contents&task=manage&saved=1&id='.$circle_content->id) ?>";

				});

			return false;

		});

		jQuery('.ecc_icons_list .remove').click(function(){

			var id = jQuery(this).attr('rel');

			jQuery.post(ajaxurl, { action: 'ecc_remove_icon', id: id, _ajax_nonce: '<?= wp_create_nonce( "ecc_remove_icon" ); ?>' }, function(){

				jQuery('.ecc_icons_list li[rel='+id+']').remove();

			});

		});

		//changement d'ordre des icons
		jQuery('.ecc_icons_list').sortable({
			update: function( event, ui ) {
				//effectuer le changement de position en BDD par Ajax
				jQuery.post(ajaxurl, {action: 'ecc_order_icon', id: jQuery(ui.item).attr('rel'), order: (ui.item.index()+1), _ajax_nonce: '<?= wp_create_nonce( "ecc_order_icon" ); ?>' });
			}
		});

	});

</script>

<h2>Manage circle content "<?= $circle_content->name ?>"</h2>

<form action="" method="post" class="form_ecc">

	<input type="hidden" name="id" value="<?= $icon->id ?>" />
	<input type="hidden" name="id_content" value="<?= $circle_content->id ?>" />
	<input type="hidden" name="action" , value="ecc_save_icon" />
	<?php wp_nonce_field( "ecc_save_icon" ); ?>

	<div class="name_line">
		<label for="">Icon* (type to search):</label> 
		<input type="text" name="icon" value="<?= $icon->icon ?>" autocomplete="off" required />
		<i id="new_icon" class="fa fa-<?= $icon->icon ?>" style="font-size: <?= $circle_content->text_size ?>px"></i>
		<img src="<?= plugins_url( 'images/loading.gif', dirname(__FILE__)) ?>" class="loading" />
		<a href="https://fontawesome.com/v5.15/icons?d=listing&p=9&m=free" target="_blank">List of all icons avalaible</a>
		<br />

		<div class="icons_list_search">
		</div>
	</div>

	<label for="">Name*:</label> <textarea name="name" required><?= $icon->name ?></textarea><br />

	<label for="">Icon color:</label> <input type="color" name="color_icon" value="<?= $icon->color_icon ?>" /><br />

	<label for="">Background color:</label> <input type="text" name="color_bg" value="<?= $icon->color_bg ?>" /><br />

	<label for="">Link:</label> <input type="text" name="link"  value="<?= $icon->link ?>" /><br />

	<label for="">Open in new window ?</label> <input type="checkbox" name="blank" value="1" <?= ($icon->blank ? 'checked="checked"' : '') ?> /><br />

	<input type="submit" value="Save icon" class="button button-primary" /> <a href="<?= admin_url('admin.php?page=easy_circle_contents'); ?>" class="button">Back to circle contents list</a>

</form>

<?php if(isset($_GET['saved'])) : ?>
	<h3>Icon saved!</h3>
<?php endif; ?>

<?php

	if(sizeof($icons) > 0)
	{
		echo '<ul class="ecc_icons_list">';

		global $fas_icons, $far_icons, $fab_icons;					

		foreach( $icons as $icon )
		{
			$class = 'fa';
			if(array_search($icon->icon, $fas_icons) !== false)
				$class = 'fas';
			else if(array_search($icon->icon, $far_icons) !== false)
				$class = 'far';
			else if(array_search($icon->icon, $fab_icons) !== false)
				$class = 'fab';

			echo '<li rel="'.$icon->id.'">
			<div class="ecc_icon" style="background: '.$icon->color_bg.'" title="'.$icon->name.'"><i class="'.$class.' fa-'.$icon->icon.'" style="color: '.$icon->color_icon.';"></i></div>
			<a href="'.admin_url('admin.php?page=easy_circle_contents&task=manage&id='.$circle_content->id).'&id_icon='.$icon->id.'"><img src="'.plugins_url( 'images/edit.png', dirname(__FILE__)).'" /></a>
			<a href="#" rel="'.$icon->id.'" class="remove"><img src="'.plugins_url( 'images/remove.png', dirname(__FILE__)).'" /></a>
			</li>';

		}

		echo '</ul>';

	}
	else {
	
		echo '<p>No icons yet.</p>';

		}	

?>