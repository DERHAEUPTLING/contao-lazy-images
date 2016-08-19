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

namespace Contao;


class LazyContentText extends \ContentText
{
	/**
	 * Generate the content element
	 */
	public function compile()
	{
		parent::compile();
		
		// LazyDisable indicator for use in picture template
		$arrData = $this->Template->getData();
		$arrData['picture']['lazyDisable'] = $this->arrData['lazyDisable'];
		$this->Template->setData($arrData);

	}
}
