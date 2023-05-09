<?php

namespace App\Database;

use App\Database\DatabaseInterface;

class OneTXTDatabase implements DatabaseInterface
{
    protected $dataSaveDir;
    protected $filename;
    protected $delimiter;

    function __construct(array $columns, string $dataSaveDir = "txt_data", $filename = 'data.txt', $delimiter = "∷")
    {
        $this->dataSaveDir = $dataSaveDir;
        $this->filename = $filename;
        if (!is_dir($dataSaveDir)) {
            mkdir($dataSaveDir, 0777, true);
        };
        if (!is_file($dataSaveDir . "/" . $filename)) {
            file_put_contents(
                $dataSaveDir . "/" . $filename,
                implode($delimiter, $columns)
            );
        }
        $this->delimiter = $delimiter;
    }
    public function save(array $data)
    {
        $data = str_replace($this->delimiter, '', $data);
        file_put_contents(
            $this->dataSaveDir . "/" . $this->filename,
            "\n" . implode($this->delimiter, $data),
            FILE_APPEND
        );
        return $this->filename;
    }
    public function get(): array
    {
        $list_of_records =  explode("\n", file_get_contents($this->dataSaveDir . "\\" . $this->filename));
        foreach ($list_of_records as $key => $record) {
            $list_of_records[$key] = explode($this->delimiter, $record);
        };
        $columns = array_shift($list_of_records);
        $users = [];
        foreach ($list_of_records as $recordNumber => $record) {
            $user = [];
            foreach ($columns as $key => $column) {
                $user[$column] =  $list_of_records[$recordNumber][$key];
            }
            if ($record[array_key_last($record)] !== 'deleted') {
                $user["recordID"] = $recordNumber;
                $users[] = $user;
                debug_to_console("yesh");
            }
        }
        return $users;
    }
    public function delete($recordNumber)
    {
        $list_of_records =  explode("\n", file_get_contents($this->dataSaveDir . "\\" . $this->filename));
        foreach ($list_of_records as $key => $record) {
            // $list_of_records[$key] = explode($this->delimiter, $record);
            if ($key === ($recordNumber + 1)) {
                $list_of_records[$key] = $list_of_records[$key] . $this->delimiter . 'deleted';
            }
        };
        file_put_contents(
            $this->dataSaveDir . "/" . $this->filename,
            implode("\n", $list_of_records)
        );
    }
}
