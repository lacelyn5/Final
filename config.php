<?php
define('DATA_HOST', 'db'); 
define('DATA_NAME', 'event_management');
define('DATA_USER', 'Lacelyn'); 
define('DATA_PASS', 'maximkerno'); 
spl_autoload_register(function ($class) {
    include __DIR__ . '/classes/' . $class . '.php';
});
