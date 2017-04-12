<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */

// Palettes
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] = str_replace(',gdMaxImgHeight;', ',gdMaxImgHeight;{lazy_legend:hide},lazyPlaceholder;', $GLOBALS['TL_DCA']['tl_settings']['palettes']['default']);
$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'lazyPlaceholder';


// Subpalettes
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['lazyPlaceholder_transparent'] = 'lazyMaxWith';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['lazyPlaceholder_thumbnail'] = 'lazyThumbnailWidth';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['lazyPlaceholder_intrinsic'] = 'lazyWidthType';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['lazyPlaceholder_intrinsicThumb'] = 'lazyWidthType,lazyThumbnailWidth';


/**
 * System configuration
 */
$GLOBALS['TL_DCA']['tl_settings']['fields'] = array_merge($GLOBALS['TL_DCA']['tl_settings']['fields'], array
(
	'lazyPlaceholder' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['lazyPlaceholder'],
		'inputType'               => 'select',
		'options'                 => array('transparent', 'thumbnail', 'intrinsic', 'intrinsicThumb'),
		'eval'                    => array('chosen'=>true, 'submitOnChange'=>true, 'helpwizard'=>true),
		'reference'				  => &$GLOBALS['TL_LANG']['tl_settings'],
		'save_callback' => array
		(
			array('tl_lazySettings', 'flushLazyCache')
		)
	),
	'lazyMaxWith' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['lazyMaxWith'],
		'inputType'               => 'text',
		'eval'                    => array('tl_class'=>'w50')
	),
	'lazyThumbnailWidth' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['lazyThumbnailWidth'],
		'inputType'               => 'text',
		'eval'                    => array('tl_class'=>'w50')
	),
	'lazyWidthType' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['lazyWidthType'],
		'inputType'               => 'checkbox',
		'eval'                    => array('tl_class'=>'w50')
	)
		
));

class tl_lazySettings extends Backend
{
	/**
	 * Clean Lazy images cache
	 */
	public function flushLazyCache($varValue, DataContainer $dc)
	{
		$this->import('LazySizes');
		$this->LazySizes->purge();
		
		return $varValue;
	}
}