<?php
/*
Plugin Name: WP Gallery
Version: 999
Plugin URI: http://geoffhutchison.net/blog/categories/wp-plugins/
Author: Geoff Hutchison
Author URI: http://geoffhutchison.net/
Description: Replace WP Gallery tags with links and images in your Gallery albums.

NOTES:

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

*/

/* TODO:
    Support for more URL formats (G2, G1 without mod_rewrite...)
    Attributes in the <WPGallery></WPGallery> tags to change 
*/

/*
Copyright (c) 2004-2005 by Geoffrey Hutchison    http://geoffhutchison.net/

Available under the GNU General Public License (GPL) version 2 or later.
http://www.gnu.org/licenses/gpl.html

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

/* User Constants - Change to suit you */
/*   also can be changed with the WP-Manager plugin in a nice interface */
define ('WPG_GALLERY_BASE', 'http://www.example.com/gallery'); // The base Gallery installation for album links
define ('WPG_ALBUM_BASE', 'http://www.example.com/albums'); // The album URL for <img> tags

/* If you want to allow <IMG> tags (like WPGallery output) in comments, you'll probably need to uncomment these lines. */
// $my_allowedtags = array('img' => array('src' => array()));
// $allowedtags = array_merge($allowedtags, $my_allowedtags);

// You shouldn't need to change anything below this unless you want to do so.

function gallery_link($text, $case_sensitive=false) {
    $preg_flags = ($case_sensitive) ? 'e' : 'ei';
	
    $output = preg_replace("'<WPGallery>([^\/]*)/([^\.<]*)\.*([^<]*)</WPGallery>'$preg_flags", "wpgallery_link('\\1', '\\2', '', '', '', '', '\\3')", $text);

	return $output;
} //end gallery_link()

function wpgallery_link($album, $photo, 
    $link_class='gallery_link', $img_class='gallery_image', 
    $img_alt='[img]', $link_title='', $photo_extension='',
    $direct_link='false', $thumb_size='true') {

    // read in defaults from WP-Manager plugin
    if (is_file(ABSPATH . "wp-content/wp-gallery/wp-gallery_prefs.php")) {
    	include(ABSPATH . "wp-content/wp-gallery/wp-gallery_prefs.php");
    }
    
    // check configuration variables and add appropriate HTML
    $gallery_base = ($gallery_base) ? "$gallery_base" : WPG_GALLERY_BASE;
    $album_base = ($album_base) ? "$album_base" : WPG_ALBUM_BASE;
    
    $img_alt = ($img_alt) ? " alt=\"$img_alt\" " : "";
    $img_class = ($img_class) ? " class=\"$img_class\" " : "";
    $link_title = ($link_title) ? " title=\"$link_title\" " : "";
    $link_class = ($link_class) ? " class=\"$link_class\" " : "";
    $photo_ext = ($photo_extension) ? "$photo_extension" : "$photo_ext";
    $img_size = ($thumb_size) ? ".thumb." : "."; // full-size doesn't have an initial period.

    if ($direct_link) { // direct link to image
        $output = '<a href="'.$album_base.'/'.$album.'/'.$photo.'.'.$photo_ext;
    } else { // link to album
        $output = '<a href="'.$gallery_base.'/'.$album.'/'.$photo;
    }

    // The rest is the same for both direct links and album links
    $output = $output.'"'.$link_class.$link_title.'><img src="'.$album_base.'/'.$album.'/'.$photo.$img_size.$photo_ext.'"'.$img_class.$img_alt.' /></a>';

    return $output;
}

add_filter('the_content', 'gallery_link');
add_filter('the_excerpt', 'gallery_link');
// These apparently need high priority to properly filter the comments
add_filter('comment_text', 'gallery_link', 0);
add_filter('comment_excerpt', 'gallery_link', 0);

// This adds support for up2date: http://blog.vtsportbike.net/archives/category/wordpress-plugins/
if ( function_exists( 'u2d_register_plugin' ) ) {
    u2d_register_plugin( "WP Gallery", "http://geoffhutchison.net/files/wp-gallery.version", "0.33", 10);
}

// This is all for the WPGallery quicklink buttons
add_filter('admin_footer', 'wpgallery_quicklink_callback');

function wpgallery_quicklink_callback() {
	if (strpos($_SERVER['REQUEST_URI'], 'post.php')) {
?>
<script language="JavaScript" type="text/javascript"><!--
var toolbar = document.getElementById("ed_toolbar");
<?php
	edit_insert_button("WPGallery", "wpgallery_handler", "WPGallery");	
?>

var state_wpgallery_button = true;

function wpgallery_handler() {
	if(state_wpgallery_button) {
		edInsertContent(edCanvas, '<WPGallery>');
	} else {
		edInsertContent(edCanvas, '</WPGallery>');
	}
	state_wpgallery_button = !state_wpgallery_button;
}

//--></script>
<?php
	}
}

if (!function_exists('edit_insert_button')) {
	//edit_insert_button: Inserts a button into the editor
	function edit_insert_button($caption, $js_onclick, $title = '') {
	?>
	if (toolbar) {
		var theButton = document.createElement('input');
		theButton.type = 'button';
		theButton.value = '<?php echo $caption; ?>';
		theButton.onclick = <?php echo $js_onclick; ?>;
		theButton.className = 'ed_button';
		theButton.title = "<?php echo $title; ?>";
		theButton.id = "<?php echo "ed_{$caption}"; ?>";
		toolbar.appendChild(theButton);
	}
	<?php
	}
}
