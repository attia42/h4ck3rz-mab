<?php

# Common functions
require 'includes/common.php';

# Startup tasks
require 'includes/startup.php';
$registry->set ('site_path', "/h4ck3rz-mab/");


# Connect to DB
__autoload("dal");
$db = new MySql("localhost","mab", "root", "");
$registry->set ('db', $db);

# Load template object
$template = new Template($registry);
$registry->set ('template', $template);

# Load router
$router = new Router($registry);
$registry->set ('router', $router);
$router->setPath (site_path . 'controllers');
$router->delegate();

__autoloadModel("phonebook");
$aModel = new Phonebook($registry);


//var_dump($registry);
?>