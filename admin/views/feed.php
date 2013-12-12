<?php
/**
 * @package   FollowMesh
 * @author    Dmytri Kleiner <dk@trick.ca>
 * @license   GPL-2.0+
 * @link      https://github.com/tricknik/followmesh
 * @copyright 2013 Automattic
 */

$FollowMeshFeedTable = new FollowMesh_Feed_Table();
$FollowMeshFeedTable->prepare_items();

?>
<div class="wrap">

	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<div id="icon-users" class="icon32"><br/></div>
	
	<h2>Your Feed</h2>
	<div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
	<form id="followings-filter" method="get">
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
			<?php $FollowMeshFeedTable->display() ?>
		</form>
	
</div>
