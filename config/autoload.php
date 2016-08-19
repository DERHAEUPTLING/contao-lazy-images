<?php

/**
 * Lazy Images for Contao Open Source CMS
 *
 * @copyright  DerHaeuptling 2016
 * @author     Martin Schwenzer <mail@derhaeuptling.com>
 * @author     Sebastijan Ribarić <sebastijan.ribaric@media-8.org>
 * @package    Lazy Images
 * @license    http://opensource.org/licenses/lgpl-3.0.html 
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Contao\LazySizes'            => 'system/modules/lazy-images/library/DerHaeuptling/classes/LazySizes.php',

	// Elements
	'Contao\LazyContentText'            => 'system/modules/lazy-images/elements/LazyContentText.php',
	'Contao\LazyContentImage'           => 'system/modules/lazy-images/elements/LazyContentImage.php'
));


/**
 * Register the templates
*/
TemplateLoader::addFiles(array
(
	'picture_lazy'      => 'system/modules/lazy-images/templates'
		
));
