<?php

/**
 * Lazy Images for Contao Open Source CMS
 *
 * @copyright  DerHaeuptling 2017
 * @author     Martin Schwenzer <mail@derhaeuptling.com>
 * @author     Sebastijan Ribarić <sebastijan.ribaric@media-8.org>
 * @package    Lazy Images
 * @license    http://opensource.org/licenses/lgpl-3.0.html 
 */


if ('FE' === TL_MODE)
{
	$GLOBALS['TL_CSS'][] = 'system/modules/lazy-images/assets/css/custom.scss|static';	
	$GLOBALS['TL_HEAD'][] = '<script src="system/modules/lazy-images/assets/lazysizes/lazysizes.min.js" defer></script>';
	
	$GLOBALS['TL_HOOKS']['parseTemplate'][] = array('\LazySizes', 'init');
}

/**
 * Content elements
 */
$GLOBALS['TL_CTE']['texts']['text'] = 'LazyContentText';
$GLOBALS['TL_CTE']['media']['image'] = 'LazyContentImage';


/**
 * Purge jobs
 */
$GLOBALS['TL_PURGE']['folders']['lazy-images'] = [
    'callback' => ['\LazySizes', 'purge'],
    'affected' => ['system/cache/' . \LazySizes::LAZY_CACHE_PATH],
];


if (!function_exists('gmp_gcd')) {
	function gcd($a, $b) {
		return ($a % $b) ? \gcd($b, $a % $b) : $b;
	}
}