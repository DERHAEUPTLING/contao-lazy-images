# contao-lazy-images
Contao Plugin for lazyloading images with LazySizes.js without the disturbing reflow of the website, whenever an image is loaded.

Lazyloading images improves the website performance. Images no longer block the window.onload event. <br>
Visible images in the viewport are loaded first and therefore faster.

To prevent the website reflow whenever an image is loaded a the configurable placeholder protects the place the image would take.

Several options are available in the generic contao settings:
* Transparent placeholder <br/>
a tiny transparent data:image placeholder with the correct aspect ratio is inlined.
* Thumbnail placeholder<br/>
a thumbnail data:image placeholder with the correct aspect ratio is inlined.
* Intrinsic ratio (no placeholder needed) <br/>
An intrinsic ratio container is created to preserve the correct dimenions for the loading image <br/>
This is the fastest and the most correct approach. As intrinsic ratios relay on CSS it may conflict with your theme.
* Intrinsic ratio + thumbnail placeholder

The sizes of the placeholders and thumbnails can be adjusted.


Hint: while the picture syntax will work as normal, it is not supported by this pluing yet.


## Why preventing the reflow
![Alt text](../screenshot/image.jpg?raw=true)

While the reflow is ugly and consumes computing power it also causes issues with JavaScript layout solutions.

JavaScript libs like Masonry or GreenSock position / layout elements respectively their dimensions. <br>
If anything is changing those dimensions afterwards, like an image that got (lazy)loaded, the calculated layout breaks.

Using inline placeholders prevent those issues upfront.

## LazySizes
<a href="https://github.com/aFarkas/lazysizes" target="_blank">LazySizes</a> is a high performance and SEO friendly lazy loader for images (responsive and normal), iframes and more, that detects any visibility changes triggered through user interaction, CSS or JavaScript without configuration.
