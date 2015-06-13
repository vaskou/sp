<?php

/**
 *
 * Default view
 *
 * @version             1.0.0
 * @package             Gavern Framework
 * @copyright			Copyright (C) 2010 - 2011 GavickPro. All rights reserved.
 *               
 */
 
// No direct access.
defined('_JEXEC') or die;
//
$app = JFactory::getApplication();
$user = JFactory::getUser();
// getting User ID
$userID = $user->get('id');
// getting params
$option = JRequest::getCmd('option', '');
$view = JRequest::getCmd('view', '');
// defines if com_users
define('GK_COM_USERS', $option == 'com_users' && ($view == 'login' || $view == 'registration'));
// other variables
$btn_login_text = ($userID == 0) ? JText::_('TPL_GK_LANG_LOGIN') : JText::_('TPL_GK_LANG_LOGOUT');
// make sure that the modal will be loaded
JHTML::_('behavior.modal');
//
$page_suffix_output = $this->API->get('template_pattern', 'none') != 'none' ? 'pattern' . $this->API->get('template_pattern', 'none') . ' ' : '';
$page_suffix_output .= $this->page_suffix;
$tpl_page_suffix = $page_suffix_output != '' ? ' class="'.$page_suffix_output.'" ' : '';

?>
<!DOCTYPE html>
<html lang="<?php echo $this->APITPL->language; ?>" <?php echo $tpl_page_suffix; ?>>
<head>
	<?php $this->layout->addTouchIcon(); ?>
	<?php if(
			$this->browser->get('browser') == 'ie6' || 
			$this->browser->get('browser') == 'ie7' || 
			$this->browser->get('browser') == 'ie8' || 
			$this->browser->get('browser') == 'ie9'
		) : ?>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
	<?php endif; ?>
    <?php if($this->API->get('rwd', 1)) : ?>
    	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
	<?php else : ?>
		<meta name="viewport" content="width=<?php echo $this->API->get('template_width', 1020)+80; ?>">
	<?php endif; ?>
    <jdoc:include type="head" />
    <?php $this->layout->loadBlock('head-spoudazo'); ?>
	<?php $this->layout->loadBlock('cookielaw'); ?>
</head>
<body<?php echo $tpl_page_suffix; ?><?php if($this->browser->get("tablet") == true) echo ' data-tablet="true"'; ?><?php if($this->browser->get("mobile") == true) echo ' data-mobile="true"'; ?><?php $this->layout->generateLayoutWidths(); ?> data-smoothscroll="<?php echo $this->API->get('use_smoothscroll', '1'); ?>">	
	<?php
	     // put Google Analytics code
	     echo $this->social->googleAnalyticsParser();
	?>
	<?php if ($this->browser->get('browser') == 'ie7' || $this->browser->get('browser') == 'ie6'  || $this->browser->get('browser') == 'ie8') : ?>
	<!--[if lte IE 8]>
	<div id="ieToolbar"><div><?php echo JText::_('TPL_GK_LANG_IE_TOOLBAR'); ?></div></div>
	<![endif]-->
	<?php endif; ?>
	
	<?php if(count($app->getMessageQueue())) : ?>
	<jdoc:include type="message" />
	<?php endif; ?>
   	
	<jdoc:include type="modules" name="sentonileft" style="<?php echo $this->module_styles['sentonileft']; ?>" />
	<jdoc:include type="modules" name="sentoniright" style="<?php echo $this->module_styles['sentoniright']; ?>" />

	<div id="gkBg" class="gkPage">
		<div id="gkTopBar" data-menu-type="<?php echo $this->API->get('menu_type', 'classic') == 'overlay' ? 'overlay' : 'classic'; ?>">
		    <?php $this->layout->loadBlock('logo'); ?>
		    
		    <?php if($this->API->modules('banner_top')) : ?>	
		    <div id="gkBannerTop">
		    	<jdoc:include type="modules" name="banner_top" style="<?php echo $this->module_styles['banner_top']; ?>" />
		    </div>
		    <?php endif; ?>  
		    
		    <div id="gkTopNav">
				<?php if($this->API->get('show_menu', 1)) : ?>
				<div id="gkMainMenu" <?php echo $this->API->get('menu_type', 'classic') == 'overlay' ? 'class="gkMenuOverlay"' : 'class="gkMenuClassic"'; ?>>
				        <?php
						$this->mainmenu->loadMenu($this->API->get('menu_name','mainmenu')); 
					    $this->mainmenu->genMenu($this->API->get('startlevel', 0), $this->API->get('endlevel',-1));
					?>
				</div>
				<?php endif; ?>
						
				<div id="gkMobileMenu" class="gkPage"> 
					<i id="mobile-menu-toggler" class="fa fa-bars"></i>
				   	<select id="mobileMenu" onChange="window.location.href=this.value;" class="chzn-done">
				       <?php 
					    	$this->mobilemenu->loadMenu($this->API->get('menu_name','mainmenu')); 
					    	$this->mobilemenu->genMenu($this->API->get('startlevel', 0), $this->API->get('endlevel',-1));
						?>
				   	</select>
				</div>
			     
			     <?php if($this->API->get('login_url', '') != '') : ?>
		         <a href="<?php echo str_replace('&', '&amp;', ($userID == 0) ? $this->API->get('login_url', 'index.php?option=com_users&view=login') : str_replace('&tmpl=blankpage', '', $this->API->get('login_url', 'index.php?option=com_users&view=login'))); ?>" id="gkLogin"><?php echo ($userID == 0) ? JText::_('TPL_GK_LANG_LOGIN') : JText::_('TPL_GK_LANG_LOGOUT'); ?></a>
		         <?php endif; ?>
		         
		         <?php if($this->API->modules('social')) : ?>	
		         <div id="gkSocial">
		         	<jdoc:include type="modules" name="social" style="<?php echo $this->module_styles['social']; ?>" />
		         </div>
		         <?php endif; ?>  
			 </div>
			 
			 <?php if($this->API->modules('search or highligths') || $this->API->get('updates_area', '1') == '1') : ?>
			 <div id="gkToolbar">
			 	<?php if($this->API->get('updates_area', '1') == '1') : ?>	
			 	<div id="gkUpdates">
					<jdoc:include type="modules" name="helloguest" style="<?php echo $this->module_styles['helloguest']; ?>" />
			 	</div>
			 	<?php endif; ?> 
			 	
			 	<?php if($this->API->modules('highlights')) : ?>	
			 	<div id="gkHighlights">
			 		<jdoc:include type="modules" name="highlights" style="<?php echo $this->module_styles['highlights']; ?>" />
			 	</div>
			 	<?php endif; ?>
			 	
			 	<?php if($this->API->modules('search')) : ?>	
			 	<div id="gkSearch">
			 		<jdoc:include type="modules" name="search" style="<?php echo $this->module_styles['search']; ?>" />
			 	</div>
			 	<?php endif; ?>   
			 </div>
			 <?php endif; ?>
		</div>
	
		<div id="gkPageContent">	
	    	<div>
		    	<section id="gkContent">
					<?php if($this->API->modules('banner_left or banner_right')) : ?>
					<div id="gkBanners" class="gkEqualColumns">
						<?php if($this->API->modules('banner_left')) : ?>	
						<div id="gkBannerLeft">
					    	<jdoc:include type="modules" name="banner_left" style="<?php echo $this->module_styles['banner_left']; ?>"  modnum="<?php echo $this->API->modules('banner_left'); ?>" />
					    </div>
						<?php endif; ?>  
						
						<?php if($this->API->modules('banner_right')) : ?>	
						<div id="gkBannerRight">
							<jdoc:include type="modules" name="banner_right" style="<?php echo $this->module_styles['banner_right']; ?>"  modnum="<?php echo $this->API->modules('banner_right'); ?>" />
						</div>
						<?php endif; ?>    
					</div>
					<?php endif; ?>
					
					<?php if($this->API->modules('breadcrumb') || $this->getToolsOverride()) : ?>
					<section id="gkBreadcrumb">
						<?php if($this->API->modules('breadcrumb')) : ?>
						<jdoc:include type="modules" name="breadcrumb" style="<?php echo $this->module_styles['breadcrumb']; ?>" />
						<?php endif; ?>
						
						<?php if($this->getToolsOverride()) : ?>
							<?php $this->layout->loadBlock('tools/tools'); ?>
						<?php endif; ?>
					</section>
					<?php endif; ?>
					
					<?php if($this->API->modules('top1')) : ?>
					<section id="gkTop1" class="gkCols3<?php if($this->API->modules('top1') > 1) : ?> gkNoMargin<?php endif; ?>">
						<div>
							<jdoc:include type="modules" name="top1" style="<?php echo $this->module_styles['top1']; ?>"  modnum="<?php echo $this->API->modules('top1'); ?>" modcol="3" />
						</div>
					</section>
					<?php endif; ?>
					
					<?php if($this->API->modules('top2')) : ?>
					<section id="gkTop2" class="gkCols3<?php if($this->API->modules('top2') > 1) : ?> gkNoMargin<?php endif; ?>">
						<div>
							<jdoc:include type="modules" name="top2" style="<?php echo $this->module_styles['top2']; ?>" modnum="<?php echo $this->API->modules('top2'); ?>" modcol="3" />
						</div>
					</section>
					<?php endif; ?>
					
					<div id="gkContentWrap">
						<div<?php if($this->API->modules('inset')): ?> data-inset-pos="<?php echo $this->API->get('inset_position'); ?>"<?php endif; ?>>
							
							<?php if($this->API->modules('mainbody_top')) : ?>
							<section id="gkMainbodyTop">
								<jdoc:include type="modules" name="mainbody_top" style="<?php echo $this->module_styles['mainbody_top']; ?>" />
							</section>
							<?php endif; ?>	
							
							<section id="gkMainbody">
								<?php if(($this->layout->isFrontpage() && !$this->API->modules('mainbody')) || !$this->layout->isFrontpage()) : ?>
									<jdoc:include type="component" />
								<?php else : ?>
									<jdoc:include type="modules" name="mainbody" style="<?php echo $this->module_styles['mainbody']; ?>" />
								<?php endif; ?>
							</section>
							
							<?php if($this->API->modules('mainbody_bottom')) : ?>
							<section id="gkMainbodyBottom">
								<jdoc:include type="modules" name="mainbody_bottom" style="<?php echo $this->module_styles['mainbody_bottom']; ?>" />
							</section>
							<?php endif; ?>
						</div>
						
						<?php if($this->API->modules('inset')) : ?>
						<aside id="gkInset">
						        <jdoc:include type="modules" name="inset" style="<?php echo $this->module_styles['inset']; ?>" />
						</aside>
						<?php endif; ?>
					</div>
		    	</section>
		    	
		    	<?php if($this->API->modules('bottom1')) : ?>
		    	<section id="gkBottom1">
		    		<div class="gkCols6 gkEqualColumns<?php if($this->API->modules('bottom1') > 1) : ?> gkNoMargin<?php endif; ?>">
		    			<jdoc:include type="modules" name="bottom1" style="<?php echo $this->module_styles['bottom1']; ?>" modnum="<?php echo $this->API->modules('bottom1'); ?>" />
		    		</div>
		    	</section>
		    	<?php endif; ?>
		    	
		    	<?php if($this->API->modules('bottom2')) : ?>
		    	<section id="gkBottom2">
		    		<div class="gkCols6 gkEqualColumns<?php if($this->API->modules('bottom2') > 1) : ?> gkNoMargin<?php endif; ?>">
		    			<jdoc:include type="modules" name="bottom2" style="<?php echo $this->module_styles['bottom2']; ?>" modnum="<?php echo $this->API->modules('bottom2'); ?>" />
		    		</div>
		    	</section>
		    	<?php endif; ?>
			</div>
			<?php if($this->API->modules('sidebar_right')) : ?>
			<aside id="gkSidebarRight">
				<div>
					<jdoc:include type="modules" name="sidebar_right" style="<?php echo $this->module_styles['sidebar_right']; ?>" />
				</div>
			</aside>
			<?php endif; ?>
		</div>
		
		<?php if($this->API->modules('sidebar_left')) : ?>
		<aside id="gkSidebarLeft">
			<div>
				<jdoc:include type="modules" name="sidebar_left" style="<?php echo $this->module_styles['sidebar_left']; ?>" />
			</div>
		</aside>
		<?php endif; ?>
    </div>
    
    <?php if($this->API->modules('bottom3')) : ?>
    <section id="gkBottom3" class="gkPage">
    	<div class="gkCols6<?php if($this->API->modules('bottom3') > 1) : ?> gkNoMargin<?php endif; ?>">
    		<jdoc:include type="modules" name="bottom3" style="<?php echo $this->module_styles['bottom3']; ?>" modnum="<?php echo $this->API->modules('bottom3'); ?>" />
    	</div>
    </section>
    <?php endif; ?>
    
    <?php if($this->API->modules('bottom4')) : ?>
    <section id="gkBottom4" class="gkPage">
    	<div class="gkCols6<?php if($this->API->modules('bottom4') > 1) : ?> gkNoMargin<?php endif; ?>">
    		<jdoc:include type="modules" name="bottom4" style="<?php echo $this->module_styles['bottom4']; ?>" modnum="<?php echo $this->API->modules('bottom4'); ?>" />
    	</div>
    </section>
    <?php endif; ?>
    
    <?php if($this->API->modules('bottom5')) : ?>
    <section id="gkBottom5" class="gkPage">
    	<div class="gkCols6<?php if($this->API->modules('bottom5') > 1) : ?> gkNoMargin<?php endif; ?>">
    		<jdoc:include type="modules" name="bottom5" style="<?php echo $this->module_styles['bottom5']; ?>" modnum="<?php echo $this->API->modules('bottom5'); ?>" />
    	</div>
    </section>
    <?php endif; ?>
 
     <?php if($this->API->modules('weather')) : ?>
    <section id="gkWeather" class="gkPage">
    	<div class="gkCols6<?php if($this->API->modules('weather') > 1) : ?> gkNoMargin<?php endif; ?>">
    		<jdoc:include type="modules" name="weather" style="<?php echo $this->module_styles['weather']; ?>" modnum="<?php echo $this->API->modules('weather'); ?>" />
    	</div>
    </section>
    <?php endif; ?>
	
    <?php if($this->API->modules('lang')) : ?>
    <section id="gkLang">
    	<div class="gkPage">
         	<jdoc:include type="modules" name="lang" style="<?php echo $this->module_styles['lang']; ?>" />
         </div>
    </section>
    <?php endif; ?>
    
    <?php $this->layout->loadBlock('footer'); ?>
   	<?php $this->layout->loadBlock('social'); ?>
   		
	<jdoc:include type="modules" name="debug" />
	<script>
	jQuery(document).ready(function(){
   		// Target your .container, .wrapper, .post, etc.
   		jQuery("body").fitVids();
	});
	</script>
</body>
</html>