<?php

include "init.php";
include "dbconnect.php";

use App\FormController;

$form_controller = new FormController($database);

switch (getenv('REQUEST_METHOD')) {

	case "GET":
		$form_controller->show();
		break;
	case "POST":
		$form_controller->store();
		break;
}
