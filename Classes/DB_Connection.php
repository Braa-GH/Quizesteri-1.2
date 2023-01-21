<?php
declare(strict_types=1);

abstract class DB_Connection{ //abstract

private static mysqli $connection;

#Enum
 const TYPE_TEACHER = 1;
 const TYPE_STUDENT = 2;

    public static function getConnection(): mysqli{
        $servername = "localhost";
        $username = "root";
        $password = "";
        $db = "Quizesteri";
        self::$connection = new mysqli($servername, $username, $password,$db);
        return self::$connection;
    }

    protected function last_id(): int{
        return mysqli_insert_id(self::$connection);
    }

    /* Functions:
     * CRUD Student
     * CRUD course
     * CRUD Quiz
     */


}