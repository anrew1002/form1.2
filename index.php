<?php

include "init.php";
include "dbconnect.php";

use App\FormController;
use App\Auth;

$form_controller = new FormController($database);
$authPlugin = new Auth;

switch (getenv('REQUEST_METHOD')) {

	case "GET":
		$form_controller->show();
		break;
	case "POST":
		$form_controller->store();
		break;
}
