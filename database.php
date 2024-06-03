<?php

class Database
{
    protected static  $conn;

    public static function connect(){
        self::$conn = new mysqli("localhost", "root", "root", "info5bia_targhe");
    }

    public static function query(string $sql){
        return self::$conn->query($sql);
    }
}