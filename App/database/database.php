<?php

namespace App\Database;

use App\Database\DatabaseInterface;

abstract class Database implements DatabaseInterface
{
    protected $dataSaveDir;

    function __construct(string $dataSaveDir = "data")
    {
        $this->dataSaveDir = $dataSaveDir;
        echo $this->dataSaveDir;
    }
    public function getDataSaveDir()
    {
        return $this->dataSaveDir;
    }

    protected function getRandFilename(): string
    {
        if (!is_dir($this->dataSaveDir)) {
            mkdir(
                $this->dataSaveDir,
                0777,
                true
            );
        };
        $filename = date("Ymd-His") . "-" . rand(100, 999);
        while (is_file($this->dataSaveDir . "/" . $filename)) {
            $filename = date("Ymd-His") . "-" . rand(100, 999);
        };
        return $filename;
    }

    abstract public function save(array $data);

    abstract public function get(): array;
}
