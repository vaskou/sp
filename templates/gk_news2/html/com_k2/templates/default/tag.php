<?php

/**
 * @package		K2
 * @author		GavickPro http://gavick.com
 */

// no direct access
defined('_JEXEC') or die;

?>

<section id="k2Container" class="itemListView genericView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">
    <?php if($this->params->get('show_page_title')): ?>
    <header>
        <h1><?php echo $this->escape($this->params->get('page_title')); ?></h1>
    </header>
    <?php endif; ?>
    <?php if(count($this->items)): ?>
    <section class="itemList">
        <div id="itemListLeading">
            <?php foreach($this->items as $key => $item): ?>
            <div class="itemListRow gkListCols1">
                <div class="itemContainer">
                    <div class="itemsContainerWrap">
                        <article class="itemView sp-news-item">
                            <div class="itemBlock">
                                <?php if($item->params->get('genericItemImage') && !empty($item->imageGeneric)): ?>
                                	<div class="itemImageBlock"> <a class="itemImage" href="<?php echo $item->link; ?>" title="<?php if(!empty($item->image_caption)) echo $item->image_caption; else echo $item->title; ?>"> <img src="<?php echo $item->imageGeneric; ?>" alt="<?php if(!empty($item->image_caption)) echo $item->image_caption; else echo $item->title; ?>" style="width:<?php echo $item->params->get('itemImageGeneric'); ?>px; height:auto;" /> </a> </div>
                                <?php else:?>
                                	<div class="itemImageBlock"> <a class="itemImage" href="<?php echo $item->link; ?>" title="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"> <img src="<?php echo JRoute::_('images/noimage-180x150.png'); ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>" style="width:<?php echo $item->imageWidth; ?>px; height:auto;" /> </a> </div>
                                <?php endif; ?>
                                <div class="sp-news-item-content">
                                    <header>
                                        <?php if($item->params->get('genericItemTitle')): ?>
                                        <h2>
                                            <?php if ($item->params->get('genericItemTitleLinked')): ?>
                                            <a href="<?php echo $item->link; ?>"> <?php echo $item->title; ?> </a>
                                            <?php else: ?>
                                            <?php echo $item->title; ?>
                                            <?php endif; ?>
                                        </h2>
                                        <?php endif; ?>
                                    </header>
                                    <div class="itemBody<?php if(!$item->params->get('genericItemDateCreated')): ?> nodate<?php endif; ?>">
                                        <?php if($item->params->get('genericItemIntroText')): ?>
                                        <?php $item->introtext = K2HelperUtilities::wordLimit($item->introtext, $item->params->get('catItemIntroTextWordLimit'));?>
                                        <div class="itemIntroText"> <?php echo $item->introtext; ?> </div>
                                        <?php endif; ?>
                                        <?php if($item->params->get('genericItemExtraFields') && count($item->extra_fields)): ?>
                                        <div class="itemExtraFields">
                                            <h4><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h4>
                                            <ul>
                                                <?php foreach ($item->extra_fields as $key=>$extraField): ?>
                                                <?php if($extraField->value != ''): ?>
                                                <li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
                                                    <?php if($extraField->type == 'header'): ?>
                                                    <h4 class="tagItemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
                                                    <?php else: ?>
                                                    <span class="tagItemExtraFieldsLabel"><?php echo $extraField->name; ?></span> <span class="tagItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
                                                    <?php endif; ?>
                                                </li>
                                                <?php endif; ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if ($item->params->get('catItemReadMore')): ?>
                                    <!-- Item "read more..." link -->
                                    <div class="catItemReadMore"> <a class="k2ReadMore" href="<?php echo $this->item->link; ?>"> <?php echo JText::_('K2_READ_MORE'); ?> </a> </div>
                                    <?php endif; ?>
                                </div>
                                <div class="sp-news-item-info">
                                    <?php if($item->params->get('genericItemCategory')): ?>
                                    <ul>
                                        <?php if($item->params->get('genericItemDateCreated')): ?>
                                        <li>
                                            <time datetime="<?php echo JHtml::_('date', $item->created, JText::_(DATE_W3C)); ?>"><?php echo JHTML::_('date', $item->created, 'F j, Y'); ?></time>
                                        </li>
                                        <?php endif; ?>
                                        <?php if($item->params->get('genericItemCategory')) : ?>
                                        <li class="sp-news-item-info-category"><span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span> <a href="<?php echo $item->category->link; ?>"><?php echo $item->category->name; ?></a></li>
                                        <?php endif; ?>
                                        <?php if($item->params->get('catItemAuthor')): ?>
                                        <li>
                                            <?php
												$author = JFactory::getUser($item->created_by);
												$item->author = $author;
												$item->author->link = JRoute::_(K2HelperRoute::getUserRoute($item->created_by));
												$item->author->profile = K2ModelItem::getUserProfile($item->created_by);
											?>
                                            <?php $author_name = SpoudazoLibrary::getCustomAuthorName($item->author);?>
                                            <?php echo K2HelperUtilities::writtenBy($item->author->profile->gender); ?>
                                            <?php if(isset($item->author->link) && $item->author->link): ?>
                                            	<a rel="author" href="<?php echo $item->author->link; ?>"><?php echo $author_name; ?></a>
                                            <?php else: ?>
                                            	<?php echo $author_name; ?>
                                            <?php endif; ?>
                                        </li>
                                        <?php endif; ?>
                                    </ul>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php if($this->params->get('tagFeedIcon',1)): ?>
    <a class="k2FeedIcon" href="<?php echo $this->feed; ?>"><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></a>
    <?php endif; ?>
    <?php if($this->pagination->getPagesLinks()): ?>
    <?php echo str_replace('</ul>', '<li class="counter">'.$this->pagination->getPagesCounter().'</li></ul>', $this->pagination->getPagesLinks()); ?>
    <?php endif; ?>
    <?php endif; ?>
</section>
