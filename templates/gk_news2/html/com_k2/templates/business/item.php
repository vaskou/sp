<?php

/**
 * @package		K2
 * @author		GavickPro http://gavick.com
 */

// no direct access
defined('_JEXEC') or die;

// Code used to generate the page elements
$params = $this->item->params;
$k2ContainerClasses = (($this->item->featured) ? ' itemIsFeatured' : '') . ($params->get('pageclass_sfx')) ? ' '.$params->get('pageclass_sfx') : ''; 
$k2ContainerClasses .= ' '.basename(__DIR__); 

$app = JFactory::getApplication();
$tpl = $app->getTemplate(true);
$tpl_params = $tpl->params;
$inset_position = $tpl_params->get('inset_position', 'right');
$fblang   = $tpl_params->get('fb_lang', 'en_US');
$aside_exists = false;

if(
	$params->get('itemFontResizer') ||
	$params->get('itemPrintButton') ||
	$params->get('itemEmailButton') ||
	$params->get('itemSocialButton') ||
	$params->get('itemVideoAnchor') ||
	$params->get('itemImageGalleryAnchor') ||
	$params->get('itemHits') ||
	$params->get('itemRating') ||
	$params->get('itemTwitterButton', 1) || 
	$params->get('itemFacebookButton', 1) || 
	$params->get('itemGooglePlusOneButton', 1)
) {
	$aside_exists = true;
}

?>
<?php if(JRequest::getInt('print')==1): ?>

<a class="itemPrintThisPage" rel="nofollow" href="#" onclick="window.print(); return false;"> <?php echo JText::_('K2_PRINT_THIS_PAGE'); ?> </a>
<?php endif; ?>
<article id="k2Container" class="itemView<?php echo $k2ContainerClasses; ?>"> 
		<?php echo $this->item->event->BeforeDisplay; ?> 
		<?php echo $this->item->event->K2BeforeDisplay; ?>
         
         <?php if(
         	$params->get('itemTitle') ||
         	(
         		$this->item->params->get('itemDateCreated') ||
         		$params->get('itemAuthor') ||
         		$params->get('itemCategory') ||
         		$params->get('itemComments') ||
         		(
         			$params->get('itemCommentsAnchor') && 
         			$params->get('itemComments') && 
         			( 
         				(
         					$params->get('comments') == '2' && 
         					!$this->user->guest
         				) || 
         				$params->get('comments') == '1'
         			)
         		)
         	)
         ): ?>
         <header>
            <?php if($params->get('itemImage') && !empty($this->item->image)): ?>
              <div class="itemImageBlock"> 
                <?php if($params->get('itemFeaturedNotice') && $this->item->featured): ?>
                <sup><?php echo JText::_('K2_FEATURED'); ?></sup>
                <?php endif; ?>
                <a class="itemImage modal" rel="{handler: 'image'}" href="<?php echo $this->item->imageXLarge; ?>" title="<?php echo JText::_('K2_CLICK_TO_PREVIEW_IMAGE'); ?>"> <img src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>" style="width:<?php echo $this->item->imageWidth; ?>px; height:auto;" /> </a>
                <?php if($params->get('itemImageMainCredits') && !empty($this->item->image_credits)): ?>
                <span class="itemImageCredits"><?php echo $this->item->image_credits; ?></span>
                <?php endif; ?>
                <?php if($params->get('itemImageMainCaption') && !empty($this->item->image_caption)): ?>
                <span class="itemImageCaption"><?php echo $this->item->image_caption; ?></span>
                <?php endif; ?>
              </div>
            <?php endif; ?>
                   <?php if(isset($this->item->editLink)): ?>
                   <a class="itemEditLink modal" rel="{handler:'iframe',size:{x:990,y:550}}" href="<?php echo $this->item->editLink; ?>"><?php echo JText::_('K2_EDIT_ITEM'); ?></a>
                   <?php endif; ?>
                   <?php if($params->get('itemTitle')): ?>
                   <h1><?php echo $this->item->title; ?></h1>
                   <?php endif; ?>
                   
                   <?php if(
                   			$this->item->params->get('itemDateCreated') ||
                   			$params->get('itemAuthor') ||
                   			$params->get('itemCategory') ||
                   			$params->get('itemComments') ||
                   			(
                   				$params->get('itemCommentsAnchor') && 
                   				$params->get('itemComments') && 
                   				( 
                   					(
                   						$params->get('comments') == '2' && 
                   						!$this->user->guest
                   					) || 
                   					$params->get('comments') == '1'
                   				)
                   			) 
                   		 ): 
                   	?>
                   <ul>
	                   	 <?php if($params->get('itemCategory')): ?>
	                   	 <li><span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span> <a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a></li>
	                   	 <?php endif; ?>
	                   	 
	                   	 <?php if($params->get('itemCommentsAnchor') && $params->get('itemComments') && ( ($params->get('comments') == '2' && !$this->user->guest) || ($params->get('comments') == '1')) ): ?>
	                   	 <li class="itemComments">
	                   	 	<?php if(!empty($this->item->event->K2CommentsCounter)): ?>
	                   	 		<?php echo $this->item->event->K2CommentsCounter; ?>
	                   	 	<?php else: ?>
                   	 			<a class="itemCommentsLink k2Anchor" href="<?php echo $this->item->link; ?>#itemCommentsAnchor"><span><?php echo $this->item->numOfComments; ?></span> <?php echo ($this->item->numOfComments > 1 || $this->item->numOfComments == 0) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?></a>
                   	 		<?php endif; ?>
	                   	 </li>
	                   	 <?php endif; ?>
                   </ul>
                   <?php endif; ?>
         </header>
         <?php endif; ?>
         
         <div class="itemBodyWrap">
         
          <div class="itemBody<?php if($aside_exists): ?> gkHasAside<?php endif; ?>"> 
          		<?php echo $this->item->event->BeforeDisplayContent; ?> 
          		<?php echo $this->item->event->K2BeforeDisplayContent; ?> 
                    
                    <?php echo $this->item->event->AfterDisplayTitle; ?> 
                    <?php echo $this->item->event->K2AfterDisplayTitle; ?>
                    
                    <?php if(!empty($this->item->fulltext)): ?>
                    <?php if($params->get('itemIntroText')): ?>
                    <div class="itemIntroText"> <?php echo $this->item->introtext; ?> </div>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if($params->get('itemFullText')): ?>
                    <div class="itemFullText"> <?php echo (!empty($this->item->fulltext)) ? $this->item->fulltext : $this->item->introtext; ?> </div>
                    <?php endif; ?>
                    

 
                    <?php if($params->get('itemExtraFields') && count($this->item->extra_fields)): ?>
                    <div class="itemExtraFields">
							<ul>
							<?php foreach ($this->item->extra_fields as $key=>$extraField): ?>
			
							<?php if($extraField->value != ''): ?>
							<li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?> alias-<?php echo $extraField->alias; ?>">
									  <?php if($extraField->type == 'header'): ?>
									       <h4 class="itemExtraFieldsHeader"><?php echo $extraField->name; ?></h4>
									  <?php else: ?>
											<?php if($extraField->alias != 'iframeurl' && strpos($extraField->alias,'address_')===false && strpos($extraField->alias,'telephone_')===false): ?>
												 <span class="itemExtraFieldsLabel"><?php echo $extraField->name; ?>:</span> <span class="itemExtraFieldsValue"><?php echo $extraField->value; ?></span>
											<?php endif; ?>
											<?php if($extraField->alias == 'iframeurl'): ?>
												 <?php $iframeurlField = $extraField ;?>
												 <?php continue;?>
											<?php endif; ?>
											<?php if($extraField->alias == 'address'): ?>
												 <?php $addressField = $extraField ;?>
											<?php endif; ?>
                                            <?php if(strpos($extraField->alias,'address_')!==false): ?>
                                                <?php $addresses[] = $extraField;?>
                                                <span class="itemExtraFieldsLabel"><?php echo $extraField->name; ?>:</span> <span class="itemExtraFieldsValue">
                                                    <a href="#<?php echo $extraField->alias; ?>" class="modal"><?php echo $extraField->value; ?></a>
                                                </span>
                                            <?php endif; ?>    
                                            <?php if(strpos($extraField->alias,'telephone_')!==false): ?>
                                                <span class="itemExtraFieldsLabel"><?php echo $extraField->name; ?>:</span> <span class="itemExtraFieldsValue">
                                                    <?php echo $extraField->value; ?>
                                                </span>
                                             <?php endif; ?>
										<?php endif; ?>
							</li>
							<?php endif; ?>
							<?php endforeach; ?>
							</ul>
                    </div>
                    <?php endif; ?>
                    
					<?php if($params->get('itemVideo') && !empty($this->item->video)): ?>
                    <div class="itemVideoBlock" id="itemVideoAnchor" style="text-align:left">
                              <h3><?php echo JText::_('VIDEO'); ?></h3>
                              <?php if($this->item->videoType=='embedded'): ?>
                              <div class="itemVideoEmbedded"> <?php echo $this->item->video; ?> </div>
                              <?php else: ?>
                              <span class="itemVideo"><?php echo $this->item->video; ?></span>
                              <?php endif; ?>
                              <?php if($params->get('itemVideoCaption') && !empty($this->item->video_caption)): ?>
                              <span class="itemVideoCaption"><?php echo $this->item->video_caption; ?></span>
                              <?php endif; ?>
                              <?php if($params->get('itemVideoCredits') && !empty($this->item->video_credits)): ?>
                              <span class="itemVideoCredits"><?php echo $this->item->video_credits; ?></span>
                              <?php endif; ?>
                    </div>
                    <?php endif; ?>

					<?php if ($addressField && trim ( $addressField->value )!='' ) : ?>

					<div class="address_field embed-container">
						<iframe
						  width="600"
						  height="450"
						  frameborder="0" style="border:0"
						  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCGMxeMcTmXMoV-ck4otVAY88TmnvvRxrI&q=<?php echo trim ( $addressField->value );?>">
						</iframe>
					</div>
					<?php endif;?>
          
          <?php if($addresses):?>
            <?php foreach($addresses as $key=>$address): ?>
              <?php if ($address && trim ( $address->value )!='' ) : ?>
              <div style="display:none;">
      					<div class="address_field embed-container" id="<?php echo $address->alias; ?>">
      						<iframe
      						  width="600"
      						  height="450"
      						  frameborder="0" style="border:0"
      						  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCGMxeMcTmXMoV-ck4otVAY88TmnvvRxrI&q=<?php echo trim ( $address->value );?>">
      						</iframe>
      					</div>
              </div>
    					<?php endif;?>
            <?php endforeach; ?>
          <?php endif;?>
					
					
					<?php if ($iframeurlField) : ?>
					<div class="iframeurl_field fieldContainer">
						<iframe style="border:0; width:100%;max-width: 100%; height:600px" src="<?php echo $iframeurlField->value; ?>"></iframe>
					</div>
					<?php endif;?>
					
					<?php echo $this->item->event->AfterDisplayContent; ?> <?php echo $this->item->event->K2AfterDisplayContent; ?>
					
                    <?php if(
						$params->get('itemTags') ||
						$params->get('itemAttachments')
					): ?>
                    <div class="itemLinks">
                              <?php if($params->get('itemAttachments') && count($this->item->attachments)): ?>
                              <div class="itemAttachmentsBlock"> <span><?php echo JText::_('K2_DOWNLOAD_ATTACHMENTS'); ?></span>
                                        <ul class="itemAttachments">
                                                  <?php foreach ($this->item->attachments as $attachment): ?>
                                                  <li> <a title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>"><?php echo $attachment->title; ?>
                                                            <?php if($params->get('itemAttachmentsCounter')): ?>
                                                            <span>(<?php echo $attachment->hits; ?> <?php echo ($attachment->hits==1) ? JText::_('K2_DOWNLOAD') : JText::_('K2_DOWNLOADS'); ?>)</span>
                                                            <?php endif; ?>
                                                            </a> </li>
                                                  <?php endforeach; ?>
                                        </ul>
                              </div>
                              <?php endif; ?>
                              <?php if($params->get('itemTags') && count($this->item->tags)): ?>
                              <div class="itemTagsBlock"> <span><?php echo JText::_('K2_TAGGED_UNDER'); ?></span>
                                        <ul class="itemTags">
                                                  <?php foreach ($this->item->tags as $tag): ?>
                                                  <li> <a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a> </li>
                                                  <?php endforeach; ?>
                                        </ul>
                              </div>
                              <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php if(
                    	(
                    		$params->get('itemRelated') && isset($this->relatedItems)
                    	) ||
                    	(
                    		$params->get('itemAuthorLatest') && 
                    		empty($this->item->created_by_alias) && 
                    		isset($this->authorLatestItems)
                    	)
                    ): ?>
                    <div class="itemAuthorContent">
                      <?php if($params->get('itemRelated') && isset($this->relatedItems)): ?>
                       <div>
                              <h3><?php echo JText::_("K2_RELATED_ITEMS_BY_TAG"); ?></h3>
                              <ul>
                                        <?php foreach($this->relatedItems as $key=>$item): ?>
                                        <li> 
					
					<?php if($this->item->params->get('itemRelatedImageSize')): ?>
					<a class="itemRelImageWrap" href="<?php echo $item->link ?>"><img style="width:<?php echo $item->imageWidth; ?>px;height:auto;" class="itemRelImg" src="<?php echo $item->image; ?>" alt="<?php K2HelperUtilities::cleanHtml($item->title); ?>" /></a>
				<?php endif; ?>
					<?php if($this->item->params->get('itemRelatedTitle', 1)): ?>
				<a class="itemRelTitle" href="<?php echo $item->link ?>"><?php echo $item->title; ?></a>
				<?php endif; ?>

				<?php if($this->item->params->get('itemRelatedCategory')): ?>
				<div class="itemRelCat"><?php echo JText::_("K2_IN"); ?> <a href="<?php echo $item->category->link ?>"><?php echo $item->category->name; ?></a></div>
				<?php endif; ?>

				<?php if($this->item->params->get('itemRelatedAuthor')): ?>
				<div class="itemRelAuthor"><?php echo JText::_("K2_BY"); ?> <a rel="author" href="<?php echo $item->author->link; ?>"><?php echo SpoudazoLibrary::getCustomAuthorName($this->item->author); ?></a></div>
				<?php endif; ?>

				

				<?php if($this->item->params->get('itemRelatedIntrotext')): ?>
				<div class="itemRelIntrotext"><?php echo $item->introtext; ?></div>
				<?php endif; ?>

				<?php if($this->item->params->get('itemRelatedFulltext')): ?>
				<div class="itemRelFulltext"><?php echo $item->fulltext; ?></div>
				<?php endif; ?>

				<?php if($this->item->params->get('itemRelatedMedia')): ?>
				<?php if($item->videoType=='embedded'): ?>
				<div class="itemRelMediaEmbedded"><?php echo $item->video; ?></div>
				<?php else: ?>
				<div class="itemRelMedia"><?php echo $item->video; ?></div>
				<?php endif; ?>
				<?php endif; ?>

				<?php if($this->item->params->get('itemRelatedImageGallery')): ?>
				<div class="itemRelImageGallery"><?php echo $item->gallery; ?></div>
				<?php endif; ?>
			      </li> 
                                        <?php endforeach; ?>
                            </ul>
                       </div>
                    <?php endif; ?>
                    
                    <?php if($params->get('itemAuthorLatest') && empty($this->item->created_by_alias) && isset($this->authorLatestItems)): ?>
                        <div>
                              <?php if($params->get('itemAuthorLatest') && empty($this->item->created_by_alias) && isset($this->authorLatestItems)): ?>
                              <h3><?php echo JText::_('K2_LATEST_FROM'); ?> <?php echo SpoudazoLibrary::getCustomAuthorName($this->item->author); ?></h3>
                              <ul>
                                        <?php foreach($this->authorLatestItems as $key=>$item): ?>
                                        <li> <a href="<?php echo $item->link ?>"><?php echo $item->title; ?></a> </li>
                                        <?php endforeach; ?>
                              </ul>
                              <?php endif; ?>
                        </div>
                      <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($params->get('itemImageGallery') && !empty($this->item->gallery)): ?>
                    <div class="itemImageGallery" id="itemImageGalleryAnchor">
                              <h3><?php echo JText::_('K2_IMAGE_GALLERY'); ?></h3>
                              <?php echo $this->item->gallery; ?> </div>
                    <?php endif; ?>
                    
                   
                    <?php echo $this->item->event->AfterDisplay; ?> 
                    <?php echo $this->item->event->K2AfterDisplay; ?> </div>
          
          <?php if($aside_exists): ?>
          <aside class="itemAsideInfo"> 
              <ul>
                        <?php if($params->get('itemTwitterButton',1) || $params->get('itemFacebookButton',1) || $params->get('itemGooglePlusOneButton',1)): ?>
                        <div class="itemSocialSharing">
                            <?php if($params->get('itemTwitterButton',1)): ?>
                            <div class="itemTwitterButton"> <a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical"<?php if($params->get('twitterUsername')): ?> data-via="<?php echo $params->get('twitterUsername'); ?>"<?php endif; ?>><?php echo JText::_('K2_TWEET'); ?></a> 
                                      <script type="text/javascript" src="//platform.twitter.com/widgets.js"></script> 
                            </div>
                            <?php endif; ?>
                                          
                            <?php if($params->get('itemFacebookButton',1)): ?>
                            <div class="itemFacebookButton"> 
                              <script type="text/javascript">                                                         
                              window.addEvent('load', function(){
                        			(function(){
                                    	if(document.id('fb-auth') == null) {
                                    		var root = document.createElement('div');
                                    		root.id = 'fb-root';
                                    		$$('.itemFacebookButton')[0].appendChild(root);
                                    			(function(d, s, id) {
                                      			var js, fjs = d.getElementsByTagName(s)[0];
                                      			if (d.getElementById(id)) {return;}
                                      			js = d.createElement(s); js.id = id;
                                      			js.src = document.location.protocol + "//connect.facebook.net/<?php echo $fblang; ?>/all.js#xfbml=1";
                                      			fjs.parentNode.insertBefore(js, fjs);
                                    			}(document, 'script', 'facebook-jssdk')); 
                                			}
                              		}());
                          		});
                        		</script>
                              <div class="fb-like" data-send="true" data-layout="box_count"> </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if($params->get('itemGooglePlusOneButton',1)): ?>
                            <div class="itemGooglePlusOneButton">
                              <div class="g-plusone" data-size="tall"></div>
                              
                              <script type="text/javascript">
                                window.___gcfg = {lang: 'en'};
                              
                                (function() {
                                  var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                  po.src = 'https://apis.google.com/js/platform.js';
                                  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                })();
                              </script>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                        
                        
                        <?php if($params->get('itemHits')): ?>
                        <li><i class="gk-icon-views"></i><?php echo JText::_('K2_READ'); ?> <?php echo $this->item->hits; ?>  </li>
                        <?php endif; ?>
                        <?php if($params->get('itemFontResizer')): ?>
                        <li class="itemResizer"> <span><?php echo JText::_('K2_FONT_SIZE'); ?></span> <a href="#" id="fontDecrease"><?php echo JText::_('K2_DECREASE_FONT_SIZE'); ?></a> <a href="#" id="fontIncrease"><?php echo JText::_('K2_INCREASE_FONT_SIZE'); ?></a></li>
                        <?php endif; ?>
                        <?php if($params->get('itemPrintButton') && !JRequest::getInt('print')): ?>
                        <li class="itemPrint"><i class="gk-icon-print"></i> <a rel="nofollow" href="<?php echo $this->item->printLink; ?>" onclick="window.open(this.href,'printWindow','width=900,height=600,location=no,menubar=no,resizable=yes,scrollbars=yes'); return false;"><?php echo JText::_('K2_PRINT'); ?></a></li>
                        <?php endif; ?>
                        <?php if($params->get('itemEmailButton') && !JRequest::getInt('print')): ?>
                        <li class="itemEmail"><i class="gk-icon-email"></i><a rel="nofollow" href="<?php echo $this->item->emailLink; ?>" onclick="window.open(this.href,'emailWindow','width=400,height=350,location=no,menubar=no,resizable=no,scrollbars=no'); return false;"><?php echo JText::_('K2_EMAIL'); ?></a></li>
                        <?php endif; ?>
                        <?php if($params->get('itemSocialButton') && !is_null($params->get('socialButtonCode', NULL))): ?>
                        <li class="itemSocial"><?php echo $params->get('socialButtonCode'); ?></li>
                        <?php endif; ?>
                        <?php if($params->get('itemVideoAnchor') && !empty($this->item->video)): ?>
                        <li class="itemVideo"> <a class="k2Anchor" href="<?php echo $this->item->link; ?>#itemVideoAnchor"><?php echo JText::_('K2_MEDIA'); ?></a> </li>
                        <?php endif; ?>
                        <?php if($params->get('itemImageGalleryAnchor') && !empty($this->item->gallery)): ?>
                        <li class="itemGallery"> <a class="k2Anchor" href="<?php echo $this->item->link; ?>#itemImageGalleryAnchor"><?php echo JText::_('K2_IMAGE_GALLERY'); ?></a> </li>
                        <?php endif; ?>
                  
                        <?php if($params->get('itemRating')): ?>
                        <li>
                            <div class="itemRatingBlock">
                                  <div class="itemRatingForm">
                                        <ul class="itemRatingList">
                                              <li class="itemCurrentRating" id="itemCurrentRating<?php echo $this->item->id; ?>" style="width:<?php echo $this->item->votingPercentage; ?>%;"></li>
                                              <li> <a href="#" data-id="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_1_STAR_OUT_OF_5'); ?>" class="one-star">1</a> </li>
                                              <li> <a href="#" data-id="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_2_STARS_OUT_OF_5'); ?>" class="two-stars">2</a> </li>
                                              <li> <a href="#" data-id="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_3_STARS_OUT_OF_5'); ?>" class="three-stars">3</a> </li>
                                              <li> <a href="#" data-id="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_4_STARS_OUT_OF_5'); ?>" class="four-stars">4</a> </li>
                                              <li> <a href="#" data-id="<?php echo $this->item->id; ?>" title="<?php echo JText::_('K2_5_STARS_OUT_OF_5'); ?>" class="five-stars">5</a> </li>
                                        </ul>
                                        <div id="itemRatingLog<?php echo $this->item->id; ?>" class="itemRatingLog"> <?php echo $this->item->numOfvotes; ?> </div>
                                  </div>
                            </div>
                        </li>
                        <?php endif; ?>
              </ul>
          </aside>
          <?php endif; ?>
          
          </div>
          
           <?php if($params->get('itemNavigation') && !JRequest::getCmd('print') && (isset($this->item->nextLink) || isset($this->item->previousLink))): ?>
                    <div class="itemNavigation"> <span><?php echo JText::_('K2_MORE_IN_THIS_CATEGORY'); ?></span>
                              <?php if(isset($this->item->previousLink)): ?>
                              <a class="itemPrevious" href="<?php echo $this->item->previousLink; ?>">&laquo; <?php echo $this->item->previousTitle; ?></a>
                              <?php endif; ?>
                              <?php if(isset($this->item->nextLink)): ?>
                              <a class="itemNext" href="<?php echo $this->item->nextLink; ?>"><?php echo $this->item->nextTitle; ?> &raquo;</a>
                              <?php endif; ?>
                    </div>
                    <?php endif; ?>
          <?php if($params->get('itemComments') && ( ($params->get('comments') == '2' && !$this->user->guest) || ($params->get('comments') == '1'))):?>
          <?php echo $this->item->event->K2CommentsBlock; ?>
          <?php endif;?>
          <?php if($params->get('itemComments') && !JRequest::getInt('print') && ($params->get('comments') == '1' || ($params->get('comments') == '2')) && empty($this->item->event->K2CommentsBlock)):?>
          <div class="itemComments" id="itemCommentsAnchor">
                    <?php if($params->get('commentsFormPosition')=='above' && $params->get('itemComments') && !JRequest::getInt('print') && ($params->get('comments') == '1' || ($params->get('comments') == '2' && K2HelperPermissions::canAddComment($this->item->catid)))): ?>
                    <div class="itemCommentsForm"> <?php echo $this->loadTemplate('comments_form'); ?> </div>
                    <?php endif; ?>
                    <?php if($this->item->numOfComments>0 && $params->get('itemComments') && !JRequest::getInt('print') && ($params->get('comments') == '1' || ($params->get('comments') == '2'))): ?>
                    <h3> <?php echo $this->item->numOfComments; ?> <?php echo ($this->item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?> </h3>
                    <ul class="itemCommentsList">
                              <?php foreach ($this->item->comments as $key=>$comment): ?>
                              <li class="<?php echo ($key%2) ? "odd" : "even"; echo (!$this->item->created_by_alias && $comment->userID==$this->item->created_by) ? " authorResponse" : ""; echo($comment->published) ? '':' unpublishedComment'; ?>">
                                        <?php if($comment->userImage):?>
                                        <img src="<?php echo $comment->userImage; ?>" alt="<?php echo JFilterOutput::cleanText($comment->userName); ?>" width="<?php echo $params->get('commenterImgWidth'); ?>" />
                                        <?php endif; ?>
                                        <div> <span>
                                                  <?php if(!empty($comment->userLink)): ?>
                                                  <a href="<?php echo JFilterOutput::cleanText($comment->userLink); ?>" title="<?php echo JFilterOutput::cleanText($comment->userName); ?>" target="_blank" rel="nofollow"> <?php echo $comment->userName; ?> </a>
                                                  <?php else: ?>
                                                  <?php echo $comment->userName; ?>
                                                  <?php endif; ?>
                                                  </span> <span> <?php echo JHTML::_('date', $comment->commentDate, JText::_('DATE_FORMAT_LC2')); ?> </span> <span> <a class="commentLink" href="<?php echo $this->item->link; ?>#comment<?php echo $comment->id; ?>" name="comment<?php echo $comment->id; ?>" id="comment<?php echo $comment->id; ?>"> <?php echo JText::_('K2_COMMENT_LINK'); ?> </a> </span>
                                                  <?php if($this->inlineCommentsModeration || ($comment->published && ($this->params->get('commentsReporting')=='1' || ($this->params->get('commentsReporting')=='2' && !$this->user->guest)))): ?>
                                                  <span class="commentToolbar">
                                                  <?php if($this->inlineCommentsModeration): ?>
                                                  <?php if(!$comment->published): ?>
                                                  <a class="commentApproveLink" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=publish&commentID='.$comment->id.'&format=raw')?>"><?php echo JText::_('K2_APPROVE')?></a>
                                                  <?php endif;?>
                                                  <a class="commentRemoveLink" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=remove&commentID='.$comment->id.'&format=raw')?>"><?php echo JText::_('K2_REMOVE')?></a>
                                                  <?php endif;?>
                                                  <?php if($comment->published && ($this->params->get('commentsReporting')=='1' || ($this->params->get('commentsReporting')=='2' && !$this->user->guest))): ?>
                                                  <a class="commentReportLink modal" rel="{handler:'iframe',size:{x:640,y:480}}" href="<?php echo JRoute::_('index.php?option=com_k2&view=comments&task=report&commentID='.$comment->id)?>"><?php echo JText::_('K2_REPORT')?></a>
                                                  <?php endif; ?>
                                                  </span>
                                                  <?php endif; ?>
                                                  <p><?php echo $comment->commentText; ?></p>
                                        </div>
                              </li>
                              <?php endforeach; ?>
                    </ul>
                    <div> <?php echo $this->pagination->getPagesLinks(); ?> </div>
                    <?php endif; ?>
                    <?php if($params->get('commentsFormPosition')=='below' && $params->get('itemComments') && !JRequest::getInt('print') && ($params->get('comments') == '1' || ($params->get('comments') == '2' && K2HelperPermissions::canAddComment($this->item->catid)))): ?>
                    <h3> <?php echo JText::_('K2_LEAVE_A_COMMENT') ?> </h3>
                    <div class="itemCommentsForm"> <?php echo $this->loadTemplate('comments_form'); ?> </div>
                    <?php endif; ?>
                    <?php $user = JFactory::getUser(); if ($params->get('comments') == '2' && $user->guest):?>
                    <div> <?php echo JText::_('K2_LOGIN_TO_POST_COMMENTS');?> </div>
                    <?php endif; ?>
          </div>
          <?php endif; ?>
</article>
