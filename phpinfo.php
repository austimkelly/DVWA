<?php

// Define a constant variable DVWA_WEB_PAGE_TO_ROOT with an empty string as its value
define( 'DVWA_WEB_PAGE_TO_ROOT', '' );

// Include the dvwaPage.inc.php file, which contains functions and settings used throughout the application
require_once DVWA_WEB_PAGE_TO_ROOT . 'dvwa/includes/dvwaPage.inc.php';

// Initialize the DVWA page and set the authentication level to "authenticated"
dvwaPageStartup( array( 'authenticated') );

// Output the PHP configuration information of the server
phpinfo();

?>
