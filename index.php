<?php
// Require App class
define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/App.php');

// App initialization
$app = new App();
$app->run();