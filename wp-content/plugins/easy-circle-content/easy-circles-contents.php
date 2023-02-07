<?php

/*
Plugin Name: Easy Circle Contents
Plugin URI: 
Version: 1.21
Description: Create easily beautiful circle contents 
Author: Manu225
Author URI: 
Network: false
Text Domain: easy-circles-contents
Domain Path: 
*/



register_activation_hook( __FILE__, 'easy_circles_contents_install' );

register_uninstall_hook(__FILE__, 'easy_circles_contents_desinstall');



function easy_circles_contents_install() {



	global $wpdb;



	$contents_table = $wpdb->prefix . "easy_circles_contents";

	$contents_data_table = $wpdb->prefix . "easy_circles_contents_data";



	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');



	$sql = "

        CREATE TABLE `".$contents_table."` (

          id int(11) NOT NULL AUTO_INCREMENT,          

          name varchar(50) NOT NULL,

          width int(11) NOT NULL,

          height int(11) NOT NULL,

          title_color varchar(30) NOT NULL,

          title_size varchar(10) NOT NULL,

          icon_size varchar(10) NOT NULL,

          PRIMARY KEY  (id)

        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

    ";



    dbDelta($sql);



    $sql = "

        CREATE TABLE `".$contents_data_table."` (

          id int(11) NOT NULL AUTO_INCREMENT,          

          name varchar(50) NOT NULL,

          icon varchar(25) NOT NULL,

          color_icon varchar(30) NOT NULL,

          color_bg varchar(30) NOT NULL,

          link varchar(255) NOT NULL,

          blank int(1) NOT NULL,

          `order` int(5) NOT NULL,

          id_content int(11),

          PRIMARY KEY (id)

        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

    ";

    

    dbDelta($sql);

}



function easy_circles_contents_desinstall() {



	global $wpdb;

	$contents_table = $wpdb->prefix . "easy_circles_contents";

	$contents_data_table = $wpdb->prefix . "easy_circles_contents_data";

	//suppression des tables

	$sql = "DROP TABLE ".$contents_table.";";

	$wpdb->query($sql);



    $sql = "DROP TABLE ".$contents_data_table.";";   

	$wpdb->query($sql);

}



add_action( 'admin_menu', 'register_easy_circles_contents_menu' );

function register_easy_circles_contents_menu() {

	add_menu_page('Easy Circle Contents', 'Easy Circle Contents', 'edit_pages', 'easy_circle_contents', 'easy_circle_contents', plugins_url( 'images/icon.png', __FILE__), 38);

}



add_action('admin_print_styles', 'easy_circles_contents_css' );

function easy_circles_contents_css() {

    wp_enqueue_style( 'EasyCirclesContentsStylesheet', plugins_url('css/admin.css', __FILE__) );
    wp_enqueue_style( 'EasyCirclesFontAwesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');

}


add_action( 'admin_enqueue_scripts', 'load_script_asy_circles_contents' );
function load_script_asy_circles_contents() {

    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-sortable');

}


function easy_circle_contents() {

	global $wpdb;

	$contents_table = $wpdb->prefix . "easy_circles_contents";

	$contents_data_table = $wpdb->prefix . "easy_circles_contents_data";

	if(current_user_can('edit_pages'))
	{

		if(isset($_GET['task']))
		{

			switch($_GET['task'])
			{

				case 'new':

				case 'edit':

					if(sizeof($_POST))
					{

						$query = "REPLACE INTO ".$contents_table." (`id`, `name`, `width`, `height`, `title_size`, `title_color`, `icon_size`)

						VALUES (%d, %s, %d, %d, %d, %s, %d)";

						$query = $wpdb->prepare( $query, $_POST['id'], sanitize_text_field(stripslashes_deep($_POST['name'])), $_POST['width'], $_POST['height'], $_POST['title_size'], sanitize_text_field(stripslashes_deep($_POST['title_color'])), $_POST['icon_size'] );

						$wpdb->query( $query );


						//on affiche tous les circle contents

						$circle_contents = $wpdb->get_results("SELECT * FROM ".$contents_table." ORDER BY name");

						include(plugin_dir_path( __FILE__ ) . 'views/circle_contents.php');



					}

					else

					{

						//édition d'un graph existant ?

						if(is_numeric($_GET['id']))

						{

							$q = "SELECT * FROM ".$contents_table." WHERE id = %d";

							$query = $wpdb->prepare( $q, $_GET['id']);

							$circle_content = $wpdb->get_row( $query );

						}



						if(empty($circle_content))

							$circle_content = (object)'';


						include(plugin_dir_path( __FILE__ ) . 'views/edit.php');

					}



				break;



				case 'manage':



					if(is_numeric($_GET['id']))

					{


						$q = "SELECT * FROM ".$contents_table." WHERE id = %d";

						$query = $wpdb->prepare( $q, $_GET['id']);

						$circle_content = $wpdb->get_row( $query );

						if($circle_content)

						{

							$q = "SELECT * FROM ".$contents_data_table." WHERE id_content = %d ORDER BY `order` ASC";

							$query = $wpdb->prepare( $q, $_GET['id']);

							$icons = $wpdb->get_results( $query );

							if(is_numeric($_GET['id_icon']))
							{
								foreach ($icons as $icon) {
									if($icon->id == $_GET['id_icon'])
										break;
								}
							}

							//on inclut les listes d'icons pour le choix de la famille
							require_once(plugin_dir_path( __FILE__ ) . 'icons_lists.php');

							include(plugin_dir_path( __FILE__ ) . 'views/manage.php');

						}					

					}



				break;



				case 'remove':



					if(is_numeric($_GET['id']))

					{

						//on supprime les données et le graph

						$q = "DELETE FROM ".$contents_data_table." WHERE id_content = %d";

						$query = $wpdb->prepare( $q, $_GET['id']);

						$wpdb->query( $query );



						$q = "DELETE FROM ".$contents_table." WHERE id = %d";

						$query = $wpdb->prepare( $q, $_GET['id']);

						$wpdb->query( $query );

					}



					//on affiche tous les graphs

					$circle_contents = $wpdb->get_results("SELECT * FROM ".$contents_table." ORDER BY name");

					include(plugin_dir_path( __FILE__ ) . 'views/circle_contents.php');

				break;

			}

		}

		else

		{

			if(!is_numeric($_GET['id']))

			{

				//on affiche tous les graphs

				$circle_contents = $wpdb->get_results("SELECT * FROM ".$contents_table." ORDER BY name");

				include(plugin_dir_path( __FILE__ ) . 'views/circle_contents.php');

			}

		}

	}



}



add_shortcode('easy-circle-content', 'display_easy_circle_content');

function display_easy_circle_content($atts) {

	if(is_numeric($atts['id']))

	{

		global $wpdb;


		$contents_table = $wpdb->prefix . "easy_circles_contents";

		$contents_data_table = $wpdb->prefix . "easy_circles_contents_data";

		$q = "SELECT * FROM ".$contents_table." WHERE id = %d";

		$query = $wpdb->prepare( $q, $atts['id']);

		$circle_content = $wpdb->get_row( $query );

		if($circle_content)
		{

			$q = "SELECT * FROM ".$contents_table." WHERE id = %d";

			$query = $wpdb->prepare( $q, $atts['id'] );

			$circle_content = $wpdb->get_row( $query );

			//print_r($circle_content);

			$q = "SELECT * FROM ".$contents_data_table." WHERE id_content = %d ORDER BY `order` ASC";

			$query = $wpdb->prepare( $q, $atts['id'] );

			$circle_content->icons = $wpdb->get_results( $query );

			//on inclut jquery
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'easy-circle-content-front-js', plugins_url( 'js/front.js', __FILE__ ));
			wp_enqueue_style( 'EasyCirclesContentsFrontStylesheet', plugins_url('css/front.css', __FILE__) );
			wp_enqueue_style( 'EasyCirclesFrontFontAwesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');

			//on inclut les listes d'icons pour le choix de la famille
			require_once(plugin_dir_path( __FILE__ ) . 'icons_lists.php');


			$html = '';

			if($atts['show_title'] == true)

				$html .= '<h3>'.$circle_content->name.'</h3>';

			ob_start();
			include(plugin_dir_path( __FILE__ ) . 'views/circle_content.tpl.php');
			$html .= ob_get_clean();

			return $html;

		}	

		else

			return 'Circle Content ID '.$atts['id'].' not found !';	

	}

}


//Ajax : autocomplète icons
add_action( 'wp_ajax_fa_icons_list', 'fa_icons_list' );

function fa_icons_list() {

	if(current_user_can('edit_pages'))
	{

		check_ajax_referer( 'fa_icons_list' );

		require_once(plugin_dir_path( __FILE__ ) . 'icons_lists.php');

		global $fas_icons, $far_icons, $fab_icons;

		$icons_list = array();

		if($_POST['q'])
		{
			$icons_list['fas'] = preg_grep("/^(.*)".$_POST['q']."(.*)$/", $fas_icons);
			$icons_list['far'] = preg_grep("/^(.*)".$_POST['q']."(.*)$/", $far_icons);
			$icons_list['fab'] = preg_grep("/^(.*)".$_POST['q']."(.*)$/", $fab_icons);
		}

		if(sizeof($icons_list['fas']) > 0 || sizeof($icons_list['far']) > 0 || sizeof($icons_list['fab']) > 0)
		{
			include(plugin_dir_path( __FILE__ ) . 'views/icons_list.php');
		}
		else
			echo 'No icon found!';
	}
	wp_die();
}

//Ajax : sauvegarde d'une icone
add_action( 'wp_ajax_ecc_save_icon', 'ecc_save_icon' );

function ecc_save_icon() {

	if(current_user_can('edit_pages'))
	{
		check_ajax_referer( 'ecc_save_icon' );

		if(!empty($_POST['name']) && !empty($_POST['icon']))
		{
			global $wpdb;

			$contents_data_table = $wpdb->prefix . "easy_circles_contents_data";

			if(empty($_POST['id']))
			{
				//trouve le max order
				$query = "SELECT MAX(`order`)+1 as max FROM ".$contents_data_table." WHERE id_content = %d";

				$query = $wpdb->prepare( $query, $_POST['id_content'] );

				$max = $wpdb->get_row( $query );

				$query = "REPLACE INTO ".$contents_data_table." (`name`, `icon`, `color_icon`, `color_bg`, `link`, `blank`, `order`, `id_content`)
				VALUES (%s, %s, %s, %s, %s, %d, %d, %d)";

				$query = $wpdb->prepare( $query, stripslashes_deep($_POST['name']), sanitize_text_field(stripslashes_deep($_POST['icon'])), sanitize_text_field(stripslashes_deep($_POST['color_icon'])), sanitize_text_field(stripslashes_deep($_POST['color_bg'])), sanitize_text_field(stripslashes_deep($_POST['link'])), $_POST['blank'], $max->max, $_POST['id_content'] );

			}
			else
			{

				$query = "UPDATE ".$contents_data_table."
				SET `name` = %s, `icon` = %s, `color_icon` = %s, `color_bg` = %s, `link` = %s, `blank` = %d, `id_content` = %d
				WHERE `id` = %d";

				$query = $wpdb->prepare( $query, stripslashes_deep($_POST['name']), sanitize_text_field(stripslashes_deep($_POST['icon'])), sanitize_text_field(stripslashes_deep($_POST['color_icon'])), sanitize_text_field(stripslashes_deep($_POST['color_bg'])), sanitize_text_field(stripslashes_deep($_POST['link'])), $_POST['blank'], $_POST['id_content'], $_POST['id']);

				echo $query;

			}

			$wpdb->query( $query );
		}
	}

	wp_die();

}

//Ajax : autocomplète icons
add_action( 'wp_ajax_ecc_remove_icon', 'ecc_remove_icon' );

function ecc_remove_icon() {

	check_ajax_referer( 'ecc_remove_icon' );

	if(is_numeric($_POST['id']))
	{
		global $wpdb;
		$contents_data_table = $wpdb->prefix . "easy_circles_contents_data";
		$query = "DELETE FROM ".$contents_data_table." WHERE id = %d";
		$query = $wpdb->prepare( $query, $_POST['id'] );
		$wpdb->query( $query );
	}

	wp_die();

}

//Ajax : changement de position d'une icone
add_action( 'wp_ajax_ecc_order_icon', 'ecc_order_icon' );

function ecc_order_icon() {

	check_ajax_referer( 'ecc_order_icon' );

	if (is_admin()) {
		global $wpdb;

		$contents_data_table = $wpdb->prefix . "easy_circles_contents_data";

		if(is_numeric($_POST['id']) && is_numeric($_POST['order']))
		{
			$icon = $wpdb->get_row( $wpdb->prepare( "SELECT id_content, `order` FROM ".$contents_data_table." WHERE id = %d", $_POST['id'] ));
			if($_POST['order'] > $icon->order)
				$wpdb->query( $wpdb->prepare( "UPDATE ".$contents_data_table." SET `order` = `order` - 1 WHERE id_content = %d AND `order` <= %d AND `order` > %d", $icon->id_content, $_POST['order'], $icon->order ));
			else
				$wpdb->query( $wpdb->prepare( "UPDATE ".$contents_data_table." SET `order` = `order` + 1 WHERE id_content = %d AND `order` >= %d AND `order` < %d", $icon->id_content, $_POST['order'], $icon->order ));
			$wpdb->query( $wpdb->prepare( "UPDATE ".$contents_data_table." SET `order` = %d WHERE id = %d", $_POST['order'], $_POST['id'] ));
			
		}
		wp_die(); // this is required to terminate immediately and return a proper response
	}
}

?>