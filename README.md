# contao-lazy-images
Contao Plugin for lazy loading images with LazySizes.js while preventing the reflow in browsers, whenever an image is loaded.

Lazyloading images improves the website performance. Images do not block the window.onload event. 
Visible images that are in the viewport are loaded first.

To prevent the reflow a transparent data:image placeholder with the correct aspect ratio is inlined.

## why preventing the reflow
![Alt text](../screenshot/image.jpg?raw=true)

While the reflow is ugly and consumes computing power it also prevents issues with JavaScript layout solutions.

JS libs like Masonry or GreenSock measure dimensions and than layout elements.
If anything is changing layout afterwards, like an image that got (lazy)loaded, the JS layout gets messed up.
In such cases the JS functions have to be updated any time an image is loaded.

Inlining a tiny placeholder prevents this issue from happening upfront.


## LazySizes
<a href="https://github.com/aFarkas/lazysizes" target="_blank">LazySizes</a> is a high performance and SEO friendly lazy loader for images (responsive and normal), iframes and more, that detects any visibility changes triggered through user interaction, CSS or JavaScript without configuration.
