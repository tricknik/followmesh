<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   FollowMesh
 * @author    Dmytri Kleiner <dk@trick.ca>
 * @license   GPL-2.0+
 * @link      @TODO
 * @copyright 2013 Automattic
 */

//Create an instance of our package class...
$FollowMeshFollowingsTable = new FollowMesh_Followings_Table();
//Fetch, prepare, sort, and filter our data...
$FollowMeshFollowingsTable->prepare_items();

?>
<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<div id="icon-users" class="icon32"><br/></div>
	
	<form id="following-add" method="post">
		<table class="form-table">
		<tr valign="top">
		<th scope="row"><label for="name"><?php _e('Name', 'followmesh') ?></label></th>
		<td><input name="name" type="text" id="name" value="" class="regular-text" /></td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="name"><?php _e('Domain', 'followmesh') ?></label></th>
		<td><input name="domain" type="text" id="domain" value="" class="regular-text" /></td>
		</tr>
		<tr valign="top">
		<th scope="row"><label for="user"><?php _e('User', 'followmesh') ?></label></th>
		<td><input name="user" type="text" id="user" value="" class="regular-text" /></td>
		</tr>
		</table>
		<?php submit_button( __('Follow', 'followmesh') ); ?>
	</form>

	<h2>Your Followings</h2>
	<div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
	<form id="followings-filter" method="get">
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<?php $FollowMeshFollowingsTable->display() ?>
		</form>
	
</div>
