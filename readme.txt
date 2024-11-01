=== WP Gallery ===
Contributors: wiredot, ghutchis
Tags: gallery, photos
Requires at least: 4.6
Tested up to: 4.7
Stable tag: 4.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Replace WP Gallery tags with links and images in your Gallery albums.

== Description ==

This WordPress plugin will help integrate your Gallery (gallery.sf.net) albums and photos into your WP blog.

This plug was inspired by the MT plugin GalleryLink and the Blosxom galleryref plugin. Please make sure to edit the WPG_GALLERY_BASE and WPG_ALBUM_BASE bits below or use the WP-Plugin Manager.

It also uses bits for QuickLinks in the post editor from the Edit Button Framework: http://www.asymptomatic.net/wp-hacks

<WPGallery>album/photo</WPGallery>     => 
    <a href="" class="gallery_link"><img src="" class="gallery_image" /></a>
    
The <img> tag will be the "thumbnail" size.

You can also use a direct PHP function call if you prefer:
<?php echo wpgallery_link( $album, $photo ) ?>

The direct function call can also handle link and image CSS classes, etc.

<?php echo wpgallery_link($album, $photo, $link_class='gallery_link', $image_class='gallery_image', $img_alt='', $link_title='') ?>

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wp-gallery` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
