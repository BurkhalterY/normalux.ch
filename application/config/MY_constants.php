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

define('PER_PAGE', 20);

define('NORMAL_MODE', 1);
define('CHAIN_MODE', 2);
define('ROTATION_MODE', 5);
define('PIXEL_ART_MODE', 6);
define('BLINDED_MODE', 7);
define('INFINITY_MODE', 4);

define('ALL_MODES', array(1, 2, 4, 5, 6, 7));

/*
|--------------------------------------------------------------------------
| Access levels
|--------------------------------------------------------------------------
*/
define('ACCESS_LVL_GUEST', 1);
define('ACCESS_LVL_USER', 2);
define('ACCESS_LVL_MODO', 4);
define('ACCESS_LVL_ADMIN', 8);
