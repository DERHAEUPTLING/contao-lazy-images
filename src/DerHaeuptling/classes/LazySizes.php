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

namespace Contao;

class LazySizes
{
	/**
	 * Cache prefix
	 * @var string
	 */
	const LAZY_CACHE_KEY = 'LazyImages';
	
	/**
	 * File cache path
	 * @var string
	 */
	const LAZY_CACHE_PATH = 'lazy-images';
	
	/**
	 * Maximum allowed thumbnail width
	 * @var int
	 */
	const LAZY_THUMB_MAX_WIDTH = 300;
		
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
			
		// Try to load from mem cache
		$this->_image = $arrData['img'];
		$this->_makeCacheKey();
		
		if (\Cache::has($this->_cacheKey))
		{
			$placeholder = \Cache::get($this->_cacheKey);
			
		} else {
			
			// Try to load file cache
			$objFile = new \File($this->_getTargetPath('.bin'), true);
			
			if ($objFile->exists() && $objFile->size)
			{
				$placeholder = $objFile->getContent();
				
			} else {

				$placeholder = $this->_preparePlaceholder();
				
				// Store image to global cache
				$objFile->write($placeholder);
				
				$objFile->close();
			}

			\Cache::set($cacheKey, $placeholder);
		}

		// Set Lazy template
		$this->_initTemplate($objTemplate);
		
		// New template Data
		$arrData['img']['intrinsicWidthType'] = \Config::get('lazyWidthType');
		$arrData['img']['placeholder'] = 'data:image/png;base64,' .$placeholder;
		$arrData['img']['responsive'] = ($arrData['img']['src'] == $arrData['img']['srcset'])
			? false
			: true;

		$objTemplate->setData($arrData);
	}

	
	/**
	 * Create placeholder image
	 * 
	 * @param array $arrData
	 * @return string
	 */
	protected function _preparePlaceholder()
	{
		$width = $this->_image['width'];
		$height = $this->_image['height'];
		
		switch (\Config::get('lazyPlaceholder'))
		{
			// Transparent image
			case 'transparent' :

				$placeholder = static::_gdTransparentImage($width, $height);
				break;
		
			// Thumbnail image
			case 'thumbnail' :
		
				// Keep aspect ratio
				$height = null;
				if (\Config::get('lazyThumbnailWidth'))
				{
					$width = (\Config::get('lazyThumbnailWidth') > self::LAZY_THUMB_MAX_WIDTH) 
						? self::LAZY_THUMB_MAX_WIDTH 
						: \Config::get('lazyThumbnailWidth');
					
				} else {
					// Default thumbnail width
					$width = 50;
				}
		
				$placeholder = $this->_contaoThumbnailImage($width, $height);
				break;
		
			// Intrinsic ratio
			case 'intrinsic' :
		
				$placeholder = 'R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
				break;
		}

		return $placeholder;
	}
	
	protected function _makeCacheKey()
	{
		$width = $this->_image['width'];
		$height = $this->_image['height'];

		switch (\Config::get('lazyPlaceholder'))
		{
			case 'thumbnail' :
				$src = $this->_image['src'];
				return $this->_cacheKey = self::LAZY_CACHE_KEY. '_'. md5($src). '_'. $width. '_'. $height;

			default:
				return $this->_cacheKey = self::LAZY_CACHE_KEY. $width. '_'. $height;
		}
	}
		
	protected function _initTemplate(&$objTemplate)
	{
		switch (\Config::get('lazyPlaceholder'))
		{
			// Intrinsic Template
			case 'intrinsic' :
				$objTemplate->setName('picture_intrinsic');
				break;
				
			default:
				$objTemplate->setName('picture_lazy');
		}
	}
	
	protected function _getTargetPath($extension='.png')
	{
		return 'system/cache/' .self::LAZY_CACHE_PATH. '/' . $this->_cacheKey .$extension;
	}

	/**
	 * Contao Base 64 image
	 * 
	 * @param integer $width
	 * @param integer $height
	 * @return string
	 */
	protected function _contaoThumbnailImage($width, $height)
	{
		$imageObj = \Image::create($this->_image['src'], array($width, $height, $mode=''));
		$src = $imageObj->executeResize()->getResizedPath();
		$objFile = new \File(rawurldecode($src), true);
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
		$width = intval(round($width));
		$height = intval(round($height));
		
		// Use the greatest common divisor to reduce the size of image
		if (function_exists('gmp_gcd')) 
		{
			try {
				$gcd = strval(@gmp_gcd($width, $height));
			} catch (Exception $e) {
				$gcd = 1;
			}
		} else {
			$gcd = strval(\gcd($width, $height));
		}

		if ($gcd > 1) {
			$width = $width / $gcd;
			$height = $height / $gcd;
		}
			
		// Default maximum transparent width
		$lazyMaxWith = (\Config::get('lazyMaxWith'))
			? \Config::get('lazyMaxWith')
			: 200;
		
		$placeWidth = $width;
		$placeHeight = $height;
		if ($placeWidth > $lazyMaxWith)
		{
			$placeWidth = $lazyMaxWith;
			
			// Keep aspect ratio
			$placeHeight = max($height * $placeWidth / $width, 1);
			$placeHeight = round($placeHeight);
		}
		

		// Create the blank image
		$image = imagecreatetruecolor($placeWidth, $placeHeight);
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
	 * Purge Lazy Images cache
	 */
	public function purge()
	{
		$folder = new \Folder('system/cache/' .self::LAZY_CACHE_PATH);
		$folder->purge();
	
		// Add a log entry
		System::log('Purged the Lazy images cache', __METHOD__, TL_CRON);
	}

}