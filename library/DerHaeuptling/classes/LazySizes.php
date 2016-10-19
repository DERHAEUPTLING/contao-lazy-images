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

class LazySizes
{
	/**
	 * Cache prefix
	 * @var string
	 */
	const LAZY_CACHE_KEY = 'LazyImages';
	
	/**
	 * Working empty image
	 * @var string
	 */
	const PNG_TRANSPARENT_IMAGE = 'system/modules/lazy-images/assets/transparent.png';

	/**
	 * File cache path
	 * @var string
	 */
	const LAZY_CACHE_PATH = 'lazy-images';
	
	protected $_image;
	
	protected $_cacheKey;
	
	public function init($objTemplate)
	{
		if ('picture_default' != $objTemplate->getName())
			return;
		
		$arrData = $objTemplate->getData();
		
		// No images to render
		if (empty($arrData['img']))
			return;

		// Check if is LazyLoader disabled
		if (isset($arrData['lazyDisable']) && $arrData['lazyDisable'])
			return;
			
		// Use Lazy template
		$objTemplate->setName('picture_lazy');
		
		// Try to load from mem cache
		$this->_image = $arrData['img'];
		$width = $this->_image['width'];
		$height = $this->_image['height'];
		$this->_cacheKey = self::LAZY_CACHE_KEY .$width .'_' .$height;

		if (\Cache::has($this->_cacheKey))
		{
			$transparentPlaceholder = \Cache::get($this->_cacheKey);
			
		} else {
			
			// Try to load file cache
			$objFile = new \File($this->_getTargetPath('.bin'), true);
			
			if ($objFile->exists())
			{
				$transparentPlaceholder = $objFile->getContent();
				
			} else {

				// Prepare transparent image
				$transparentPlaceholder = (function_exists('gmp_gcd') && function_exists('gmp_strval'))
					? static::_gdTransparentImage($width, $height)
					: $this->_contaoTransparentImage();
				
				// Store image to global cache
				$objFile->write($transparentPlaceholder);
				$objFile->close();
			}

			\Cache::set($cacheKey, $transparentPlaceholder);
		}
		
		// New template arrData
		$arrData['img']['placeholder'] = 'data:image/png;base64,' .$transparentPlaceholder;
		$arrData['img']['responsive'] = ($arrData['img']['src'] == $arrData['img']['srcset'])
			? false
			: true;

		$objTemplate->setData($arrData);
		
	}
	
	protected function _getTargetPath($extension='.png')
	{
		return 'system/cache/' .self::LAZY_CACHE_PATH. '/' . $this->_cacheKey .$extension;
	}

	/**
	 * Contao Base 64 png image
	 *
	 * @param string $sourceImg
	 * @return string
	 */
	protected function _contaoTransparentImage()
	{
		$width = $this->_image['width'];
		$height = $this->_image['height'];
		
		\Files::getInstance()->copy(self::PNG_TRANSPARENT_IMAGE, $this->_getTargetPath());
		\Image::resize($this->_getTargetPath(), $width, $height, $mode='');
		
		$objFile = new \File($this->_getTargetPath(), true);
		$imageContent = $objFile->getContent();
		$objFile->delete();

		return base64_encode($imageContent);
	}
	
	/**
	 * GD Base 64 png image
	 * 
	 * @author Kamil Kuzminski <kamil.kuzminski@codefog.pl>
	 * @param integer $width
	 * @param integer $height
	 * @return string
	 */
	protected static function _gdTransparentImage($width, $height)
	{
		// Use the greatest common divisor to reduce the size of image
		if (function_exists('gmp_gcd') && function_exists('gmp_strval')) {
			$gcd = gmp_strval(gmp_gcd($width, $height));
	
			if ($gcd > 1) {
				$width = $width / $gcd;
				$height = $height / $gcd;
			}
		}
		
		// Create the blank image
		$image = imagecreatetruecolor($width, $height);
		imagesavealpha($image, true);
		$transparency = imagecolorallocatealpha($image, 0, 0, 0, 127);
		imagefill($image, 0, 0, $transparency);
	
		// Get the image content
		ob_start();
		imagepng($image);
		$imageContent = ob_get_contents();
		ob_end_clean();
	
		// Destroy the image
		imagedestroy($image);
		
		return base64_encode($imageContent);
	}
	
	/**
	 * Purge the data
	 */
	public function purge()
	{
		$folder = new \Folder('system/cache/' .self::LAZY_CACHE_PATH);
		$folder->purge();
	
		// Add a log entry
		System::log('Purged the Lazy images cache', __METHOD__, TL_CRON);
	}
	
	
	
}
	