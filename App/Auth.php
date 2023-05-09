<?php

namespace App;

use App\Database\OneTXTDatabase;
use App\Request;

class Auth
{
    protected $authed = false;
    protected $database;
    protected $request;
    protected static $instance;

    function __construct()
    {
        $this->request = new Request;
        $this->database = new OneTXTDatabase(["login", "password", "is_admin"], 'txt_data', "auth_data.txt");
        session_start();
        $this->validate();
        if (isset($_SESSION['timestamp'])) {
            if ((time() - $_SESSION['timestamp']) >= 300) {
                $this->authed = false;
                unset($_SESSION['timestamp']);
            } else {
                $_SESSION['timestamp'] = time();
            }
        } else {
            $_SESSION['timestamp'] = time();
        }
    }
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    public function validate()
    {
        $password = $_COOKIE['password'] ?? null;
        if (!empty($password)) {
            if ($password === 'adminTOKEN') {
                $this->authed = true;
            }
        }
    }
    public function is_authed()
    {
        return $this->authed;
    }
    public function close_session()
    {
        setcookie('password', '', -100);
        setcookie(session_name(), '', -100);
        session_unset();
        session_destroy();
        $_SESSION = array();
        header('Location: admin.php');
    }
}
