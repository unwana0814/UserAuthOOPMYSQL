<?php

require_once 'classes/Dbh.php';
require_once 'classes/UserAuth.php';
require_once 'classes/Route.php';

$route = new formController();

$route->handleForm();