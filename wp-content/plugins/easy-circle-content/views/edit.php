<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<h2>Add/edit a circle content</h2>

<form action="" method="post" class="form_ecc">

	<input type="hidden" name="id" value="<?= $circle_content->id ?>" />

	<label for="">Name : </label> <input type="text" name="name" value="<?= $circle_content->name ?>" /><br />

	<label for="">Width : </label> <input type="text" name="width" value="<?= $circle_content->width ?>" />px<br />

	<label for="">Height : </label> <input type="text" name="height" value="<?= $circle_content->height ?>" />px<br />

	<label for="">Icon size : </label> <input type="text" name="icon_size" value="<?= $circle_content->icon_size ?>" />px<br />

	<label for="">Title size : </label> <input type="text" name="title_size" value="<?= $circle_content->title_size ?>" />px<br />

	<label for="">Title color : </label> <input type="color" name="title_color" value="<?= $circle_content->title_color ?>" /><br />

	<input type="submit" value="Save circle content" class="button button-primary" /> <a href="<?= admin_url('admin.php?page=easy_circle_contents'); ?>" class="button">Back to circle contents list</a>

</form>