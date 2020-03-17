[![No Maintenance Intended](http://unmaintained.tech/badge.svg)](http://unmaintained.tech/)
# DEPRECATED

This plugin was made to do two things:
1. lazy load images
2. prevent browser reflow whenever image dimensions become available
   
Both are now becoming solved by native browser support ... at least partially for now.
  

1. native lazy loading

   The loading attribute  `<img loading="lazy">` brings native lazy loading to the browser.  
   As of writing this, it is supported by Google Chrome & Microsoft Edge.  
   more info:  
   <a href="https://caniuse.com/#search=lazy%20loading" target="_blank">caniuse.com</a>  
   <a href="https://bugzilla.mozilla.org/show_bug.cgi?id=1542784" target="_blank">Firefox has plans for v75</a>  
   <a href="https://bugs.webkit.org/show_bug.cgi?id=200764" target="_blank">Safari is working on it too</a>   

2. native image placeholder

   Img with and height attributes still work perfectly to paint a placeholder into which the image will be loaded.  
   But whenever we added responsive css to our images, like by adding `style="width: 100%; height: auto;"`, the browser where unable to paint the placeholder.  
   
   But in the meantime, beginning with Firefox, the broswers now utilize the with and height img attributes to calculate an aspect ratio. With this aspect ratio modern browsers can now paint a placeholder.  
   (actually this is the same, what this plugin does and the <a href="https://alistapart.com/article/creating-intrinsic-ratios-for-video/" target="_blank">intrinsic ratio </a> trick did back in 2009.)  
   
   Source: <a href="https://www.youtube.com/watch?v=4-d_SoCHeWE" target="_blank">https://www.youtube.com/watch?v=4-d_SoCHeWE</a> 



Thanks for having used this Plugin!
   

 
 
  
  

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
