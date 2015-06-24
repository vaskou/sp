<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_whosonline
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_whosonline
 *
 * @package     Joomla.Site
 * @subpackage  mod_whosonline
 * @since       1.5
 */
class ModCountdownHelper
{

    public function set_variables($params)
    {
        $datetime = $params->get('datetime');
        $not_needed = array(' ', ':','-');
        $needed   = array('/');
        $datetime =  str_replace($not_needed, $needed[0], $datetime);
        $datetime_arr = explode("/", $datetime);

        $script = array();

        $script[] = 'var day = "'.$datetime_arr[0].'";';
        $script[] = 'var month = "'.$datetime_arr[1].'";';
        $script[] = 'var year = "'.$datetime_arr[2].'";';

		$script[] = 'var daysLabel = "'.$params->get('daysLabel').'";';
		$script[] = 'var dayLabel = "'.$params->get('dayLabel').'";';
		$script[] = 'var hoursLabel = "'.$params->get('hoursLabel').'";';
		$script[] = 'var hourLabel = "'.$params->get('hourLabel').'";';
		$script[] = 'var minutesLabel = "'.$params->get('minutesLabel').'";';
		$script[] = 'var minuteLabel = "'.$params->get('minuteLabel').'";';
		$script[] = 'var secondsLabel = "'.$params->get('secondsLabel').'";';
		$script[] = 'var secondLabel = "'.$params->get('secondLabel').'";';

        /*$hour = $datetime_arr[3];
        if($datetime_arr[6] == "PM")
        {
            $hour = strval(intval($hour) + 12);
        }
        $script[] = 'var hour = "'.$hour.'";';
        $script[] = 'var minute = "'.$datetime_arr[4].'";';
        $script[] = 'var second = "'.$datetime_arr[5].'";';*/


		$script[]='
			function setCounterVariables()
			{
				variables = new Array(
					day,month,year,
					daysLabel,dayLabel,
					hoursLabel,hourLabel,
					minutesLabel,minuteLabel,
					secondsLabel,secondLabel
				);
				
				return variables;
			}
		';
		
        JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
		JFactory::getDocument()->addScript(JUri::base().'modules/mod_countdown/assets/js/main.js');
        return;
    }

}
