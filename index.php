<?php

# Startup tasks
require 'includes/startup.php';

# Connect to DB
$db = new PDO('mysql:host=localhost;dbname=demo', 'sa', '');
$registry->set ('db', $db);

# Load template object
$template = new Template($registry);
$registry->set ('template', $template);

# Load router
$router = new Router($registry);
$registry->set ('router', $router);
$router->setPath (site_path . 'controllers');

$router->delegate();

?>