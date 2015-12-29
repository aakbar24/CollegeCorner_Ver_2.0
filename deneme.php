<?php

// Loads the class
require 'extras/Browscap.php';

// Creates a new Browscap object (loads or creates the cache)
$bc = new Browscap('extras/cache');

// Gets information about the current browser's user agent
$current_browser = $bc->getBrowser();

// Output the result
echo '<pre>'; // some formatting issues ;)
print_r($current_browser);
echo '</pre>';

?>
