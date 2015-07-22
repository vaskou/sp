<?php
/**
 * @version		1.4
 * @package		DISQUS for K2 Plugin (K2 plugin)
 * @author    Marek Wojtaszem - http://www.nika-foto.pl
 * @copyright	Copyright (c) 2012 Marek Wojtaszek. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die ('Restricted access');

JLoader::register('K2Plugin', JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_k2'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'k2plugin.php');

class plgK2K2_facebookcomments extends K2Plugin {

	var $pluginName = 'k2_facebookcomments';
	var $pluginNameHumanReadable = 'Facebook comments for K2 plugin';


	public function plgK2K2_facebookcomments( & $subject, $params) {
		parent::__construct($subject, $params);
		$mode = $this->params->def('mode', 1);
		//JPlugin::loadLanguage('plg_k2_disqus_k2');	
	}


	function onK2CommentsCounter( &$item, &$params, $limitstart) {
		
		return;
		$plugin = JPluginHelper::getPlugin('k2', $this->pluginName);
		$pluginParams = $this->params;

		$item_link = $item->link;
		$identifier = $item->id;

		$output = ''.JText::_('DISQUS_COMMENTS_COUNT').':<a href= "'.$item_link.'#disqus_thread" data-disqus-identifier="'.$identifier.'">'.JText::_('DISQUS_COMMENTS').'</a>
		';

		return $output;
	}

	function onK2CommentsBlock( &$item, &$params, $limitstart) {
		
		
		$lang = JFactory::getLanguage();
		$lang_shortcode = explode('-',$lang->getTag());

		if ($this->isArticlePage()): 
		
			$output = 's
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = "//connect.facebook.net/'.$lang_shortcode[0].'_'.$lang_shortcode[1].'/sdk.js#xfbml=1&version=v2.4";
					fjs.parentNode.insertBefore(js, fjs);
					}(document, "script", "facebook-jssdk"));
				</script>
	
				<div class="fb-comments" data-href="'.JURI::current().'" data-numposts="5"></div>
				
				<p class="sp-comments-disclaimer">Το ​SpoudaZO.gr δεν φέρει ουδεμία ευθύνη εκ του νόμου, ​για τα σχόλια που φιλοξενεί μέσω της πλατφόρμας του facebook. Παρακαλούμε να σχολιάζεις με ευγένεια και σεβασμό προς τους συνομιλητές σου. Απόφυγε τις ύβρεις και τους χαρακτηρισμούς. Σε περίπτωση που θεωρείς πως θίγεσαι, ​για οποιονδήποτε λόγο, από κάποιο εξ’ αυτών, ​μπορείς να το αναφέρεις (report) απευθείας στο facebook πατώντας το "x" δεξιά και μετά "αναφορά" καθώς και να επικοινωνήσει ​μαζί μας, μέσω της φόρμας επικοινωνίας, ώστε να ​προβούμε στις αρμόζουσες ενέργειες.​</p>
				';
		else: 
			$output = '';
		endif;
		
		return $output;
		
	}
	
	public function isArticlePage()
	{
		$option 	 = JRequest::getVar('option');
		$view 		 = JRequest::getVar('view');
		
		if  ($option == 'com_k2' && $view == 'item'/*K2 Specific*/)
		{
			return true;
		} 
		return false;
	}
	
	public function isK2()
	{
		$option 	 = JRequest::getVar('option');
		
		if  ($option == 'com_k2')
		{
			return true;
		} 
		
		return false;
	}
} 
