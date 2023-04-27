<?php

namespace App\Database;

interface DatabaseInterface
{
    public function save(array $data);

    public function get(): array;
}
