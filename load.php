<?php
// Absolute path indicates route directory, admin path indicates our admin folder, admin script path indicates our scripts folder
define('ABSPATH', __DIR__);
define('ADMIN_PATH', ABSPATH.'/admin');
define('ADMIN_SCRIPT_PATH', ADMIN_PATH.'/scripts');

// Load the database connection
ini_set('display_errors', 1);
require_once ABSPATH.'/config/database.php';
require_once ADMIN_SCRIPT_PATH.'/login.php';
require_once ADMIN_SCRIPT_PATH.'/functions.php';