<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_menu
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
?>

<ul class="menu<?php echo $class_sfx;?> sp-city-sidemenu"<?php
	$tag = '';
	if ($params->get('tag_id')!=NULL) {
		$tag = $params->get('tag_id').'';
		echo ' id="'.$tag.'"';
	}
?>>
<?php
$count=count($list);
foreach ($list as $i => &$item){
	if ($item->id == $active_id) {
		$remove_index = $i;
		break;
	}
}
if($remove_index){
	$active_item=$list[$remove_index];
	unset($list[$remove_index]);
	array_unshift($list,$active_item);
}
$j=0;
foreach ($list as $i => &$item) :
	if($j==5){
		echo '<div class="menu-hidden">';
	}
	$class = 'item-'.$item->id;
	
	if(trim($item->params->get('gk_class')) != '') {
		$class .= ' ' . $item->params->get('gk_class');
	}
	
	if ($item->id == $active_id) {
		$class .= ' current';
	}

	if (in_array($item->id, $path)) {
		$class .= ' active';
	}
	elseif ($item->type == 'alias') {
		$aliasToId = $item->params->get('aliasoptions');
		if (count($path) > 0 && $aliasToId == $path[count($path)-1]) {
			$class .= ' active';
		}
		elseif (in_array($aliasToId, $path)) {
			$class .= ' alias-parent-active';
		}
	}

	if ($item->deeper) {
		$class .= ' deeper';
	}

	if ($item->parent) {
		$class .= ' parent';
	}

	if (!empty($class)) {
		$class = ' class="'.trim($class) .'"';
	}

	echo '<li'.$class.'>';

	// Render the menu item.
	switch ($item->type) :
		case 'separator':
		case 'url':
		case 'component':
			require JModuleHelper::getLayoutPath('mod_menu', 'default_'.$item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
			break;
	endswitch;

	// The next item is deeper.
	if ($item->deeper) {
		echo '<ul>';
	}
	// The next item is shallower.
	elseif ($item->shallower) {
		echo '</li>';
		echo str_repeat('</ul></li>', $item->level_diff);
	}
	// The next item is on the same level.
	else {
		echo '</li>';
	}
	if($i==$count-1){
		echo '</div>';
		echo '<li class="item-more more-less">Περισσότερες πόλεις<i class="fa fa-angle-down"></i></li>';
		echo '<li class="item-less more-less">Λιγότερες πόλεις<i class="fa fa-angle-up"></i></li>';
	}
	$j++;
endforeach;
?></ul>

<script>
jQuery(function($){
	$('.more-less').toggle(
	function(){
		$('.menu-hidden').slideToggle();
		$('.more-less').toggle();
	},
	function(){
		$('.menu-hidden').slideToggle();
		$('.more-less').toggle();
	});
});
</script>
