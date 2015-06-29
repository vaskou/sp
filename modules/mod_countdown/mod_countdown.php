<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_whosonline
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the whosonline functions only once
require_once __DIR__ . '/helper.php';

$document = JFactory::getDocument();
$document->addStyleSheet(JUri::base().'modules/mod_countdown/assets/css/main.css');
$document->addStyleSheet(JUri::base().'modules/mod_countdown/assets/css/custom.css');
$document->addStyleSheet(JUri::base().'modules/mod_countdown/assets/css/fonts.css');
$document->addScript(JUri::base().'modules/mod_countdown/assets/js/counteverest.js');

ModCountdownHelper::set_variables($params);

require JModuleHelper::getLayoutPath('mod_countdown', $params->get('layout', 'default'));