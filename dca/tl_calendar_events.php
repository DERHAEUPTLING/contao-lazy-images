<?php

/**
 * Lazy Images for Contao Open Source CMS
 *
 * @copyright  DerHaeuptling 2016
 * @author     Martin Schwenzer <mail@derhaeuptling.com>
 * @author     Sebastijan Ribaric <sebastijan.ribaric@media-8.org>
 * @package    Lazy Images
 * @license    http://opensource.org/licenses/lgpl-3.0.html 
 */

/**
 * Table tl_article
 */
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['lazyDisable'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['lazyDisable'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('tl_class'=>'w50 m12'),
	'sql'                     => "char(1) NOT NULL default ''"
);

// Subpalettes
$GLOBALS['TL_DCA']['tl_calendar_events']['subpalettes']['addImage'] = str_replace(',floating', ',floating,lazyDisable', $GLOBALS['TL_DCA']['tl_calendar_events']['subpalettes']['addImage']);

