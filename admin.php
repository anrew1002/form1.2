<?php
include "init.php";
include "dbconnect.php";

use App\AdminController;
use App\Auth;

$admin_controller = new AdminController($database);
$authPlugin =  Auth::getInstance();


if ($authPlugin->is_authed()) {
    switch (getenv('REQUEST_METHOD')) {
        case "GET":
            $admin_controller->show();
            break;
        case "POST":
            $admin_controller->delete();
            break;
    }
} else {
    switch (getenv('REQUEST_METHOD')) {
        case "GET":
            $admin_controller->login_show();
            break;
        case "POST":
            $admin_controller->login_post();
            break;
    }
}
