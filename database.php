<?php

class Database
{
    protected $conn;

    public function __construct(){
        $this->conn = new mysqli("localhost", "root", "", "info5bia_targhe");
    }

    public function execute_query(string $sql){
        $result = $this->conn->query($sql);
        return $result;
    }
}