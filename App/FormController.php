<?php

namespace App;

use App\View;
use App\Request;
use App\Database\DatabaseInterface;
use DateTime;

class FormController
{
    protected $view;
    protected $request;
    protected $data;
    protected $errors;
    protected $database;
    protected $allowed_data;


    public function __construct(DatabaseInterface $database)
    {
        $this->view = new View;
        $this->request = new Request;
        $this->database = $database;
        $this->errors = [];
    }
    public function show()
    {
        $this->view->render('form', ['postData' => $this->request->getPostData()]);
    }
    public function store()
    {
        // print_r($this->request->getPostData());
        $postData =   $this->request->getPostData();

        $this->errors = $this->validate($postData);

        if (!empty($this->errors)) {
            $this->view->render('form', [
                'postData' => $this->data,
                'errors' => $this->errors,
            ]);
        } else {
            $dataDir = 'data';
            $this->data[] = getenv('REMOTE_ADDR');
            $date = new DateTime;
            $this->data[] = date("Y-m-d H:i:s", $date->getTimestamp());
            // if (!is_dir($dataDir)) {
            //     mkdir($dataDir, 0777, true);
            // };
            // $filename = date("Ymd-His") . "-" . rand(100, 999) . '.json';
            // while (is_file($dataDir . "/" . $filename)) {
            //     $filename = date("Ymd-His") . "-" . rand(100, 999) . '.json';
            // };
            // $data = json_encode($this->data, JSON_UNESCAPED_UNICODE);
            // file_put_contents($dataDir . "/" . $filename,  $data);
            $this->database->save($this->data);

            $this->view->render('form', [
                'postData' => $this->data,
                'succses' => true,
            ]);
        };
    }
    private function validate(array $getData)
    {
        $this->data = [
            "name" => '',
            "lastname" => '',
            "email" => '',
            "phone" => '',
            "theme" => '',
            "money" => '',
            "mailing" => '',
            "processing" => '',
        ];

        $this->errors = [];

        if (!empty($getData["name"])) {
            $this->data["name"] = strip_tags($getData["name"]);
        } else {
            $this->errors[] = "Не указано имя!";
        };

        if (!empty($getData["lastname"])) {
            $this->data["lastname"] = strip_tags($getData["lastname"]);
        } else {
            $this->errors[] = "Не указана фамилия!";
        };

        if (!empty($getData["email"])) {
            $this->data["email"] = strip_tags($getData["email"]);
        } else {
            $this->errors[] = "Не указан e-mail!";
        };

        if (!empty($getData["phone"])) {
            $this->data["phone"] = strip_tags($getData["phone"]);
        } else {
            $this->errors[] = "Не указан телефон!";
        };

        if (!empty($getData["theme"])) {
            $this->data["theme"] = strip_tags($getData["theme"]);
        } else {
            $this->errors[] = "Не указана тема конференции!";
        };
        if (!empty($getData["money"])) {
            $this->data["money"] = strip_tags($getData["money"]);
        } else {
            $this->errors[] = "Не указан способ оплаты";
        };
        if (!empty($getData["mailing"])) {
            $this->data["mailing"] = strip_tags($getData["mailing"]);
        } else {
            $this->errors[] = "Разрешите отправку вам уведомлений о конференции!";
        };

        if (!empty($getData["processing"])) {
            $this->data["processing"] = strip_tags($getData["processing"]);
        } else {
            $this->errors[] = "Разрешите обрабатывать ваши данные";
        };

        return $this->errors;
    }
}
