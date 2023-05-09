<?php

namespace App;

use App\Database\OneTXTDatabase;
use App\Request;

class Auth
{

    protected $authed = false;
    protected $database;
    protected $request;

    function __construct()
    {
        $this->request = new Request;
        $this->database = new OneTXTDatabase(["login", "password", "is_admin"], 'txt_data', "auth_data.txt");
        session_start();
        $this->validate();
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
}
