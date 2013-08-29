<<<<<<< HEAD
<?php

/**
 * User session check, for registered users
 * 
 * If you don't care about access,
 * please remove or comment following code
 * 
 */

if(!isset( $_SESSION['user'] )) {
	echo 'Access denied, check file '.basename(__FILE__);
	exit();
}

=======
<?php

/**
 * User session check, for registered users
 * 
 * If you don't care about access,
 * please remove or comment following code
 * 
 */

if(!isset( $_SESSION['user'] )) {
	echo 'Access denied, check file '.basename(__FILE__);
	exit();
}

>>>>>>> 95a5aa630384d3eafc101bc590da5106a25dbd92
?>