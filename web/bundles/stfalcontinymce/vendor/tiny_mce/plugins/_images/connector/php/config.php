<<<<<<< HEAD
<?php

//Site root dir
define('DIR_ROOT',		$_SERVER['DOCUMENT_ROOT'] . '/web');
//Images dir (root relative)
define('DIR_IMAGES',	'/uploads/');
//Files dir (root relative)
define('DIR_FILES',		'/web/uploads/');

define('IMG_URL',		'/uploads/');


//Width and height of resized image
define('WIDTH_TO_LINK', 100);
define('HEIGHT_TO_LINK', 100);

//Additional attributes class and rel
define('CLASS_LINK', 'lightview');
define('REL_LINK', 'lightbox');

date_default_timezone_set('Asia/Yekaterinburg');

?>
=======
<?php

//Site root dir
define('DIR_ROOT',		$_SERVER['DOCUMENT_ROOT'] . '');
//Images dir (root relative)
define('DIR_IMAGES',	'/web/uploads/');   //path to left dir
//Files dir (root relative)
define('DIR_FILES',		'/uploads/');

define('IMG_URL',		'/web/uploads/images/');    //path to show image and return to editor

//Width and height of resized image
define('WIDTH_TO_LINK', 100);
define('HEIGHT_TO_LINK', 100);

//Additional attributes class and rel
define('CLASS_LINK', 'lightview');
define('REL_LINK', 'lightbox');

date_default_timezone_set('Asia/Yekaterinburg');

?>
>>>>>>> 95a5aa630384d3eafc101bc590da5106a25dbd92
