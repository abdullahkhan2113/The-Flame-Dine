<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<h2>All circle contents</h2>



<a href="<?= admin_url('admin.php?page=easy_circle_contents&task=new') ?>" class="button button-primary">Add a new circle content</a>
<?php



	if(sizeof($circle_contents) > 0)

	{



		foreach($circle_contents as $circle_content)

		{

			echo '<div class="beautiful_chart"><h3>'.$circle_content->name.'</h3>

			<a href="'.admin_url('admin.php?page=easy_circle_contents&task=manage&id='.$circle_content->id).'" title="Manage icons"><img src="'.plugins_url( 'images/manage.png', dirname(__FILE__) ).'" /></a>

			<a href="'.admin_url('admin.php?page=easy_circle_contents&task=edit&id='.$circle_content->id).'" title="Edit circle content"><img src="'.plugins_url( 'images/edit.png', dirname(__FILE__)).'" /></a>

			<a href="'.admin_url('admin.php?page=easy_circle_contents&task=remove&id='.$circle_content->id).'" title="Remove circle content"><img src="'.plugins_url( 'images/remove.png', dirname(__FILE__)).'" /></a>

			<br />

			<b>Shortcode : </b>

			<input type="text" value="[easy-circle-content id='.$circle_content->id.']" readonly />

			</div>';

		}

	}

	else

		echo '<p>No circle content created yet !</p>';

?>

<div id="ecc_pro">

	<h3>Need more options? Look at <a href="https://www.info-d-74.com/en/produit/easy-circle-contents-pro-plugin-wordpress-2/" target="_blank">Easy Circle Contents Pro</a> <a href="https://www.facebook.com/infod74/" target="_blank"><img src="<?php echo plugins_url( 'images/fb.png', dirname(__FILE__)) ?>" alt="" /></a></h3>

	<a href="https://www.info-d-74.com/en/produit/easy-circle-contents-pro-plugin-wordpress-2/" target="_blank"><img src="<?php echo plugins_url( 'images/pro.jpg', dirname(__FILE__) ) ?>" /></a>

</div>