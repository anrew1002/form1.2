<?php

namespace App;

use App\View;
use App\Request;
use App\Database\DatabaseInterface;
use App\Auth;
use DateTime;

class AdminController
{
    protected $view;
    protected $request;
    protected $database;
    protected $authPlugin;

    public function __construct(DatabaseInterface $database)
    {
        $this->view = new View;
        $this->request = new Request;
        $this->authPlugin = new Auth;
        $this->database = $database;
    }
    public function login_show()
    {
        $this->view->render('login');
    }
    public function login_post()
    {
        $postData = $this->request->getPostData();

        if ($postData['username'] === 'admin') {
            if (sha1($postData['password']) === 'd033e22ae348aeb5660fc2140aec35850c4da997') {
                setcookie('password', 'adminTOKEN', time() + 3000, httponly: true);
            }
        }
        header('Location: admin.php');
    }
    public function show()
    {



        $getData = $this->request->getGetData();

        // debug_to_console($getData);
        if (!empty($getData) && isset($getData["logout"])) {
            $this->authPlugin->close_session();
        }

        //функция поиска
        if (!empty($getData) && ($getData["search"] ?? "") !== "") {
            $search_string = strip_tags($getData["search"]);
        }

        $list_of_users = $this->database->get();
        if (!empty($search_string)) {
            $list_of_search = [];
            foreach ($list_of_users as $user) {
                if (mb_stripos($user["name"] . $user["lastname"], $search_string) !== false) {
                    $list_of_search[] = $user;
                }
            }

            $this->view->render('adminlist', ["data" => $list_of_search]);
            return;
        }

        $this->view->render('adminlist', ["data" => $list_of_users]);
        return;
    }
    public function delete()
    {
        foreach ($this->request->getPostData() as $filename => $bool) {
            // unlink("data/" . rtrim($filename, "_json") . ".json");
            $this->database->delete((int)($filename));
        }
        header('Location: admin.php');
    }
}
