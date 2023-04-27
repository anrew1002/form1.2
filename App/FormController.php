<?php

namespace App;

use App\View;

class FormController
{
    protected $view;

    public function __construct()
    {
        $this->view = new View;
    }
    public function show()
    {
        $this->view->render('form', ['postData' => $_POST]);
    }
    public function store()
    {
        $data = [
            "name" => '',
            "lastname" => '',
            "email" => '',
            "phone" => '',
            "theme" => '',
            "money" => '',
            "mailing" => '',
            "processing" => '',
        ];

        if (!empty($errors)) {
            $this->view->render('form', [
                'postData' => $_POST,
                'errors' => $errors
            ]);
        } else {
            $dataDir = 'data';
            if (!is_dir($dataDir)) {
                mkdir($dataDir, 0777, true);
            };
            $filename = date("Ymd-His") . "-" . rand(100, 999) . '.json';
            while (is_file($dataDir . "/" . $filename)) {
                $filename = date("Ymd-His") . "-" . rand(100, 999) . '.json';
            };
            $data = json_encode($data, JSON_UNESCAPED_UNICODE);
            file_put_contents($dataDir . "/" . $filename,  $data);

            $this->view->render('form', [
                'postData' => $_POST,
                'succses' => true,
            ]);
        };
    }
    private function validate(array $data)
    {
        $errors = [];

        if (!empty($data["name"])) {
            $data["name"] = strip_tags($data["name"]);
        } else {
            $errors[] = "Не указано имя!";
        };

        if (!empty($data["lastname"])) {
            $data["lastname"] = strip_tags($data["lastname"]);
        } else {
            $errors[] = "Не указана фамилия!";
        };

        if (!empty($data["email"])) {
            $data["email"] = strip_tags($data["email"]);
        } else {
            $errors[] = "Не указан e-mail!";
        };

        if (!empty($data["phone"])) {
            $data["phone"] = strip_tags($data["phone"]);
        } else {
            $errors[] = "Не указан телефон!";
        };

        if (!empty($data["theme"])) {
            $data["theme"] = strip_tags($data["theme"]);
        } else {
            $errors[] = "Не указана тема конференции!";
        };
        if (!empty($data["money"])) {
            $data["money"] = strip_tags($data["money"]);
        } else {
            $errors[] = "Не указан способ оплаты";
        };
        if (!empty($data["mailing"])) {
            $data["mailing"] = strip_tags($data["mailing"]);
        } else {
            $errors[] = "Разрешите отправку вам уведомлений о конференции!";
        };

        if (!empty($data["processing"])) {
            $data["processing"] = strip_tags($data["processing"]);
        } else {
            $errors[] = "Разрешите обрабатывать ваши данные";
        };
        return $errors;
    }
}
