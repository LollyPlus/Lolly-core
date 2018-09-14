<?php

namespace Lolly\Model;


use Medoo\Medoo;

class DataBase{
    public static function Medoo(){
        $config = require Lolly . "/config/model/medoo.php";
        return new Medoo($config);
    }
}