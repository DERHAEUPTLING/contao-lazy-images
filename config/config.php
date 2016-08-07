<?php

/**
 * LazyLoad for Contao Open Source CMS
 *
 * @copyright  DerHaeuptling 2016
 * @author     Martin Schwenzer <mail@derhaeuptling.com>
 * @author     Sebastijan Ribarić <sebastijan.ribaric@media-8.org>
 * @author     Kamil Kuzminski <kamil.kuzminski@codefog.pl>
 * @package    LazyLoad
 * @license    http://opensource.org/licenses/lgpl-3.0.html 
 */


if ('FE' === TL_MODE)
{
	$GLOBALS['TL_MOOTOOLS'][] = '<script src="system/modules/zz_lazy-images/assets/lazysizes-gh-pages/lazysizes.min.js" async></script>';
	
	$GLOBALS['TL_HOOKS']['parseTemplate'][] = array('\LazySizes', 'init');
}

/**
 * Content elements
 */
$GLOBALS['TL_CTE']['texts']['text'] = 'LazyContentText';
$GLOBALS['TL_CTE']['media']['image'] = 'LazyContentImage';
//$GLOBALS['TL_CTE']['media']['gallery'] = 'LazyContentGallery';