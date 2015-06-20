<?php

/**
 * @package		K2
 * @author		GavickPro http://gavick.com
 */

// no direct access
defined('_JEXEC') or die;

?>

<article class="itemView">
	<?php echo $this->item->event->BeforeDisplay; ?>
	<?php echo $this->item->event->K2BeforeDisplay; ?>
	
	<?php if($this->item->params->get('latestItemImage') && !empty($this->item->image)): ?>
	<div class="itemImageBlock">
	   	<a class="itemImage" href="<?php echo $this->item->link; ?>" title="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>">
			<img src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>" style="width:<?php echo $this->item->imageWidth; ?>px;height:auto;" />
		</a>
	</div>
	<?php endif; ?>
	
	<div class="itemBlock">
		<header>
			<?php if($this->item->params->get('latestItemTitle')): ?>
			<h2>
				<?php if ($this->item->params->get('latestItemTitleLinked')): ?>
					<a href="<?php echo $this->item->link; ?>"><?php echo $this->item->title; ?></a>
				<?php else: ?>
					<?php echo $this->item->title; ?>
				<?php endif; ?>
			</h2>
			<?php endif; ?>
	  	</header>
	
	  	<?php echo $this->item->event->AfterDisplayTitle; ?>
	  	<?php echo $this->item->event->K2AfterDisplayTitle; ?>
	
	  	<div class="itemBody<?php if(!$this->item->params->get('latestItemDateCreated')): ?> nodate<?php endif; ?>">
			<?php echo $this->item->event->BeforeDisplayContent; ?>
		  	<?php echo $this->item->event->K2BeforeDisplayContent; ?>
	
		  	<?php if($this->item->params->get('latestItemIntroText')): ?>
		  	<div class="itemIntroText">
		  		<?php echo $this->item->introtext; ?>
		  	</div>
		  	<?php endif; ?>
	
		  	<?php echo $this->item->event->AfterDisplayContent; ?>
		  	<?php echo $this->item->event->K2AfterDisplayContent; ?>
	  	</div>
	  	
	  	<?php if($this->item->params->get('latestItemCategory') || ($this->item->params->get('latestItemCommentsAnchor') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1')))): ?>
		<ul>
			<?php if($this->item->params->get('latestItemDateCreated')): ?>
	  		<li><time datetime="<?php echo JHtml::_('date', $this->item->created, JText::_(DATE_W3C)); ?>"><?php echo JHTML::_('date', $this->item->created, 'F j, Y'); ?></time></li>
	  		<?php endif; ?>

	  		<?php if($this->item->params->get('latestItemCategory')): ?>
	  		<li><span><?php echo JText::_('K2_PUBLISHED_IN'); ?> </span><a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a></li>
	  		<?php endif; ?>
	  	
	  		<?php if($this->item->params->get('latestItemCommentsAnchor') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1'))): ?>
	  		<li>
	  			<i class="fa fa-comments"></i>
	  			<?php if(!empty($this->item->event->K2CommentsCounter)): ?>
	  			<?php echo $this->item->event->K2CommentsCounter; ?>
	  			<?php else: ?>
	  			<a href="<?php echo $this->item->link; ?>#itemCommentsAnchor"><?php echo $this->item->numOfComments; ?></a>
	  			<?php endif; ?>
	  		</li>
	  		<?php endif; ?>
	  	</ul>
	  	<?php endif; ?>
	</div>
	
	<?php echo $this->item->event->AfterDisplay; ?>
  	<?php echo $this->item->event->K2AfterDisplay; ?>
</article>