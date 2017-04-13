# contao-lazy-images
Contao Plugin for lazyloading images with LazySizes.js without the disturbing reflow of the website, whenever an image is loaded.

Lazyloading images improves the website performance. Images no longer block the window.onload event. <br>
Visible images in the viewport are loaded first and therefore faster.

To prevent the website reflow whenever an image is loaded a the placeholder protects the place the image would take.

Several Options are available:
- Transparent placeholder
a tiny transparent data:image placeholder with the correct aspect ratio is inlined.
- Thumbnail placeholder
- Intrinsic ratio (no placeholder)
- Intrinsic ratio + thumbnail placeholder



## Why preventing the reflow
![Alt text](../screenshot/image.jpg?raw=true)

While the reflow is ugly and consumes computing power it also causes issues with JavaScript layout solutions.

JavaScript libs like Masonry or GreenSock position / layout elements respectively their dimensions. <br>
If anything is changing those dimensions afterwards, like an image that got (lazy)loaded, the calculated layout breaks.

Using inline placeholders prevent those issues upfront.

## LazySizes
<a href="https://github.com/aFarkas/lazysizes" target="_blank">LazySizes</a> is a high performance and SEO friendly lazy loader for images (responsive and normal), iframes and more, that detects any visibility changes triggered through user interaction, CSS or JavaScript without configuration.
