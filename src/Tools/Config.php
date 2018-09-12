<?php

namespace Lolly\Tools;

class Config{
    public static function ReadConf($name){
        if(is_file(Lolly . "/config/" . $name . ".php")){
            return require Lolly . "/config/" . $name . ".php";
        }else{
            return null;
        }
    }
}