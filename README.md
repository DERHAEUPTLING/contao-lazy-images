[![No Maintenance Intended](http://unmaintained.tech/badge.svg)](http://unmaintained.tech/)
# DEPRECATED

This plugin had two major issues to solve:
1. lazy load images
2. prevent browser reflow whenever image dimensions become available
   
Both issues are now becomming solved by native browser support ... at least partially for now.
  

1. native lazy loading

   The loading attribute  `<img loading="lazy">` brings native lazy loading to the browser.  
   As of writing this, it is supported by Google Chrome & Microsoft Edge.  
   more info:  
   [caniuse.com](https://caniuse.com/#search=lazy%20loading)  
   [Firefox has plans for v75](https://bugzilla.mozilla.org/show_bug.cgi?id=1542784)  
   [Safari is working on this](https://bugs.webkit.org/show_bug.cgi?id=200764)
   
2. native image placeholder
   

 
 
  
  

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
An intrinsic ratio container is created to preserve the correct dimenions for the loading image. <br/>
This is the fastest and the most correct approach. As intrinsic ratios relay on CSS it may conflict with your theme.
* Intrinsic ratio + thumbnail placeholder

The sizes of the placeholders and thumbnails can be adjusted.


Hint:the picture syntax with its sources is supported since 3.0.0, but only work with thumbails, not with instrinsic ratios.


## Why preventing the reflow
![Alt text](../screenshot/image.jpg?raw=true)

While the reflow is ugly and consumes computing power it also causes issues with JavaScript layout solutions.

JavaScript libs like Masonry or GreenSock position / layout elements respectively their dimensions. <br>
If anything is changing those dimensions afterwards, like an image that got (lazy)loaded, the calculated layout breaks.

Using inline placeholders prevent those issues upfront.

## LazySizes
<a href="https://github.com/aFarkas/lazysizes" target="_blank">LazySizes</a> is a high performance and SEO friendly lazy loader for images (responsive and normal), iframes and more, that detects any visibility changes triggered through user interaction, CSS or JavaScript without configuration.
