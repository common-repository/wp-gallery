array(
"gallery_base" => array("caption"=>"The base Gallery installation URL for album links:", 
                        "default"=>"http://www.example.com/gallery",
                        "overwrite"=>false
                        ),
"album_base" => array("caption"=>"The album URL for <img> tags and direct image links:", 
                        "default"=>"http://www.example.com/albums",
                        "overwrite"=>false
                        ),
"direct_link" => array("caption"=>"Link directly to the image or to the album of the image?", 
                        "default"=> "false",
                        "type" => "menu",
                        "options" => array("false"=>"Album",
                                            "true"=>"Image")
                        ),
"thumb_size" => array("caption"=>"Will image links in entries be to thumbnails or full-sized images?", 
                        "default"=> "true",
                        "type" => "menu",
                        "options" => array("true"=>"Thumbnail",
                                            "false"=>"Full-Sized")
                        ),
"photo_ext" => array("caption"=>"The default photo extension:", 
                        "default"=>"jpg"
                        ),
"link_class" => array("caption"=>"The CSS class used for links:", 
                        "default"=>"gallery_link"
                        ),
"img_class" => array("caption"=>"The CSS class used for img tags:", 
                        "default"=>"gallery_image"
                        ),
"img_alt" => array("caption"=>"The &quot;alt&quot; attribute used in img tags:", 
                        "default"=>"[img]"
                        ),
"link_title" => array("caption"=>"The &quot;title&quot; attribute used in  links:", 
                        "default"=>""
                        )
);