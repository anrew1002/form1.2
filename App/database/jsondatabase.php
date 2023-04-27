<?php

namespace App\Database;

use App\Database\Database;
use App\Database\CashableTrait;

class JsonDatabase extends Database
{
    use CashableTrait;
    private $format = ".json";

    public function save($data)
    {
        $filename = $this->getRandFilename();

        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        file_put_contents($this->dataSaveDir . "/" . $filename . $this->format,  $data);
        $this->cash($filename, $data);
        return $filename;
    }

    public function get(): array
    {

        $list_of_files = scandir($this->dataSaveDir);
        $list_of_json = array();

        foreach ($list_of_files as $filename) {
            if (is_file($this->dataSaveDir . "/" . $filename)) {
                $fileinfo = json_decode(file_get_contents($this->dataSaveDir . "\\" . $filename), true);
                $fileinfo["filename"] = $filename;
                $list_of_json[] = $fileinfo;
            }
        }

        return $list_of_json;
    }
}
