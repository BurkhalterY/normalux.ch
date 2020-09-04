<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| CUSTOM CONSTANTS
|--------------------------------------------------------------------------
|
| These are constants defined specially for this application.
|
| Add line "include'MY_constants.php';" in constants.php to load these
*/

define('PER_PAGE', 30);

define('NORMAL_MODE', 1);
define('CHAIN_MODE', 2);
define('PROFILE_PICTURE', 3);
define('ROTATION_MODE', 5);
define('PIXEL_ART_MODE', 6);
define('BLINDED_MODE', 7);
define('INFINITY_MODE', 4);

/*
|--------------------------------------------------------------------------
| Access levels
|--------------------------------------------------------------------------
*/
define('ACCESS_LVL_GUEST', 1);
define('ACCESS_LVL_USER', 2);
define('ACCESS_LVL_MODO', 4);
define('ACCESS_LVL_ADMIN', 8);
