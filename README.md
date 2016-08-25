# contao-lazy-images
Contao Plugin for loading images with LazySizes.js while preventing reflow in the browser, when an image is loaded.

To prevent the reflow a transparent img placeholder is generated, that hast the exact image aspect ratio of the loading image.

## LazySizes
[LazySizes](https://github.com/aFarkas/lazysizes) is a high performance and SEO friendly lazy loader for images (responsive and normal), iframes and more, that detects any visibility changes triggered through user interaction, CSS or JavaScript without configuration.
