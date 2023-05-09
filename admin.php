<?php
include "init.php";
include "dbconnect.php";

use App\AdminController;

$admin_controller = new AdminController($database);


switch (getenv('REQUEST_METHOD')) {

    case "GET":
        $admin_controller->show();
        break;
    case "POST":
        $admin_controller->delete();
        break;
}
