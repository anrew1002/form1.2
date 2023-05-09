<?php

namespace App\Database;

use App\Database\Database;

class TextDatabase extends Database
{
    private $format = ".txt";

    public function save(array $data): string
    {
        $filename = $this->getRandFilename();

        file_put_contents(
            $this->dataSaveDir . "/" . $filename . $this->format,
            implode("|", $data)

        );
        return $filename;
    }
    public function get(): array
    {

        $list_of_files = scandir($this->dataSaveDir);
        $list_of_arrays = array();

        foreach ($list_of_files as $filename) {
            if (is_file($this->dataSaveDir . "/" . $filename)) {
                $fileinfo = explode(",", file_get_contents($this->dataSaveDir . "\\" . $filename));
                $list_of_arrays[] = $fileinfo;
            }
        }

        return $list_of_arrays;
    }
    public function delete($recordID)
    {
    }
}
