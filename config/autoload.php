<?php

/**
 * Lazy Images for Contao Open Source CMS
 *
 * @copyright  DerHaeuptling 2016
 * @author     Martin Schwenzer <mail@derhaeuptling.com>
 * @author     Sebastijan Ribarić <sebastijan.ribaric@media-8.org>
 * @author     Kamil Kuzminski <kamil.kuzminski@codefog.pl>
 * @package    Lazy Images
 * @license    http://opensource.org/licenses/lgpl-3.0.html 
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Contao\LazySizes'            => 'system/modules/zz_lazy-images/library/DerHaeuptling/classes/LazySizes.php',

	// Elements
	'Contao\LazyContentText'            => 'system/modules/zz_lazy-images/elements/LazyContentText.php',
	'Contao\LazyContentImage'           => 'system/modules/zz_lazy-images/elements/LazyContentImage.php',
	//'Contao\LazyContentGallery'         => 'system/modules/zz_lazy-images/elements/LazyContentGallery.php',
));


/**
 * Register the templates
*/
TemplateLoader::addFiles(array
(
	'picture_lazy'      => 'system/modules/zz_lazy-images/templates'
		
));
