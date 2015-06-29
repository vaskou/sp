<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_whosonline
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$theme =$params->get('theme','1');
$title = $params->get('title');
$subtitle = $params->get('subtitle');
$link = $params->get('link','#');
?>
<div class="example example--bars">
	<a href="<?php echo $link;?>" class="ce-link">
    <div class="ce-countdown ce-countdown--theme-<?php echo $theme; ?> ce-clearfix">
        <div class="ce-text">
            <h3><?php echo $title;?></h3>
            <h5><?php echo $subtitle;?></h5>
        </div>
        <div class="ce-info ce-clearfix">
            <div class="ce-bar ce-bar-days"><div class="ce-fill" style="width: 96.4383561643836%;"></div></div> 
            <div class="ce-number ce-number-days">
                <span class="ce-days">
                    <span class="ce-days-digit"></span>
                    <span class="ce-days-digit"></span>        
                </span>
                <span class="ce-days-label"></span>
            </div>
            
            
            <div class="ce-bar ce-bar-hours"><div class="ce-fill" style="width: 100%;"></div></div> 
            <div class="ce-number">
                <span class="ce-hours">
                    <span class="ce-hours-digit"></span>
                    <span class="ce-hours-digit"></span>
                </span>
                
                <span class="ce-hours-label"></span>
            </div>
            <div class="ce-comma">:</div>
            
            <div class="ce-bar ce-bar-minutes"><div class="ce-fill" style="width: 80%;"></div></div> 
            <div class="ce-number">
                <span class="ce-minutes">
                    <span class="ce-minutes-digit"></span>
                    <span class="ce-minutes-digit"></span>
                </span>
                
                <span class="ce-minutes-label"></span>
            </div>
            <div class="ce-comma">:</div>
             
            <div class="ce-bar ce-bar-seconds"><div class="ce-fill" style="width: 75%;"></div></div> 
            <div class="ce-number">
                <span class="ce-seconds">
                    <span class="ce-seconds-digit"></span>
                    <span class="ce-seconds-digit"></span>
                </span>
                <span class="ce-seconds-label"></span>
            </div>
        </div>
    
    </div>
    </a>
</div>
<?php  ?>